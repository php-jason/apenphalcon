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
      case 'comic101.com':
      $ckey = 'iTiQ_c4ec';
      $uckey = 'adte3jfb6R0C8D0kcSa59allencall9faen96Aby596Wbcbya';
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
    $uc  = (array)json_decode(file_get_contents(sprintf('http://www.ck101.com/api/user.php?method=get&uid=%d',$uid),0,$ctx));
//  $uc  = (array)json_decode('{"status":"ok","user":{"uid":"2456055","username":"KOBE","groupid":"68"}}',1);
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
?>
