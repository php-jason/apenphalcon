<?php
require 'db.class.php';
$cfg='/home/jason/html/comicphalcon/app/config/config.ini';

$db=new dbstuff();
$db->connect('10.52.21.3', 'newman');
$sql='SELECT id,name,ttotal FROM  `cate` WHERE `status` = 1 ORDER BY sorts ASC';
$list=$db->fetch_all($sql);
$db->close();

$data=json_encode($list);
$node='[channellist],list';

setConfigIni($cfg,$node,$data);

unset($data);
unset($list);

/**
$node xxx,xxx
*/
function setConfigIni($fname,$node,$data){
   $files=@file($fname);
   if(!$files){
     return 0;
   }
   $fp=0;
   $narr=explode(',',$node);
   $len=count($narr)-1;
   if($len<0)
     return 0;

   foreach($files as $key=>$line){
      $arr=explode('=',$line);
      if(trim($narr[$fp])==trim($arr[0])){

         if($fp==$len){
            $files[$key]=$arr[0]."= "."'".$data."'\n";

            break;
         }
         $fp++;

      }
   }//end foreach file

   $fp=@fopen($fname,'w');
   foreach($files as $line){
      fputs($fp,$line);
   }
   fclose($fp);

}

?>
