<?php
class WebBase extends Phalcon\Mvc\Controller{
   
    public $smarty = null;
    public $multicache = null;
    public $basecommon = null;
    public $session = null;
    public $indexModel=null;
    public $page=null;
    public $_domainArr = array('http://comic.phalcon.ck101.com');
    public $ckAdminList = array(2417399,2208551,2456055,2896262);
    protected $_pageProg        = null;
    protected $_pageMethod      = null;
    protected $_isadmin = array(41910,560647,2417399,2208551,2036670,2045492,2417399,2456055,2418940,2418951,2418873,2418874,2418877,2700385,2451177,2738937,2418872,2358290,2896262,2919995);
    protected $_userInfo        = null;
    
    public $memSets     = null;
    public $comicChannelList=array();
    public $_resetMemCached = false;
    public $_memCache   = array();
    public $_modelArrayPicks   = array();
    public $viewData  = array();
    public function initialize()
    {
       $this->smarty = new Smartyview();
       $this->multicache = new Multicache();
       $this->basecommon = new Basecommon();
       $this->session = new Session();
       $this->indexModel = new IndexModel();
       $this->page = new Page();
       $domain = strtolower($_SERVER['HTTP_HOST']);
       $keyArr = $this->basecommon->getDomainBykeyAndFolder($domain);
       $ckey=$keyArr['ckey'];
       $uckey=$keyArr['uckey'];
       $this->comicChannelList = json_decode($this->config->channellist->list,1);



       $userInfo        = null;
       $this->_userInfo = $userInfo = $this->session->userdata('userInfo');
       $cookieArr = $this->basecommon->getCookieValue($ckey.'_auth',$uckey,$userInfo);
       $uid = $cookieArr['uid'];
       $password  = $cookieArr['password'];
       $this->_pageProg = $this->dispatcher->getControllerName() ? $this->dispatcher->getControllerName() : "maindex";
       $this->_pageMethod = $this->dispatcher->getActionName() ? $this->dispatcher->getActionName():"index";

//       $uid=2456055;
       if($uid && !$userInfo){
         $ucRow = $this->basecommon->getUserFromUcenter($uid);
         $userInfoArray    = array('userInfo' => $this->indexModel->getUserFromVideo($uid,$ucRow));
         $this->session->set_userdata($userInfoArray);
         $this->_userInfo = $userInfo = $this->session->userdata('userInfo');
       }



       $isAdmin = false;
       if(in_array($uid,$this->_isadmin))
         $isAdmin = true;

       if(!isset($userInfo['uid']))
         $userInfo['uid']=0;

       $userInfo['isvip']=1;
       $this->_setViewData(array('comicChannelList'=>$this->comicChannelList,'isAdmin'=>$isAdmin, 'current_url'=>$this->config->url->base_url.$_SERVER['REQUEST_URI'],'base_url'=>$this->config->url->base_url,'css_url'=>$this->config->url->css_url,'pageMethod'=>$this->_pageMethod,'pageProg'=>$this->_pageProg,'exectime'=>$time,'userInfo'=>$userInfo,'nowtime'=>time(),'js_url'=>$this->config->url->js_url,'img_url'=>$this->config->url->img_url,'domainArr'=>$this->_domainArr));

      $this->_modelArrayPicks = array('indexHotComics'=>20,'relatelists'=>10);
      
       $this->memSets = array(
                       'maindex' => array('comicBannerList','indexHotComics','indexRecommComics','hotComics','updateAdvisories','weeklyCountList','viewList'),
                       'lists'   => array('updateAdvisories','viewList'),
                       'comic'   => array('updateAdvisories','viewList'),
                       'ckiframe' => array('indexRecommComics'),
                       'search'  => array('comicBannerList'),
                       'auditAdult' => array('updateAdvisories')
      );
      $memSets = $this->memSets;
      if(!isset($memSets[$this->_pageProg]))
        return;

      if(!$memSets[$this->_pageProg])
        return;

      $memprog = $memSets[$this->_pageProg];
      foreach($memprog as $k => $v){
        $memprog[$k]='nc-'.$v;
      }
      $_memcache = $this->multicache->get($memprog);
      foreach($_memcache as $k => $v){
        $_k = str_replace("nc-","",$k);
        $memCache[$_k]=$v;
      }
      if(isset($memCache))
        $this->_memCache = $memCache;

      foreach($memSets[$this->_pageProg] as $k => $v)
          $this->getDataFromMemcachKey($v);

      
    }

