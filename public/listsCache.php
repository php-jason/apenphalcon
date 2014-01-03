<?php
require 'db.class.php';

$fpath='/home/jason/html/comicphalcon/public/listscache/';

$ls=array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,15,16);

$db=new dbstuff();
$db->connect('10.52.21.3', 'newman');
$cid = 0;
foreach($ls as $cid){
$sql = sprintf("SELECT * FROM %s ORDER BY `id` DESC LIMIT 12 ",$cid==0?'indextopten':sprintf('cate%dtopten',$cid));

$list=$db->fetch_all($sql);
array2File($list,$fpath.'list'.$cid.'.php');
}
$db->close();

function array2File($arr,$fname){
   $str="<?php\nretun array(";
   foreach($arr as $val){
      $str.='array(';
      foreach($val as $k=>$v){
         $str.='\''.$k.'\'=>\''.$v.'\',';
      }
      $str=trim($str,',');
      $str.='),';
   }
   $str=trim($str,',');
   $str.=");\n?>";
   file_put_contents($fname,$str);
}
?>
