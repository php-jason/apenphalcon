<?php
class MaindexController extends WebBase {
  public function initialize() {
    parent::initialize();
  }

  function ckiframeAction(){
    $this->smarty->assign($this->viewData);
    $this->smarty->display('ckindex.html');
    fastcgi_finish_request();
  }

  function indexAction(){
    $this->smarty->assign($this->viewData);
    $this->smarty->display("index.html");
    fastcgi_finish_request();
  }

  function cindexAction($message = null){
    $wk=date("w");
    $wkday=array(0 =>array('en'=>'sunday','zn'=>'日','wk'=>0),1=>array('en'=>'monday','zn'=>'一','wk'=>1),2=>array('en'=>'tuesday','zn'=>'二','wk'=>2),3=>array('en'=>'wednesday','zn'=>'三','wk'=>3),4=>array('en'=>'thursday','zn'=>'四','wk'=>4),5=>array('en'=>'friday','zn'=>'五','wk'=>5),6=>array('en'=>'saturday','zn'=>'六','wk'=>6));
    $weeklylist = $this->viewData["weeklyCountList"];
    $wkday[0]['num']=$weeklylist[0]['total'];
    $wkday[1]['num']=$weeklylist[1]['total'];
    $wkday[2]['num']=$weeklylist[2]['total'];
    $wkday[3]['num']=$weeklylist[3]['total'];
    $wkday[4]['num']=$weeklylist[4]['total'];
    $wkday[5]['num']=$weeklylist[5]['total'];
    $wkday[6]['num']=$weeklylist[6]['total'];
    $wkpick=$wkday[$wk];unset($wkday[$wk]);
    array_unshift($wkday,$wkpick);
    $channellist = $this->viewData["comicChannelList"];
    $volsKey=array();
    foreach($channellist as $v)
    {
      $volskey[]="nc-indexvolshotlist{$v['id']}";
      $lists=array();
      array_unshift($lists,array("name"=>$v['name']));
      $vlists[]=$lists;
    }
    $mlists=$this->multicache->get($volskey);
    if(count($mlists)<=0){
       unset($vlists);
       while(list($k,$v) = each($channellist))
       {
         $lists = $this->indexModel->getIndexHotComicsByDate(date('Ymd',strtotime("-1 day")),1,15,$v['id']);
        array_unshift($lists,array("name"=>$v['name']));
        if(isset($lists[1]))
          $this->multicache->set("nc-indexvolshotlist{$v['id']}",$lists);
        $vlists[]=$lists;
       }
    }
    foreach($mlists as $m){
      foreach($vlists as $k => $v){
        if($m[0]['name'] == $v[0]['name'])
          $vlists[$k]=$m;
      }
    }
    $hash=$this->array_pick($vlists,3);
    $key=array_keys($hash);
    $this->_setViewData(array("indexvolshotlist1"=>$hash[$key[0]],"indexvolshotlist2"=>$hash[$key[1]],"indexvolshotlist3"=>$hash[$key[2]],"wkday"=>$wkday));
    $this->smarty->assign($this->viewData);
    $this->smarty->display('cindex.html');
    fastcgi_finish_request();
  }

