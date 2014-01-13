<?php
class MaindexController extends WebBase {
  public $_perpage = 20;
  public $_isDuplicateIp = 0;
  public $smarty = null;

  public function initialize() {
    parent::initialize();
    $this->smarty = new Smartyview();
    $this->_setViewData(array('_channels'=>$this->_channels,'isAdmin'=>$this->isadmin, 'current_url'=>$this->config->url->base_url.$_SERVER['REQUEST_URI'],'base_url'=>$this->config->url->base_url,'css_url'=>$this->config->url->css_url,'pageMethod'=>$this->_pageMethod,'pageProg'=>$this->_pageProg,'exectime'=>$time,'userInfo'=>$this->_userInfo,'nowtime'=>time(),'js_url'=>$this->config->url->js_url,'img_url'=>$this->config->url->img_url,'domainArr'=>$this->_domainArr));
    if(in_array($this->_pageMethod, array('index','play','detail'))){
       $this->_channels = $this->avModel->getChannelList();
       $hotTags = $this->avModel->getHotTags();
       $this->_setViewData(array('channels' => $this->_channels, 'hotTags' =>$hotTags));
    }
  }

  function _setViewData($d){
    foreach($d as $k => $v){
      $this->viewData[$k] = $v;
    }
    return true;
  }
  function ckiframeAction(){
    $this->smarty->assign($this->viewData);
    $this->smarty->display('ckindex.html');
    fastcgi_finish_request();
  }

  function cindexAction(){
    $this->smarty->assign($this->viewData);
    $this->smarty->display("index.html");
    fastcgi_finish_request();
  }

  function checkLogin(){
    die(json_encode($this->_userInfo));
  }

  function checkUserIP(){
      if($this->_userInfo['uid']){
          $ip = get_client_ip();
          if($this->_userInfo['lastip'] != $ip){
            $this->logout(1);
            $this->_isDuplicateIp = true;
          }

      }
      return true;
  }

  function indexAction($cid=0,$order = 0 ,$nowpage = 1,$iswarrning = 0){
    $lists = $this->avModel->getChannelList();
    
    if($this->ismobile){
      $this->mindex();
      return true;
    }
    if(!$this->_userInfo['uid'] && $nowpage > 20){
      $this->response->redirect('/pay');
      return true;
    }
    $CountAll = 0;
    foreach($this->_channels as $k => $v)
      $CountAll += $v['videocount'];

    $lists = $this->avModel->getVideosByCid($cid,$order,$nowpage,$this->_perpage);
//var_dump($CountAll);exit;
    $PAGESTR    = $this->page->getPaginationString($nowpage, $CountAll, $this->_perpage, 1, "/", "maindex/index/$cid/$order/");
    if($iswarrning){
       $ip = get_client_ip();
       $this->_setViewData(array('isWarrning' => 1, 'ip' => $ip));
    }

    $this->_setViewData(array('PAGESTR' => $PAGESTR, 'cid' => $cid, 'order' => $order, 'lists' => $lists, 'nowpage' => $nowpage));
    $this->smarty->assign($this->viewData);
    $this->smarty->display('index.html');
    $this->setUserIP();
    fastcgi_finish_request();
  }