   function resetMem($key = 'maindex'){
      $memSets = $this->memSets;
      foreach($memSets[$this->_pageProg] as $k => $v)
        $this->getDataFromMemcachKey($v);

    }

    function getDataFromMemcachKey($key = null){
      if(!$key)
        return false;

      $modelKey = $data = null;
      if(!isset($this->_memCache[$key])||$this->_resetMemCached){
        $modelKey = 'indexModel';
        switch($key){
          case 'indexHotComics':
            $data = $this->$modelKey->getIndexHotComicsByRtime(date('Ymd',strtotime("-1 day")));
            $data = $this->arrayunique($data);
           // $data = $this->array_pick($data,20);
            break;
          case 'indexRecommComics':
            $data = $this->$modelKey->getIndexHotComics('lastview',1,20);
            break;
          case 'weeklyCountList':
            $data = $this->$modelKey->getWeeklyCounLists();
            break;
          case 'indexRecommTag':
            $data = $this->$modelKey->getTagByState();
            break;
           case 'recentComics':
            $data = $this->$modelKey->getRecentComics();
            break;
          case 'hotComics':
            $data = $this->$modelKey->getHotComics('id');
            break;
          case 'comicBannerList':
            $data = $this->$modelKey->getBanner();
            break;
          case 'tvCovers':
            $data = $this->$modelKey->getAllTvCovers(null,3);
            break;
          case 'updateAdvisories':
            $data = $this->$modelKey->getVolsByrtime();
            break;
          case 'viewList':
            $data = $this->$modelKey->getViewing(date('Ymd'));
            break;
        }
        $this->multicache->set('nc-'.$key, $data, MEMCACHE_COMPRESSED, 77);
        $this->_memCache[$key] = $data;
      }
      $randLimit = isset($this->_modelArrayPicks[$key]) ? $this->_modelArrayPicks[$key] : null;
      if(!$randLimit){
        $this->_setViewData(array($key=>$this->_memCache[$key]));
      }else{
        $this->_setViewData(array($key=>$this->array_pick($this->_memCache[$key],$randLimit)));
      }

      return false;
    }

    function arrayunique($data = array()){
      if(!is_array($data))
        return $data;

      $tmp = array();
      $istmp = false;
      foreach($data as $v){
        foreach($tmp as $t){
          if($t['cid'] == $v['cid'])
            $istmp=true;
        }
        if(!$istmp){
          $tmp[]=$v;
        }
        $istmp = false;
      }
      return $tmp;
    }

    function _setViewData($d){
      foreach($d as $k => $v){
        $this->viewData[$k] = $v;

      }
      return ;
    }
//从数组中随机挑值
    function array_pick($hash, $num) {
//打乱数组
      shuffle($hash);
//计算大小
      $count = count($hash);
      if ($num <= 0) return array();
      if ($num >= $count) return $hash;
//随机获得一些数组值
      $keys = array_rand($hash, $count - $num);
      if(is_array($keys))//坏值索引
         foreach ($keys as $k) unset($hash[$k]);
      else
         unset($hash[$keys]);
//返回剩下的值
      return $hash;
    }

    function fbLoginUser(){
        $user_profile = $this->session->userdata('userInfo');
        $user = $this->facebook->getUser();
        if(!$user)
          return false;
        try {
          $uprofile = $this->facebook->api('/me/');
          $access_token = $this->facebook->getAccessToken();
          $u = null;
          $user_profile['fbaccesstoken']=$access_token;
          if(!isset($user_profile['uid']))
            return false;
          $user_profile['fbid']=$uprofile['id'];
          $u = $this->indexModel->fbLoginUser($user_profile);
          if(!$u)
            return false;
          $this->session->unset_userdata('userInfo');
          $this->session->set_userdata(array('userInfo'=>$user_profile));
          return $u;
        }catch (FacebookApiException $e) {
          $user=null;
          return false;
        }

      return $user_profile;
      }


}


