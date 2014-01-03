<?php
/*
define('UC_CONNECT', 'mysql');
define('UC_DBHOST', '127.0.0.1');
define('UC_DBUSER', 'junlin');
define('UC_DBPW', 'allen123');
define('UC_DBNAME', 'jdzx');
define('UC_DBCHARSET', 'utf8');
define('UC_DBTABLEPRE', '`jdzx`.pre_ucenter_');
define('UC_DBCONNECT', '0');
define('UC_KEY', 'm0w0Q7tcO5u1S444Jfddy0Q9Mb6eL3I0C4Dc2aPdN7Z3qc9cc5w1FcR3Ec70r7cb');
define('UC_API', 'http://junlin.com/uc_server');
define('UC_CHARSET', 'utf-8');
define('UC_IP', '127.0.0.1');
define('UC_APPID', '3');
define('UC_PPP', '20');
*/
define('UC_KEY', '0863c3Y5nOtBIhlfrUG0ui063kQRJv1Y5glA/GGYY');
define('UC_API', 'http://uc.ck101.com/');
define('UC_CHARSET', 'utf-8');
define('UC_IP', '173.231.9.231');
define('UC_APPID', '13');
define('UC_PPP', '20');

define('UC_CLIENT_VERSION', '1.6.0');
define('UC_CLIENT_RELEASE', '20110501');

define('API_DELETEUSER', 1);
define('API_RENAMEUSER', 1);
define('API_UPDATEPW', 1);       
define('API_GETTAG', 1);       
define('API_SYNLOGIN', 1);     
define('API_SYNLOGOUT', 1);
define('API_UPDATEBADWORDS', 0);
define('API_UPDATEHOSTS', 0);   
define('API_UPDATEAPPS', 0);
define('API_UPDATECLIENT', 1);  
define('API_UPDATECREDIT', 1);
define('API_GETCREDITSETTINGS', 1);
define('API_UPDATECREDITSETTINGS', 1); 
define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');


if(!defined('IN_UC')) {
define('KK101_ROOT', dirname(dirname(__FILE__)).'/');
$get = $post = array();

$code = @$_GET['code'];
parse_str(authcode($code, 'DECODE', UC_KEY), $get);
if(time() - $get['time'] > 3600) {
  exit('Authracation has expiried');
}
if(empty($get)) {
  exit('Invalid Request');
}

include_once KK101_ROOT.'./uc_client/lib/xml.class.php';
$post = xml_unserialize(file_get_contents('php://input'));

if(in_array($get['action'], array('test', 'synlogin', 'synlogout'))) {
  $uc_note = new uc_note();
  echo $uc_note->$get['action']($get, $post);
  exit();
} else {
  exit(API_RETURN_FAILED);
}
} else {
  exit();
}

class uc_note {

  function uc_note() {

  }

  function test($get, $post) {
    return API_RETURN_SUCCEED;
  }

function synlogin($get, $post) {

    if(!API_SYNLOGIN) {
      return API_RETURN_FORBIDDEN;
    }

    header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');

    $cookietime = 31536000;
    $uid = intval($get['uid']);
    $username = $get['username'];
    $passwd = $get['password'];
    setcookie('iTiQ_c4ec_auth',authcode("$passwd\t$uid", 'ENCODE',UC_KEY), time()+$cookietime, '/');
  }
  
  function synlogout($get, $post) {

    if(!API_SYNLOGOUT) {
      return API_RETURN_FORBIDDEN;
    }

    header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');

    setcookie('iTiQ_c4ec_auth', '', -31536000, '/');
  }

}



function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
  $ckey_length = 4;
  $key = md5($key != '' ? $key : UC_KEY);
  $keya = md5(substr($key, 0, 16));
  $keyb = md5(substr($key, 16, 16)); 
  $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
  $cryptkey = $keya.md5($keya.$keyc);
  $key_length = strlen($cryptkey);
  $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
  $string_length = strlen($string);
  $result = '';
  $box = range(0, 255);
  $rndkey = array();
  for($i = 0; $i <= 255; $i++) {    $rndkey[$i] = ord($cryptkey[$i % $key_length]);
  }
  for($j = $i = 0; $i < 256; $i++) {
    $j = ($j + $box[$i] + $rndkey[$i]) % 256;
    $tmp = $box[$i];
    $box[$i] = $box[$j];
    $box[$j] = $tmp;
  }
  for($a = $j = $i = 0; $i < $string_length; $i++) {
    $a = ($a + 1) % 256;
    $j = ($j + $box[$a]) % 256;
    $tmp = $box[$a];
    $box[$a] = $box[$j];
    $box[$j] = $tmp;
    $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
  }
  if($operation == 'DECODE') {
    if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
      return substr($result, 26);
    } else {
      return '';
    }
  } else {
    return $keyc.str_replace('=', '', base64_encode($result));
  }
}
