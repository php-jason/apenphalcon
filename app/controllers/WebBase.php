<?php
class WebBase extends Phalcon\Mvc\Controller{
   
    public $multicache = null;
    public $basecommon = null;
    public $session = null;
    public $avModel = null;
    public $page = null;
    protected $_pageProg        = null;
    protected $_pageMethod      = null;
    protected $_isadmin = array(41910,560647,2417399,2208551,2036670,2045492,2417399,2456055,2418940,2418951,2418873,2418874,2418877,2700385,2451177,2738937,2418872,2358290,2896262,2919995);
    protected $_userInfo        = null;
    protected $isadmin = 0; 
    public $_channels = array();
    public $viewData  = array();
    public $ismobile = 0;

    public function initialize()
    {
//       $this->multicache = new Multicache();
       $this->basecommon = new Basecommon();
       $this->session = new Session();
       $this->avModel = new AvModel();
       $this->page = new Page();
       $domain = strtolower($_SERVER['HTTP_HOST']);
       $keyArr = $this->basecommon->getDomainBykeyAndFolder($domain);
       $ckey = $keyArr['ckey'];
       $uckey = $keyArr['uckey'];
//       $this->_userInfo = $this->_userInfo = $this->session->userdata('userInfo');
       $cookieArr = $this->basecommon->getCookieValue($ckey.'_auth',$uckey,$this->_userInfo);
       $uid = $cookieArr['uid'];
       $password  = $cookieArr['password'];
       $this->_pageProg = $this->dispatcher->getControllerName() ? $this->dispatcher->getControllerName() : "maindex";
       $this->_pageMethod = $this->dispatcher->getActionName() ? $this->dispatcher->getActionName():"index";

       $uid=2456055;
       if($uid){
         $ucRow = $this->basecommon->getUserFromUcenter($uid);
         $this->_userInfoArray    = array('userInfo' => $this->avModel->getUserFromVideo($ucRow['uid'],$ucRow));
         $this->session->set_userdata($this->_userInfoArray);
         $this->_userInfo = $this->_userInfo = $this->session->userdata('userInfo');
       }

       if(in_array($uid,$this->_isadmin))
         $this->isadmin = true;

       if(!isset($this->_userInfo['uid']))
         $this->_userInfo['uid'] = 0;

//var_dump($this->_userInfo);exit;
    }  

  function setUserIP($isdownload = null){
      if(!$isdownload)
        return false;

      if($this->_userInfo['uid']){
        $ip = get_client_ip();
        $this->avModel->updateUserIP($this->_userInfo['uid'], $ip);
      }
      return true;
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