  function detailAction($key = null, $isb=null){
    $this->playAction($key , $isb);
  }
  function playAction($key = null, $isb=null){
    if($this->ismobile){
       $this->mplay($key,$isb);
       return true;
    }
    $noAvurl=false;
    if(!$this->_userInfo['uid'])
      $noAvurl=true;

    $lastFreeLog = true;
    if(isset($this->_userInfo['isvip'])){
      $lastFreeLog = $this->avModel->getLastFreeLog($this->_userInfo['uid']);
      if($this->_userInfo['isvip'] < 1 && $lastFreeLog)
        $noAvurl=true;
    }

    $info = $this->avModel->getAvByid($key,$isb, '', $this->isadmin);
    if( !isset($info['avkey'])){
       $this->response->redirect("maindex/index/0/0/0/0/");
    }
    $info['picurl'] = $this->avModel->getPicUrl($info['avkey'],$info['serverid'],'b');
    if($this->_userInfo['lastip'] != get_client_ip()){
       $noAvurl=true;
    }
    if($noAvurl){
      unset($info['videourl']);
    }
    $cid = $info['cid'];
    $taglists = $this->avModel->getTagsByVid($info['vid']);
    $lists=array();
    if($info['relatedata']){
      $lists = unserialize($info['relatedata']);
    }
    $this->_setViewData(array('lastFreeLog' =>$lastFreeLog,'ismp4' =>1,'isb' =>$isb,'cid' =>$cid,'lists' =>$lists,'taglists' =>$taglists,'info' =>$info));
    $this->smarty->assign($this->viewData);
    //$this->smarty->display("play.new.html");
    $this->smarty->display("detail.html");
    $this->avModel->addLog($key,$this->_userInfo['uid'],'freecount');
    $this->setUserIP();
    fastcgi_finish_request();
  }
  
  function rankAction(){
     $channel = $this->viewData["comicChannelList"];
     foreach($channel as $v){
        $volskey[]="nc-indexvolshotlist{$v['id']}";
        $lists=array();
        array_unshift($lists,array("name"=>$v['name']));
        $vlists[]=$lists;
     }
     $mlists=$this->multicache->get($volskey);
     if(count($mlists)<=0){
       unset($vlists);
       while(list($k,$v) = each($channel))
       {
         $lists = $this->indexModel->getIndexHotComicsByDate(date('Ymd',strtotime("-1 day")),1,15,$v['id']);
        array_unshift($lists,array("name"=>$v['name']));
        if(isset($lists[1]))
          $this->multicache->set("nc-indexvolshotlist{$v['id']}",$lists);
        $vlists[]=$lists;
       }
       }
     foreach($vlists as $k => $v){
      foreach($mlists as $m){
        if($m[0]['name'] == $v[0]['name'])
          $vlists[$k]=$m;
      }
      $vData["rankingvolshotlist".($k+1)] = $vlists[$k];
     }
     $this->_setViewData($vData);
     $this->smarty->assign($this->viewData);
     $this->smarty->display("rank.html");
     fastcgi_finish_request();
  }

 
 function hotcomicAction($nowpage = 1){
    if(intval($nowpage<=0))
      $nowpage=1;
    else if(intval($nowpage>10))
      $nowpage=10;

    
    $lists = $this->multicache->get('nc-hotcomic'.$nowpage);
    
    if(!isset($lists['0'])){
      $lists = $this->indexModel->getIndexHotComicsByRtime(date('Ymd',strtotime("-1 day")),$nowpage,20,1);
      
      
      $this->multicache->set('nc-hotcomic'.$nowpage,$lists);
    }
    $ttotal = 200;
    if($ttotal){
      $PAGESTR = $this->page->getPaginationString($nowpage, $ttotal, 20, 1, "/", "hotcomic/");
      $this->_setViewData(array('PAGESTR'=>$PAGESTR,'ttotal'=>$ttotal));
    }
    $this->_setViewData(array('lists'=>$lists,'nowpage'=>$nowpage));
    $this->smarty->assign($this->viewData);
    $this->smarty->display("hotcomic.html");
    fastcgi_finish_request();
 }

 function randomcomicAction($nowpage = 1){
    $lists = $this->indexModel->getIndexHotComics('lastview',$nowpage,30);
    $ttotal = 0;
    foreach($this->comicChannelList as $k => $v){
       $ttotal += intval($v['ttotal']);
    }

    if($ttotal){
        $PAGESTR = $this->page->getPaginationString($nowpage, $ttotal,30,1,"/", "randomcomic/");
        $this->_setViewData(array('PAGESTR'=>$PAGESTR,'ttotal'=>$ttotal));
    }
    $this->_setViewData(array('lists'=>$lists,'nowpage'=>$nowpage));
    $this->smarty->assign($this->viewData);
    $this->smarty->display("randomcomic.html");
    fastcgi_finish_request();
 }

