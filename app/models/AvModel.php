<?php
 
class AvModel extends ModelBase{
  function initialize(){
    parent::initialize();
  } 

  function getChannelList(){
    $sql   = 'SELECT  `cid` ,  `name` ,  `videocount` FROM  `channel` WHERE `state` = 1 ';
    $query = $this->db->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }  

  function getVideosByCid($cid = null,$orderby = 'new',$p = 0,$perpage = 30){
      $p = $p > 1 ? ($p - 1) * $perpage : 0;
      $order = array('new' => 'createtime', 'hot' => 'viewcount', 'scores' => 'scores');
      $order = isset($order[$orderby]) ? $order[$orderby] : $order['new'];
      $orderbysql = sprintf(' ORDER BY  `video`.%s DESC ', $order);
      
      $wheresql = sprintf(' WHERE `video`.`createtime` <= \'%s\' AND status =1 ', date("Y-m-d"));
      if($cid){
          if($cid == 11)
            $wheresql .= ' AND video.ismp4 = 1 ';
          else
            $wheresql .= sprintf(' AND video.cid = %d ', $cid);
      }
      $sql = sprintf("SELECT  `avkey` ,  `cid` ,  `title` ,  `viewcount` ,  `scores` ,  `collectcount` ,  `createtime` ,  `serverid` ,  `lastview` ,`username` , `isessence` ,`ismasked`
        FROM  `video` %s %s LIMIT %d , %d",$wheresql,$orderbysql,$p,$perpage);

      $query = $this->db->query($sql);
      $lists = $query->fetchAll(PDO::FETCH_ASSOC);
      foreach($lists as $k => $v){
        $lists[$k]['picurl'] = $this->getPicUrl($v['avkey'],$v['serverid'],'b');
      }
      return $lists;
  }

  function getHotTags(){
     $sql = "SELECT  `name`, `url` FROM `toptags` LIMIT 30";
     $query = $this->db->query($sql);
     return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  function getLastFreeLog($uid = null){
    if(!$uid)
        return true;

    $sql = sprintf('SELECT createtime FROM `freelog` WHERE `uid` = %d AND `createtime` < %d AND `createtime` > %d LIMIT 1',$uid,time(),(time()-(24*60*60)));
    $query = $this->db->query($sql);
    if($query->rowCount() > 0)
        return true;

    return false;
  }

  function getTagsByVid($vid = null){
      if(!$vid)
        return;

      $sql = sprintf("SELECT t.tagid , t.name FROM tag AS t , videotag vt WHERE vt.vid = %d AND vt.tagid = t.tagid ",$vid);
      $query = $this->db->query($sql);
      if($query->rowCount() < 1)
            return false;

      return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  function getAvByid($avkey = null,$isb = null,$isdownload = null,$isadmin = null){
      if(!$avkey)
        return false;

      $moresql = sprintf(' AND status = 1 AND createtime <=\'%s\' ',date('Y-m-d'));
      if($isadmin)
          $moresql = '  ';

      $avK=str_replace('-','',$avkey);
      if($avK==$avkey){
         $avk = 'avkey = :avkey ';
      }else{
         $avk = '(avkey = :avkey or avkey = :avK)';
      }
      $sql = sprintf("SELECT * FROM `video` WHERE %s %s LIMIT 1",$avk,$moresql);
      $query = $this->db->prepare($sql);  
      $query->bindParam("avkey", $avkey);
      if($avK != $avkey){
         $query->bindParam("avK", $avK);
      }
      $query->execute();
      if($query->rowCount() < 1)
            return false;

      $row = $query->fetch(PDO::FETCH_ASSOC);
/*
      $filenameExtension = ".flv";
      if($isdownload)
        $filenameExtension = ".avi";
      if($row['ismp4']==1)
*/
        $filenameExtension = ".mp4";

      if($isb && $row['bkey'])
        $row['videourl'] = $this->getVideoUrl($row['bkey'].$filenameExtension,$row['serverid']);
      else
        $row['videourl'] = $this->getVideoUrl($row['avkey'].$filenameExtension,$row['serverid']);

      return $row;
  }

  function getAvTokenByPoint($uid, $key, $isdownload = 0){
    if( !$uid || !$key){
       return false;
    }
    $nowtime = time();
    $sql = sprintf('DELETE FROM `videobuy` WHERE `endtime`<%d ', $nowtime);
    $this->db->query($sql);
    $sql = sprintf('SELECT `uid` FROM `videobuy` WHERE `endtime`>%d AND `avkey`=:avkey AND uid=%d LIMIT 1', $nowtime, $uid);
    $query = $this->db->prepare($sql);
    $query->bindParam('avkey', $key);
    $query->execute();
//  已經扣點
    if($query->rowCount()){
       return true;
    }
//  未扣點
    $perAvPoint = 39;
    $sql = sprintf('SELECT  `point` FROM `user` WHERE `uid`=%d LIMIT 1', $uid);
    $query = $this->db->query($sql);
    $uinfo = $query->fetch(PDO::FETCH_ASSOC);
//  剩餘點數不足以購買
    if($perAvPoint > $uinfo['point']){
      return false;
    }
    $sql = sprintf('UPDATE `user` SET `point`=`point`-%d WHERE `uid`=%d LIMIT 1', $perAvPoint, $uid);
    $this->db->query($sql);
    $buydata = array('uid'=>$uid, 'avkey'=>$key, 'startdate'=>$nowtime, 'endtime'=>strtotime('+2 day', $nowtime));
    $this->addVideoBuyRow('videobuy', $buydata);
    $this->addVideoBuyRow('videobuylog', $buydata);
    return true; 
  }

  function addVideoBuyRow($table, $data){
    $sql = sprintf('INSERT INTO `%s`(`uid`, `avkey`, `startdate`, `endtime`) VALUES (:uid, :avkey, :startdate, :endtime)',$table);
    $query = $this->db->prepare($sql);
    $query->bindParam('uid', $data['uid']);
    $query->bindParam('avkey', $data['avkey']);
    $query->bindParam('startdate', $data['startdate']);
    $query->bindParam('endtime', $data['endtime']);
    $query->execute();
    return $this->db->lastInsertId();
  }

  function insert_string($table, $data){
    $key = $value = array();
    foreach($data as $k => $v){
      $key[] = "$k";
      $value[] = ":$k";
    }
    $value = implode(',', $value);
    $key = implode(',', $key);
    $sql = sprintf('INSERT INTO `%s`(%s) VALUES (%s)', $table, $key, $value);
    $query = $this->db->prepare($sql);
//var_dump($data);die($sql);
    foreach($data as $k => $v){
echo $k,' ',$v,'|';
      $query->bindParam($k, $v);
    }
    $query->execute();
    return $this->db->lastInsertId();
  } 

  function update_string($table, $data, $where){
    $data_sql = $where_sql = array();
    foreach($data as $k => $v){
      $data_sql[] = "`$k`=:$k";
    }
    foreach($where as $k => $v){
      $where_sql[] = "`$k`=:$k";
    }
    $key_val = array_merge($data, $where);
    $data = implode(',', $data_sql);
    $where = implode(' AND ', $where_sql);
    $sql = sprintf('UPDATE `%s` SET %s WHERE %s', $table, $data, $where);
    $query = $this->db->prepare($sql);
    foreach($key_val as $k => $v){
      $query->bindParam($k, $v);
    }
    $query->execute();
    return true;
  }

  function updateUserIP($uid = null,$uip = null){
    if(!$uid||!$uip)
      return ;
    $sql = sprintf('UPDATE `av`.`user` SET `lastip` = :uip WHERE uid = %d LIMIT 1',$uid);
    $query = $this->db->prepare($sql);
    $query->bindParam("uip", $uip);
    $query->execute();

    return true;

  }
 
  function addLog($avkey = null,$uid = null,$col = 'viewcount'){
      if( !$avkey || !$uid)
        return false;

      $sql = 'SELECT vid,cid,avkey,serverid FROM `video` WHERE avkey = :avkey LIMIT 1';
      $query = $this->db->prepare($sql);
      $query->bindParam("avkey", $avkey);
      $query->execute();
      if($query->rowCount() < 1)
            return false;

      $table = array('playcount' =>'playlog','downloadcount' =>'downloadlog','collectcount' =>'collect','freecount' =>'freelog');
      $table = isset($table[$col]) ? $table[$col] : null;

      $row = $query->fetch(PDO::FETCH_ASSOC);
      if($table === 'playlog' || $table === 'downloadlog'){
        $sql = sprintf("SELECT id FROM videohitslog WHERE vid = %d AND date = %d LIMIT 1",$row['vid'],date("Ymd"));
        $query  = $this->db->query($sql);
        $hitsRow  = $query->fetch(PDO::FETCH_ASSOC);
        if($query->rowCount() > 0){
          $sql = sprintf("UPDATE videohitslog SET hits = hits + 1 WHERE id = %d LIMIT 1",$hitsRow['id']);
          $this->db->query($sql);
        }else{
          $sql = sprintf("INSERT INTO  `videohitslog` (`id` ,`cid` ,`vid` ,`date`,`avkey` , `serverid`) VALUES ( NULL , '%d' ,  '%d',  '%d',:avkey ,:serverid)",$row['cid'],$row['vid'],date("Ymd"));
          $query = $this->db->prepare($sql);
          $query->bindParam("avkey", $row['avkey']);
          $query->bindParam("serverid", $row['serverid']);
          $query->execute();
        }
      }
      if($table == 'collect'){
        $sql = sprintf("SELECT vid FROM `%s` WHERE vid = %d AND uid = %d LIMIT 1",$table,$row['vid'],$uid);
        $query = $this->db->query($sql);
        if($query->rowCount() > 0){
            $sql = sprintf("UPDATE  `av`.`user` SET  `%s` =  `%s` - 1 WHERE  `user`.`uid` = %d LIMIT 1;",$col,$col,$uid);
            $query = $this->db->query($sql);
            $sql = sprintf("DELETE FROM `av`.`collect` WHERE `collect`.`uid` = %d AND `collect`.`vid` = %d LIMIT 1",$uid,$row['vid']);
            $query = $this->db->query($sql);
            return false;
        }
        $sql = sprintf("UPDATE  `av`.`user` SET  `%s` =  `%s` + 1 WHERE  `user`.`uid` = %d LIMIT 1",$col,$col,$uid);
        $query = $this->db->query($sql);
      }
      $sql = sprintf("UPDATE  `av`.`video` SET  `%s` =  `%s` + 1 , lastview = %d WHERE  `video`.`vid` = %d LIMIT 1;",$col,$col,time(),$row['vid']);
      $query = $this->db->query($sql);
      if($table){
          $row = array('vid'=>$row['vid'],'uid'=>$uid,'createtime'=>time());
          $sql = sprintf('INSERT INTO `%s`(`vid`,`uid`,`createtime`) VALUES (%d,%d,%d)',$table,$row);
          $query = $this->db->query($sql);
      }
      return true;
  }

  function getUserFromVideo($uid, $ucRow){
      if( !$uid || !$ucRow['uid'])
        return false;

      $sql      = sprintf("SELECT uid ,  username ,isvip ,collectcount , watchedcount , lastip  FROM `user` WHERE uid = '%d' LIMIT 1",$uid);
      $query    = $this->db->query($sql);
      $row      = $query->fetch(PDO::FETCH_ASSOC);
      $isvip = 0;
      if($ucRow['groupid'] ==68 ||$ucRow['groupid'] ==1||$ucRow['groupid'] ==2||$ucRow['groupid'] ==3 ||$ucRow['groupid'] ==59||$ucRow['groupid'] ==72)
          $isvip = 1;

      if($ucRow['groupid'] ==77 || $ucRow['groupid'] == 1)
            $isvip = 2;

      if($ucRow['uid'] && $ucRow['username'] && $row['uid']){
        if($isvip){
          $ip = get_client_ip();
          $this->db->query("UPDATE `user` SET `isvip` = ".intval($isvip).",lastip ='".$ip."' WHERE uid = '".intval($uid)."' LIMIT 1");
        }
        return $row;
      }

      $sql  = sprintf("INSERT INTO `user` (
                                    `uid` ,`username`,`isvip`  )VALUES ('%d', '%s','%d');",
            $ucRow['uid'],$ucRow['username'],$isvip);
      $this->db->query($sql);

      return $ucRow;
  }
  
  
}