  function weeklylistsAction($wkday = null,$nowpage = 0){
    $newwk = date('w');
    $wkar=array(0 =>array('en'=>'sunday','zn'=>'日'),1=>array('en'=>'monday','zn'=>'一'),2=>array('en'=>'tuesday','zn'=>'二'),3=>array('en'=>'wednesday','zn'=>'三'),4=>array('en'=>'thursday','zn'=>'四'),5=>array('en'=>'friday','zn'=>'五'),6=>array('en'=>'saturday','zn'=>'六'));
    $wkar[$newwk]['day']=date("Ymd");
    for($i=1;$i<=6;$i++){
      $wk=date("w",strtotime("-{$i} day"));
      $wkar[$wk]['day']=date("Ymd",strtotime("-{$i} day"));
    }
    if(!isset($wkar[$wkday]))
      $wkday=$newwk;

    $lists = $this->indexModel->getVolsByrtime($wkar[$wkday]['day'],$nowpage,30);

    $ttotal = $this->indexModel->getWeeklyCountById($wkday);
    if($ttotal){
      $PAGESTR = $this->page->getPaginationString($nowpage, $ttotal, 30, 1, "/", "weeklylists/".$wkday."/");
      $this->_setViewData(array('PAGESTR'=>$PAGESTR,'ttotal'=>$ttotal));
    }
    $this->_setViewData(array('lists'=>$lists,'nowpage'=>$nowpage,'weekly'=>$wkar[$wkday]['zn'],'day'=>$wkar[$wkday]['day']));
    $this->smarty->assign($this->viewData);
    $this->smarty->display("weeklylists.html");
    fastcgi_finish_request();
  }
  
  function rankAction(){
     $channel = $this->viewData["comicChannelList"];
     foreach($channel as $v){
        $volskey[]="nc-indexvolshotlist{$v['id']}";
        $lists=array();
        array_unshift($lists,array("name"=>$v['name']));
        $vlists[]=$lists;
     }
     $mlists=$this->multicache->get($volskey);
     if(count($mlists)<=0){
       unset($vlists);
       while(list($k,$v) = each($channel))
       {
         $lists = $this->indexModel->getIndexHotComicsByDate(date('Ymd',strtotime("-1 day")),1,15,$v['id']);
        array_unshift($lists,array("name"=>$v['name']));
        if(isset($lists[1]))
          $this->multicache->set("nc-indexvolshotlist{$v['id']}",$lists);
        $vlists[]=$lists;
       }
       }
     foreach($vlists as $k => $v){
      foreach($mlists as $m){
        if($m[0]['name'] == $v[0]['name'])
          $vlists[$k]=$m;
      }
      $vData["rankingvolshotlist".($k+1)] = $vlists[$k];
     }
     $this->_setViewData($vData);
     $this->smarty->assign($this->viewData);
     $this->smarty->display("rank.html");
     fastcgi_finish_request();
  }

 
 function hotcomicAction($nowpage = 1){
    if(intval($nowpage<=0))
      $nowpage=1;
    else if(intval($nowpage>10))
      $nowpage=10;

    
    $lists = $this->multicache->get('nc-hotcomic'.$nowpage);
    
    if(!isset($lists['0'])){
      $lists = $this->indexModel->getIndexHotComicsByRtime(date('Ymd',strtotime("-1 day")),$nowpage,20,1);
      
      
      $this->multicache->set('nc-hotcomic'.$nowpage,$lists);
    }
    $ttotal = 200;
    if($ttotal){
      $PAGESTR = $this->page->getPaginationString($nowpage, $ttotal, 20, 1, "/", "hotcomic/");
      $this->_setViewData(array('PAGESTR'=>$PAGESTR,'ttotal'=>$ttotal));
    }
    $this->_setViewData(array('lists'=>$lists,'nowpage'=>$nowpage));
    $this->smarty->assign($this->viewData);
    $this->smarty->display("hotcomic.html");
    fastcgi_finish_request();
 }

 function randomcomicAction($nowpage = 1){
    $lists = $this->indexModel->getIndexHotComics('lastview',$nowpage,30);
    $ttotal = 0;
    foreach($this->comicChannelList as $k => $v){
       $ttotal += intval($v['ttotal']);
    }

    if($ttotal){
        $PAGESTR = $this->page->getPaginationString($nowpage, $ttotal,30,1,"/", "randomcomic/");
        $this->_setViewData(array('PAGESTR'=>$PAGESTR,'ttotal'=>$ttotal));
    }
    $this->_setViewData(array('lists'=>$lists,'nowpage'=>$nowpage));
    $this->smarty->assign($this->viewData);
    $this->smarty->display("randomcomic.html");
    fastcgi_finish_request();
 }