   function sitemapAction($type = 0){
    if(isset($_SERVER['REQUEST_URI']))
      return;

    $comicList = $this->indexModel->getAllComicid();
    $allCover  = $this->indexModel->getAllCover();
    $this->_setViewData(array('comiclist'=>$comicList,'allCover'=>$allCover));
    $output = $this->smartyview->render('sitemap.xml',$this->viewData,1);

    $myFile = "/home/comic/html/comic101.com/sitemap.xml";
    $fh = fopen($myFile, 'w') or die("can't open file");
    fwrite($fh, $output);
    fclose($fh);

 }

  function setSiteMap(){
   if(isset($_SERVER['REQUEST_URI']))
    return;

   $tagAllList = $this->indexModel->getTagAll();
   $this->_setViewData(array('tagAllList'=>$tagAllList));
   $output = $this->smartyview->render('sitemap.html',$this->viewData,1);
   $myFile = "/home/comic/html/comic101.com/sitemap.html";
   $fh = fopen($myFile, 'w') or die("can't open file");
   fwrite($fh, $output);
   fclose($fh);
 }

  function resetMemCachedAction($key = null){

    $this->_resetMemCached = true;
    $this->resetMem($key);
    echo 1;
  }

  function faqAction(){
    $this->smartyview->render("faq.html",$this->viewData);
  }

  function fbloginAction(){
    $u=$this->fbLoginUser();
    if(!$u)
      die(json_encode(array('status'=>0)));
    else{
      $sessionid=$this->session->userdata('session_id');
      die(json_encode(array('status'=>1,'sessionid'=>$sessionid)));
    }
  }

  
  function auditAdultAction($type = 0,$date=null,$nowpage=1){
    if(!$type)
      die(json_encode(array('status'=>0)));

    switch($type){
      case 1:
      $lists = $this->_memCache['updateAdvisories'];
      break;
      case 2:
      $lists = $this->indexModel->getVolsByrtime($date,$nowpage,30);
      break;
      case 3:
      $lists = $this->multicache->get('nc-hotcomic'.$nowpage);
      if(!isset($lists['0'])){
        $lists = $this->indexModel->getIndexHotComicsByRtime(date('Ymd',strtotime("-1 day")),$nowpage,20,1);
        $this->multicache->set('nc-hotcomic'.$nowpage,$lists);
      }
      break;
       }
    if(!is_array($lists))
      die(json_encode(array('status'=>0)));

    foreach($lists as $v){
      $ncount =  $this->indexModel->getPagesByvidAndadultCount($v['id']);
      if(!$ncount)
        continue;

      $this->indexModel->setVolsByidWithOrdinary($v['id'],$ncount);
      $this->indexModel->setCheckIndex($type,$v);
      $this->indexModel->setCheckIndexLog($v['id'],$type,$ncount);

    }
    die(json_encode(array('status'=>1)));
  }

  function show404Action(){
    $this->smarty->assign($this->viewData);
    $this->smarty->display('error_404.html');
    fastcgi_finish_request();
  }

  function logoutAction(){
    $this->session->destroy();
    setcookie('iTiQ_c4ec_auth',"",time()-3600,"/",".ck101.com");
    setcookie("cdb_auth", "", time()-3600,"/",".ck101.com");
    setcookie("cdb_sid", "", time()-3600,"/",".ck101.com");
    setcookie("Lre7_9bf0_auth", "", time()-3600,"/",".ck101.com");
    setcookie("Lre7_9bf0_sid", "", time()-3600,"/",".ck101.com");
    $this->response->redirect($this->config->url->base_url,true);
  }

  function isUserInfoAction(){
   if(!$this->_userInfo)
     die(json_encode(array('status'=>0)));
   else
     die(json_encode(array('status'=>1)));
 }

}

