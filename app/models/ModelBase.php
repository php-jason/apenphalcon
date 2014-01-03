<?php

class ModelBase extends Phalcon\Mvc\Model
{
    protected $_comicsColum     = ' c.`id` ,  c.`cid` ,  c.`name` , c.`oname`,c.`testname`, c.`isdone` ,  c.`hits`  , c.`ttotal` , c.`lastuploader` , c.`isadult`,c.`lastupdate`,c.`comicdesc` ';
    protected $_comicsWhereCaus = ' WHERE  c.`ttotal` > 0';
    protected $_volDetialColum = ' v.`id` ,  v.`comicid` , v.`coverpid` ,  v.`vol` ,  v.`name` ,  v.`pages` ,  v.`hits` , v.`voltype`  ';
    //protected $_volWhereCaus = ' WHERE  v.`pages` != 0';    
    protected $_volWhereCaus = ' WHERE  v.`isdone` = 1 ';
    protected $_pageDetailColum = 'p.`id` ,  p.`vid` ,  p.`vols` ,  p.`comicid` ,  p.`prevpid` ,  p.`nextpid` ,  p.`pageno` , p.`isadult`  ';
    public $db = null;
    function initialize() {
       $c = $this->getDI()->get('config');
       $this->db = new Dbmysql($c->database->host,$c->database->username,
                              $c->database->password,$c->database->dbname);
    }

  function getComicCoverUrl($comicid = null ,$isdetail = null,$serverid = 53){
    if(!$comicid)
      return false;

    $imgPatt      = "http://%d.c.cdvcdn.com/cover/%d/%d/%d/%d-s-cover.jpg";
    if($isdetail)
      $imgPatt    = "http://%d.c.cdvcdn.com/cover/%d/%d/%d/%d-cover.jpg";

    $g = sprintf("%06d",$comicid);

    $h = 2;
    $coverUrl = sprintf($imgPatt,$h,$g[3],$g[4],$g[5],$comicid);
    return $coverUrl;
  }

  function getComicVolCoverPic($pages = null,$isThumbnail = null,$serverid = 53,$ishot=0){
    $imgPatt      = "http://%d.fs%s.comic.ckcdn.com/page/%d/%d/%d/%d/%d/%s%s-%d-%04d-%d.jpg";
    $imgPatt      = "http://%d.c.cdvcdn.com/page/%d/%d/%d/%d/%d/%s%s-%d-%04d-%d.jpg"; 

    $serverid = $ishot ? 1 : 2;

    $thumb        = $isThumbnail ? 'thumb-' : '';
    $g            = sprintf("%06d",$pages['comicid']);
    $coverUrl = sprintf($imgPatt,$serverid,$g[3],$g[4],$g[5],$pages['comicid'],$pages['vols'],$thumb,$g,$pages['vid'],$pages['pageno'],$pages['id']);
    return $coverUrl;
  }

  function getPagePic($pages = null,$isThumbnail = null,$serverid = 53,$ishot=0){
   $imgPatt      = "http://%d.c.cdvcdn.com/page/%d/%d/%d/%d/%d/%s%s-%d-%04d-%d.jpg";

    $serverid = $ishot ? 1 : 2;

    $thumb        = $isThumbnail ? 'thumb-' : '';
    $g            = sprintf("%06d",$pages['comicid']);
    $coverUrl = sprintf($imgPatt,$serverid,$g[3],$g[4],$g[5],$pages['comicid'],$pages['vols'],$thumb,$g,$pages['vid'],$pages['pageno'],$pages['id']);
    return $coverUrl;
  }


}