   function sitemapAction($type = 0){
    if(isset($_SERVER['REQUEST_URI']))
      return;

    $comicList = $this->indexModel->getAllComicid();
    $allCover  = $this->indexModel->getAllCover();
    $this->_setViewData(array('comiclist'=>$comicList,'allCover'=>$allCover));
    $output = $this->smartyview->render('sitemap.xml',$this->viewData,1);

    $myFile = "/home/comic/html/comic101.com/sitemap.xml";
    $fh = fopen($myFile, 'w') or die("can't open file");
    fwrite($fh, $output);
    fclose($fh);

 }

  function setSiteMap(){
   if(isset($_SERVER['REQUEST_URI']))
    return;

   $tagAllList = $this->indexModel->getTagAll();
   $this->_setViewData(array('tagAllList'=>$tagAllList));
   $output = $this->smartyview->render('sitemap.html',$this->viewData,1);
   $myFile = "/home/comic/html/comic101.com/sitemap.html";
   $fh = fopen($myFile, 'w') or die("can't open file");
   fwrite($fh, $output);
   fclose($fh);
 }

  function resetMemCachedAction($key = null){

    $this->_resetMemCached = true;
    $this->resetMem($key);
    echo 1;
  }

  function faqAction(){
    $this->smartyview->render("faq.html",$this->viewData);
  }

  function fbloginAction(){
    $u=$this->fbLoginUser();
    if(!$u)
      die(json_encode(array('status'=>0)));
    else{
      $sessionid=$this->session->userdata('session_id');
      die(json_encode(array('status'=>1,'sessionid'=>$sessionid)));
    }
  }

  
  function auditAdultAction($type = 0,$date=null,$nowpage=1){
    if(!$type)
      die(json_encode(array('status'=>0)));

    switch($type){
      case 1:
      $lists = $this->_memCache['updateAdvisories'];
      break;
      case 2:
      $lists = $this->indexModel->getVolsByrtime($date,$nowpage,30);
      break;
      case 3:
      $lists = $this->multicache->get('nc-hotcomic'.$nowpage);
      if(!isset($lists['0'])){
        $lists = $this->indexModel->getIndexHotComicsByRtime(date('Ymd',strtotime("-1 day")),$nowpage,20,1);
        $this->multicache->set('nc-hotcomic'.$nowpage,$lists);
      }
      break;
       }
    if(!is_array($lists))
      die(json_encode(array('status'=>0)));

    foreach($lists as $v){
      $ncount =  $this->indexModel->getPagesByvidAndadultCount($v['id']);
      if(!$ncount)
        continue;

      $this->indexModel->setVolsByidWithOrdinary($v['id'],$ncount);
      $this->indexModel->setCheckIndex($type,$v);
      $this->indexModel->setCheckIndexLog($v['id'],$type,$ncount);

    }
    die(json_encode(array('status'=>1)));
  }

  function show404Action(){
    $this->smarty->assign($this->viewData);
    $this->smarty->display('error_404.html');
    fastcgi_finish_request();
  }

  function logoutAction(){
    $this->session->destroy();
    setcookie('iTiQ_c4ec_auth',"",time()-3600,"/",".ck101.com");
    setcookie("cdb_auth", "", time()-3600,"/",".ck101.com");
    setcookie("cdb_sid", "", time()-3600,"/",".ck101.com");
    setcookie("Lre7_9bf0_auth", "", time()-3600,"/",".ck101.com");
    setcookie("Lre7_9bf0_sid", "", time()-3600,"/",".ck101.com");
    $this->response->redirect($this->config->url->base_url,true);
  }

  function isUserInfoAction(){
   if(!$this->_userInfo)
     die(json_encode(array('status'=>0)));
   else
     die(json_encode(array('status'=>1)));
 }

}

