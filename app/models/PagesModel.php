<?php
 
class PagesModel extends ModelBase{
  function initialize(){
    parent::initialize();
  } 

  function getTucaoByPidAndUid($pid=null,$uid=null,$nowpage=1,$limit=10){
    if(!$pid)
      return false;
    $from = ($nowpage-1) * $limit;
    $from = $from < 0 ? 0 : $from;
    $table = $this->getTucaoTable($pid);
    $sql = sprintf("  SELECT t.tuid,t.pid,t.uid,t.content,t.username,t.top,t.left,t.width,t.height,t.createtime
                FROM  %s AS t INNER JOIN `pages` AS p 
                    ON (t.pid = p.id) where t.pid = %d ",$table,$pid);
    if($uid)
      $sql.=" AND t.uid =".$uid;
    $sql.="  ORDER BY t.createtime DESC";
    $sql .= " LIMIT $from , $limit ";
    $query = $this->db->query($sql);
    if($this->db->num_rows($query) < 1 )
      return false;
    $lists = $this->db->result_array($query);
    return $lists;
  }
  
  function AddTucao($uid=null,$username=null,$cid=null,$pid=null,$text=null,$top=0,$left=0,$width=0){
    if(!$uid || !$username || !$cid || !$pid || !$text)
      return false;
    $table = $this->getTucaoTable($pid);
    $sql = sprintf("INSERT INTO  %s (`pid` ,`content` ,`uid`,`username`,`top`,`left`,`width`,`createtime`) VALUES ( '%d','%s','%d','%s','%d','%d','%d','%d' )",$table,$pid,mysql_real_escape_string($text),$uid,mysql_real_escape_string($username),$top,$left,$width,time());

    $query=$this->db->query($sql);
    $id = $this->db->insert_id();
    $sql = sprintf("UPDATE `pages` SET ctotal = ctotal + 1 WHERE id = %d LIMIT 1",$pid);
      $query=$this->db->query($sql);
      $sql = sprintf("UPDATE `comics` SET `tucaocount` = `tucaocount` + 1 WHERE id = %d LIMIT 1",$cid);
      $query=$this->db->query($sql);
    return $id;
  }

  
  function RiesizeTucao($id=null,$pid=null,$width=null,$height=null){
    if(!$id || !$pid || !$width || !$height)
      return false;
    $table = $this->getTucaoTable($pid);
    $sql = sprintf("UPDATE %s SET `width` = %d,`height`=%d  WHERE `tuid` = %d LIMIT 1",$table,$width,$height,$id);
      $query=$this->db->query($sql);
    return true;
  }

  function DelTucao($id=null,$cid=null,$pid=null){
    if(!$id|| !$cid || !$pid)
      return false;
    $table = $this->getTucaoTable($pid);
    $sql = sprintf("DELETE FROM %s  WHERE tuid = %d LIMIT 1",$table,$id);
      $query=$this->db->query($sql);
      $sql = sprintf("UPDATE `pages` SET ctotal = ctotal - 1 WHERE id = %d LIMIT 1",$pid);
      $query=$this->db->query($sql);
      $sql = sprintf("UPDATE `comics` SET `tucaocount` = `tucaocount` - 1 WHERE id = %d LIMIT 1",$cid);
      $query=$this->db->query($sql);
    return true;
  }

  
  function getPageInfoById($id = null ,$islast = null){
    if(!$id)
      return ;
    $sql = sprintf("SELECT  
                      %s , p.isw,p.ctotal
              FROM  `pages` AS p  WHERE id = %d LIMIT 1",$this->_pageDetailColum,$id);
    $query = $this->db->query($sql);
    if($this->db->num_rows($query) < 1 )
          return false;

    $row   = $this->db->fetch_row();
    $row['thumb'] = $this->getComicVolCoverPic($row,1);
    $row['pic'] = $this->getPagePic($row);
    $row['pic2'] = $this->getPagePic($row);
    if(!$row['nextpid'] && !$islast)
      $row['nextpid'] = $this->setPrevAndNextPage($row);

    return $row;
  }

  function getPageDesc($vid = null){
    if(!$vid)
      return ;
    $sql = sprintf(" SELECT  %s, v.reparsered , %s , c.isadult FROM vols AS v INNER JOIN comics AS c ON (v.comicid = c.id) WHERE v.id = %d LIMIT 1 ",$this->_volDetialColum,'c.name AS comicsname , v.prevpid , v.nextpid ',$vid);
    $query = $this->db->query($sql);
    if($this->db->num_rows($query) < 1 )
      return false;
    $row   = $this->db->fetch_row($query);
    return $row;

  }

  function getPidFrom($comicid = null , $vols = null ,$pageno = null){
    if(!$comicid || !$vols || !$pageno)
      return ;
    $sql = sprintf("SELECT   %s FROM  `pages` AS p  WHERE comicid = %d AND vols    = %d AND pageno = %d LIMIT 1",$this->_pageDetailColum,$comicid , $vols,
    $pageno);

    $query = $this->db->query($sql);
    if($this->db->num_rows($query) < 1 )
      return false;

    $row   = $this->db->fetch_row();
    $row['pic'] = $this->getComicVolCoverPic($row);
    if(!$row['nextpid'] && !$islast)
      $row['nextpid'] = $this->setPrevAndNextPage($row);
    return $row;
  }

  function setPrevAndNextPage($pages = null){
    if(!$pages['id'])
      return ;

    $sql = sprintf(" SELECT id , prevpid FROM pages WHERE vid = %d AND pageno = %d LIMIT 1",$pages['vid'],intval($pages['pageno'])+1);

    $query = $this->db->query($sql);
    if($this->db->num_rows($query) < 1 )
      return false;
    $row   = $query->row_array();
    $sql = sprintf(" UPDATE pages SET nextpid = %d WHERE id = %d LIMIT 1",$row['id'],$pages['id']);
      $query=$this->db->query($sql);
    if(!$row['prevpid']){
      $sql = sprintf(" UPDATE pages SET prevpid = %d WHERE id = %d LIMIT 1",$pages['id'],$row['id']);
      $query=$this->db->query($sql);
    }
    return $row['id'];
  }

  function delPagesByPid($pid=null){
    if(!$pid)
      return false;

    $sql = sprintf("UPDATE pages SET isok = 66 WHERE id = %d LIMIT 1",$pid);
    $query=$this->db->query($sql);
    return true;
  }
  
  function setPages($pages=null,$pagenum=null){
    if(!$pages || !$pagenum)
      return false;
    if(intval($pages['pageno']) != 1){
      $sql = sprintf(" UPDATE pages SET nextpid = %d WHERE comicid = %d AND id = %d LIMIT 1",$pages['nextpid'],$pages['comicid'],$pages['prevpid']); 
      $query=$this->db->query($sql);
    }
    if(intval($pages['pageno']) != $pagenum){
      $sql = sprintf(" UPDATE pages SET prevpid = %d WHERE comicid = %d AND id = %d LIMIT 1",$pages['prevpid'],$pages['comicid'],$pages['nextpid']);            
      $query=$this->db->query($sql);
    
      //$sql = sprintf(" UPDATE pages SET pageno = pageno-1 WHERE comicid = %d AND vid = %d AND pageno > %d ",$pages['comicid'],$pages['vid'],$pages['pageno']);            
      //$query=$this->db->query($sql);
    }
    return true;
  }
  
  function setVols($newcoverpid=null,$vols=null){
    if(!$vols)
      return false;
    if(!$newcoverpid){
      //$sql = sprintf(" UPDATE vols SET `pages` = `pages` - 1 WHERE id = %d LIMIT 1",$vols['id']);            
      //$query=$this->db->query($sql);
      return true;
    }
    $sql = sprintf(" UPDATE vols SET nextpid = %d WHERE comicid = %d AND coverpid = %d LIMIT 1",$newcoverpid,$vols['comicid'],$vols['prevpid']); 
    $query=$this->db->query($sql);
    $sql = sprintf(" UPDATE vols SET prevpid = %d WHERE comicid = %d AND coverpid = %d LIMIT 1",$newcoverpid,$vols['comicid'],$vols['nextpid']); 
    $query=$this->db->query($sql); 
    $sql = sprintf(" UPDATE vols SET `coverpid` = %d WHERE id = %d LIMIT 1",$newcoverpid,$vols['id']);            
    $query=$this->db->query($sql);
    return true;    
  }
  function setVolCoverPid($datas=null){
    if(!isset($datas['id']))
      return false;
    $sql = sprintf("UPDATE vols SET coverpid = ( SELECT id FROM pages WHERE vid = vols.id AND pages.pageno = 1 AND pages.isok = 1 LIMIT 1 ) WHERE id = %d LIMIT 1",$datas['id']);
    $query=$this->db->query($sql);
    return true;
  }
  function setVolType($datas=null){
    if(!$datas)
      return false;
    if(!isset($datas['id']))
      return ;
    $sql = sprintf("UPDATE vols SET voltype  = %d WHERE id = %d LIMIT 1",$datas['voltype'],$datas['id']);
    $query=$this->db->query($sql);
    
    if($datas['uploader'])
      return true;

    $userlist = array(array('username'=>'zaki727','uid'=>2028852),
      array('username'=>'walter727','uid'=> 2028851),
      array('username'=>'sagar','uid'=>2028850),
      array('username'=>'whatever727','uid'=>2171767),
      array('username'=>'superfrank','uid'=>2173642),
      array('username'=>'Zane2011','uid'=>2418761),
      array('username'=>'Zafir11','uid'=>2418768),
      array('username'=>'Dagsoso','uid'=>2418773),
      array('username'=>'Darius','uid'=>2418774),
      array('username'=>'aarree','uid'=>2418776),
      array('username'=>'gabaibi','uid'=>2418777),
      array('username'=>'Garini','uid'=>2418779),
      array('username'=>'Jalme','uid'=>2418780),
      array('username'=>'mainlet','uid'=>2418781),
      array('username'=>'Malik12','uid'=>2418782),
      array('username'=>'popowen2','uid'=>2418783),
      array('username'=>'iphone10','uid'=>2418836),
      array('username'=>'Para00','uid'=>2418854),
      array('username'=>'ixian','uid'=>2418860),
      array('username'=>'Valingogo','uid'=>2418864),
      array('username'=>'igodzz','uid'=>2418865),
      array('username'=>'Raghnall','uid'=>2418867),
      array('username'=>'Radcliff','uid'=>2418868),
      array('username'=>'2yashwant','uid'=>2418872),
      array('username'=>'yeshudi','uid'=>2418873),
      array('username'=>'taksony','uid'=>2418874),
      array('username'=>'tancredo','uid'=>2418875),
      array('username'=>'Tannon','uid'=>2418876),
      array('username'=>'waghome','uid'=>2418877),
      array('username'=>'mians','uid'=>2419078),
      array('username'=>'tyy67','uid'=>2419079),
      array('username'=>'weijie6936','uid'=>2028845),
      array('username'=>'jiejie88','uid'=>2028843),
      array('username'=>'zhuqunhua','uid'=>2028846),
      array('username'=>'huahua88','uid'=>2028847),
      array('username'=>'panweijie88','uid'=>2028842),
      array('username'=>'holhol','uid'=>2419080),
      array('username'=>'lavender06','uid'=>2419082),
      array('username'=>'rayray8','uid'=>2419083),
      array('username'=>'gordeng','uid'=>2419084));
      $randkey = rand(0,39);
      $user = $userlist[$randkey];
      $row['username'] = $user['username'];
      $row['uid'] = $user['uid'];
      $sql = sprintf("UPDATE vols SET uploader  = '%s' WHERE id = %d LIMIT 1",$row['username'],$datas['id']);
      $query=$this->db->query($sql);
      return true;
  }
  function checkVolisOk($datas=null){
    if(!isset($datas['id']))
      return false;
    $sql = sprintf("SELECT COUNT( * ) AS okpages
FROM  `pages` 
WHERE vid =%d
AND isok =1",$datas['id']);

    $query = $this->db->query($sql);
    if($this->db->num_rows($query) < 1 )
      return false;
    $row   = $this->db->fetch_row($query);
    if(($row['okpages'] / ($datas['pages']))<0.75){
      return false;
    }

    $sql = sprintf("UPDATE vols SET isdone  = 1 , rtime = '%d' WHERE id = %d LIMIT 1",date("Ymd"),$datas['id']);
    $this->db->query($sql);
    return true;
  }
  function setPrevAndNextPageVolid($datas=null){
    if(!isset($datas['id']))
      return false;
    $sql = sprintf(" SELECT * FROM vols WHERE id != %d AND vol < %d AND comicid = %d ORDER BY vol DESC LIMIT 1 ",$datas['id'],intval($datas['vol']),$datas['comicid']);
    
    $query = $this->db->query($sql);
    if($this->db->num_rows($query) < 1 )
      return false;
    $prevVol   = $this->db->fetch_row();
    if($datas['vol'] != 1 && $prevVol['coverpid']){
        $sql = sprintf("UPDATE vols SET nextpid = %d WHERE id = %d LIMIT 1",$datas['coverpid'],$prevVol['id']);
        $this->db->query($sql);
        $sql = sprintf("UPDATE vols SET prevpid = %d WHERE id = %d LIMIT 1",$prevVol['coverpid'],$datas['id']);
        $this->db->query($sql);
    }
    return true;
  }


  function getVolsFromid($oid=null){
    if(!$oid)
     return false;
    $sql = sprintf("SELECT vols.*, pages.isok AS pageisok FROM vols LEFT JOIN pages ON (vols.coverpid = pages.id) WHERE vols.id='%d' LIMIT 1",$oid);
    $query = $this->db->query($sql);
    if($this->db->num_rows($query) < 1 )
      return false;
    $row = $this->db->fetch_row($query);
    return $row;
  }
  function getVolsByComicid($comicid=null){
    if(!$comicid)
      return false;

    $sql = sprintf("SELECT id FROM vols WHERE comicid = %d AND (isdone=0 OR coverpid = 0)"
           ,$comicid);
    $query = $this->db->query($sql);
    if($this->db->num_rows($query) < 1 )
      return false;

    $lists = $this->db->result_array($query);
    return $lists;
  }
  function workLog($uid= 0,$cid = 0,$pid = 0){
    if(!$uid || !$cid || !$pid)
      return 0;
    $cpwsql = sprintf('SELECT COUNT(*) AS m FROM pagesworklog WHERE pid = %d AND uid = %d 
                      LIMIT 1',$pid,$uid);
    $cpwquery = $this->db->query($cpwsql);
    $cpwrow = $this->db->fetch_row($cpwquery);
    if($cpwrow['m'] > 0)
      return 0;

    $cpwInsert = sprintf("INSERT INTO pagesworklog 
                          SET pid = %d ,
                          uid = %d ,
                          cid = %d ,
                          datetime = %d",$pid,$uid,$cid,time());
    $this->db->query($cpwInsert);
    $cwsql = sprintf('SELECT pwid FROM pageswork WHERE uid = %d AND date = %d LIMIT 1',
                      $uid ,date('Ymd'));
    $cwquery = $this->db->query($cwsql);
    if($this->db->num_rows($cwquery)>0){
      $cwuisql = sprintf('UPDATE pageswork SET ttotal = ttotal + 1 WHERE uid = %d AND 
                            date = %d LIMIT 1',$uid ,date('Ymd'));
    }else{
      $cwuisql = sprintf('INSERT INTO pageswork SET uid = %d,
                          ttotal = 1,
                          date = %d',$uid,date('Ymd')); 
    }
    $this->db->query($cwuisql);
  }
}
