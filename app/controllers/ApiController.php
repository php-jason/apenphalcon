<?php
class ApiController extends WebBase {
  public $_perpage = 20;
  public $_isDuplicateIp = 0;
  public $smarty = null;

  public function initialize() {
    parent::initialize();
  }
  public function videourlAction($key,$isb = null,$isdownload = null){
    //判断referer是否合法
    $domain_arr = explode('|', $this->config->url->domain_url);
    $referer = false;
    foreach($domain_arr as $v){
      if(false !== strpos($_SERVER['HTTP_REFERER'], $v)){
        $referer = true;
        break;
      } 
    }
    if(!$referer){
      die(0);
    }
    //判断请求是否Ajax
    if( 'XMLHttpRequest' != $_SERVER['HTTP_X_REQUESTED_WITH']){
       die(0);
    }
    //判断是否登录
    if( !$this->_userInfo['uid']){
       die(json_encode(array('status' => 4)));
    }
    //判断是否是VIP
    if( !$this->_userInfo['isvip']){
   //扣點類型
       $token = $this->avModel->getAvTokenByPoint($this->_userInfo['uid'], $key, 0);
       if( !$token){
         die(json_encode(array('status' => 44)));
       }
    }
    //判断是否是SVIP
    if( $isdownload && $this->_userInfo['isvip'] !== 9){
       //扣點類型
       $token = $this->avModel->getAvTokenByPoint($this->_userInfo['uid'], $key, $isdownload = 1);
       if( !$token){
         die(json_encode(array('status' => 444)));
       }
    }
    $info = $this->avModel->getAvByid($key,$isb,$isdownload,$this->isadmin);
    if( !isset($info['avkey'])){
       die(json_encode(array('status' => 404)));
    }
//    $info['videourl'] = 'http://content.bitsontherun.com/videos/i8oQD9zd-640.mp4';
    $return = array('videourl' => $info['videourl'],'status' => 200);
    die(json_encode($return));
  }

  function addPlayed($key){
    if( !$key)
      return ;

    $this->setUserIP();
    $this->avModel->addLog($key,$this->_userInfo['uid'],'playcount');
    return true;
  } 
}
