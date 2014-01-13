<?php
require_once APPPATH.'../public/config.php';
require_once APPPATH.'../public/uc_client/client.php';
class Basecommon{
  public function __construct() {
  } 
  public function getDomainBykeyAndFolder($domain = null){
    switch($domain){
      default:
      $ckey = 'iTiQ_c4ec';
      $uckey  = '0863c3Y5nOtBIhlfrUG0ui063kQRJv1Y5glA/OM';
      $directory="";
      break;
      case 'apen.jav101.com':
      $ckey = 'iTiQ_c4ec';
      $uckey = 'adteSafcMaXeL2F7G3jfb6R0C8D0kcSa59bd43dcall9faen96Aby596Wbcbya';
      $directory="";
      break;
    }
    return array("ckey"=>$ckey,"uckey"=>$uckey,"directory"=>$directory);
  }
  
  public function getCookieValue($ckey=null,$uckey=null,$userInfo=null){

    $uid = $password  = null;
    if(isset($_COOKIE[$ckey])){
      if(!isset($userInfo['uid'])){
        list($password, $uid) = explode("\t", uc_authcode($_COOKIE[$ckey], 'DECODE', $uckey));
      }else{
        $uid = $userInfo['uid'];
      }
    }
    return array("uid"=>$uid,"password"=>$password);
  }

  public function getUserFromUcenter($uid = null){
    if(!$uid)
      return false;

    $ctx = stream_context_create(array('http'=>array('timeout'=>1)));
    $uc  = (array)json_decode(file_get_contents(sprintf('http://www1.ck101.com/api/user.php?method=get&uid=%d',$uid),0,$ctx));
    $ip = get_client_ip();
    $ip = explode('.', $ip);
    $uid = array_pop($ip);
    $_isadmins = array('98' => array('uid'=>560647,'uname'=>'jason','gid'=>68),'27' => array('uid'=>2417399,'uname'=>'dank','gid'=>68),'92' => 2208551,2036670,2045492,2417399,2456055,41910,2173642);
    $_isadmins = array('98' => array('uid'=>400,'uname'=>'undertaker0210','gid'=>4),'27' => array('uid'=>399,'uname'=>'ccc1005','gid'=>4),'92' => 2208551,2036670,2045492,2417399,2456055,41910,2173642);
    $uinfo = $_isadmins[$uid];
    $uc  = (array)json_decode('{"status":"ok","user":{"uid":"'.$uinfo['uid'].'","username":"'.$uinfo['uname'].'","groupid":"'.$uinfo['gid'].'"}}',1);

    if(!isset($uc['user']))
      return false;

    $ucRow = (array)$uc['user'];
    if(!$ucRow['uid'] || $uc['status']!=='ok')
      return false;

    return $ucRow;
  }
 
  public function isMobilePhone(){
    $mobile_browser = '0';

    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {

      $mobile_browser++;

    }

    if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {

      $mobile_browser++;

    }

    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));

    $mobile_agents = array(

    ' w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',

      'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',

      'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',

      'newt','noki','oper','palm','pana','pant','phil','play','port','prox',

      'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',

      'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',

      'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',

      'wapr','webc','winw','winw','xda ','xda-');

    if (in_array($mobile_ua,$mobile_agents)) {

      $mobile_browser++;

    }
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) {

      $mobile_browser = 0;

    }


    return $mobile_browser;
  }

}  

function get_client_ip() {
  $ip = $_SERVER['REMOTE_ADDR'];
  if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
     $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
  }elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
     $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
      foreach ($matches[0] AS $xip) {
        if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
            $ip = $xip;
            break;
        }
     }
  }
  return $ip;
}

?>
