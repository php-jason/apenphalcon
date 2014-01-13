<?php

class ModelBase extends Phalcon\Mvc\Model
{
    public $db = null;
    function initialize() {
       $c = $this->getDI()->get('config');
       $this->db = new PDO(sprintf("mysql:host=%s;dbname=%s;charset=%s", $c->database->host, $c->database->dbname, $c->database->charset), $c->database->username, $c->database->password);
       $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

  function getServerid(&$serverid){
    $serverid = explode('|', $serverid);
    $serverid = $serverid[mt_rand(0, count($serverid) - 1)];
  }

  function getVideoUrl($videoname,$serverid,$isvip=null){
      $this->getServerid($serverid);
      $f      ="/".$videoname;
      $vip    = "";
      $p      = '';
      if($serverid === '136-170-2' || $serverid==='136-170')
        $p = ':8888';

      $secret = "iloveallen";
      if($isvip){
        $vip = "vip";
        $secret = "goldallen";
      }
      $http   = sprintf("http://1.fs%s.%sav.ckcdn.com%s",$serverid,$vip,$p);
      $uri_prefix = "/dl/";
      $t      = time();
      $t_hex  = sprintf("%08x", $t);
      $m      = md5($secret.$f.$t_hex);
      $videopath = sprintf('%s%s%s/%s%s',$http,$uri_prefix, $m, $t_hex, $f);
      return $videopath;
  }
  
  function getPicUrl($avkey = null,$serverid = 1 ,$pictype = 's'){
      $this->getServerid($serverid);
      $p = '';
      if($serverid === '136-170' || $serverid === '136-170-2')
        $p = ':8888';

      $imgPatt      = "http://%s.fs%s.av.ckcdn.com%s/%s-%s.jpg";
      $e = isset($avkey[4])?strtolower($avkey[4]):9;
      switch($e){
        default:
          $pre = 0;
        break;
        case '0':
        case '1':
        case '2':
        case '7':
          $pre = 0;
        break;
        case '3':
        case '4':
        case 'a':
        case 'b':
        case 'c':
        case 'd':
        case 'e':
        case 'f':
          $pre = 1;
        break;
        case '5':
        case '6':
        case 'g':
        case 'h':
        case 'i':
        case 'j':
        case 'k':
        case 'l':
        case 'm':
          $pre = 2;
        break;
        case '8':
        case '9':
        case 'n':
        case 'o':
        case 'p':
        case 'q':
        case 'r':
          $pre = 3;
        break;
        case 's':
        case 't':
        case 'u':
        case 'v':
        case 'w':
        case 'x':
        case 'y':
        case 'z':
          $pre = 4;
        break;

      }

      return sprintf($imgPatt,$pre,$serverid,$p,$avkey,$pictype);
  }


}
