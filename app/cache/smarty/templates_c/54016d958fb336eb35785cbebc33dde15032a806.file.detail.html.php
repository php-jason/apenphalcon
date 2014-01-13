<?php /* Smarty version Smarty-3.0.7, created on 2014-01-13 15:31:08
         compiled from "../app/views/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:174608441652d3963c1b3e11-25450910%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54016d958fb336eb35785cbebc33dde15032a806' => 
    array (
      0 => '../app/views/detail.html',
      1 => 1389592832,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '174608441652d3963c1b3e11-25450910',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<section class="mainContainer">
<?php $_template = new Smarty_Internal_Template("directory.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
  <section class="focusArea">
    <div class="masthead">
      <ul class="breadcrumbs">
        <p>目前位置：</p>
        <li>
        <?php  $_smarty_tpl->tpl_vars['channel'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('channels')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['channel']->key => $_smarty_tpl->tpl_vars['channel']->value){
?>      <?php if ($_smarty_tpl->getVariable('cid')->value==$_smarty_tpl->tpl_vars['channel']->value['cid']){?><a onclick="_gaq.push(['_trackEvent', 'channels','<?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
']);" href="/maindex/lists/<?php echo $_smarty_tpl->tpl_vars['channel']->value['cid'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
" class="globalText" ><?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
</a><?php }?><?php }} ?>
        </li>
        <li>></li><li class="selected"><?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
</li>
        <li><?php if ($_smarty_tpl->getVariable('isAdmin')->value>0){?>
    <a href="/avadmin/detail/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
" target="_blank" style="color:red;">edit</a>
    <?php }?></li>
      </ul>
    </div>
    <div class="adultAlbum">
    <div class="watchVideo" id="watchVideo">
    <div class="video-js-box">
    <video class="video-js" id="videoplayer" ended="0" poster="<?php echo $_smarty_tpl->getVariable('info')->value['picurl'];?>
" height="480" width="800" controls="controls" >
            <source type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' src=""></source>
    </video>
    </div>
    </div> 
<a class="pirobox_gall1 item" rel="content-800-536" title="<?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
" href="/maindex/img/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
/<?php echo $_smarty_tpl->getVariable('info')->value['serverid'];?>
" rev="1">
<img src='<?php echo $_smarty_tpl->getVariable('info')->value['picurl'];?>
' onError="this.src='/images/global/error2x.jpg';" alt="<?php echo preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('info')->value['description']);?>
"/>
</a>
    </div>
    <?php if ($_smarty_tpl->getVariable('info')->value['ismp4']){?><div class="ipadSupport">本影片支援在ipad等行動裝置上觀看</div><?php }?> 
    <div class="videoPay">
    <ul class="online">
    <?php if ($_smarty_tpl->getVariable('userInfo')->value['isvip']>0||!$_smarty_tpl->getVariable('lastFreeLog')->value){?>
      <?php if ($_smarty_tpl->getVariable('info')->value['bkey']){?>
    <li><a href="/maindex/play/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
/B"  target="_blank" title="播放 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
">B面</a></li>
    <li><a href="/maindex/play/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
"    target="_blank" title="播放 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
" >A面</a></li>
      <?php }else{ ?>
    <li><a href="/maindex/play/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
" id="playBtn"   target="_blank" title="播放 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
" >播放</a></li>
      <?php }?>
    <?php }else{ ?>
      <?php if ($_smarty_tpl->getVariable('info')->value['bkey']){?>
    <li><a href="#" class="isvipbtnplay"  title="播放 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
">B面</a></li>
    <li><a href="#" class="isvipbtnplay"  title="播放 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
" >A面</a></li>
      <?php }else{ ?>
    <li><a href="#" class="isvipbtnplay" id="playBtn"  title="播放 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
" >播放</a></li>
      <?php }?>
    <?php }?> 
    </ul>
    <ul class="download">
    <?php if ($_smarty_tpl->getVariable('userInfo')->value['isvip']==2){?>
    <?php if ($_smarty_tpl->getVariable('info')->value['bkey']){?>
    <li><a href="/maindex/download/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
/B"  target="_blank" title="下載 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
">B面</a></li>
    <li><a href="/maindex/download/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
"    target="_blank" title="下載 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
" >A面</a></li>
    <?php }else{ ?>
    <li><a href="/maindex/download/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
"    target="_blank" title="下載 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
" >下載</a></li>
    <?php }?>
    <?php }else{ ?>
    <?php if ($_smarty_tpl->getVariable('info')->value['bkey']){?>
    <li><a href="#" class="issvipbutton" title="下載 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
">B面</a></li>
    <li><a href="#" class="issvipbutton" title="下載 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
" >A面</a></li>
    <?php }else{ ?>
    <li><a href="#" class="issvipbutton" title="下載 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
" >下載</a></li>
    <?php }?>
    <?php }?>
    </ul>
    </div>
    <div class="descriptionInfo">
    <?php if (0){?>
    <div class="Evaluation">
    <?php if (0){?><ul class="star_rating"><li class="current_rating star_4">4</li></ul><span>共有14人評分</span><?php }?>
    <div class="facebook"><iframe class="fblikes" src="http://www.facebook.com/plugins/like.php?locale=zh_TW&href=<?php echo urlencode($_smarty_tpl->getVariable('nowurl')->value);?>
&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=25" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:25px; margin:0px 0px 0px 10px; " allowTransparency="true"></iframe></div>
    <?php if (!$_smarty_tpl->getVariable('isCollected')->value){?>
    <p class="watchlike" id="watchlike" ><a href="#" title="">將本片加入到我的收藏</a></p>
    <?php }else{ ?>
    <p class="likeSelected" id="watchlike" ><a href="#" title="">已加入我的收藏！</a></p>
    <?php }?>
    </div>
    <?php }?>
    <ul class="detail">
    <li>上傳帳號：<?php echo substr($_smarty_tpl->getVariable('info')->value['username'],5);?>
*********</li>
    <li id="watchlike" ><a href="" class="globalText">
    <?php if (!$_smarty_tpl->getVariable('isCollected')->value){?>
    將本片加入到我的最愛
    <?php }else{ ?>
    已加入我的收藏!
    <?php }?>
    </a> &nbsp;&nbsp;
    </li>
    <li class="title">影片名稱：<?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
</li>
    <li>馬賽克：<?php if ($_smarty_tpl->getVariable('info')->value['ismasked']){?>薄碼<?php }else{ ?>無碼<?php }?></li>
    <li>分類：
    <?php  $_smarty_tpl->tpl_vars['channel'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('channels')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['channel']->key => $_smarty_tpl->tpl_vars['channel']->value){
?>
      <?php if ($_smarty_tpl->getVariable('cid')->value==$_smarty_tpl->tpl_vars['channel']->value['cid']){?><a onclick="_gaq.push(['_trackEvent', 'channels','<?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
']);" href="/maindex/lists/<?php echo $_smarty_tpl->tpl_vars['channel']->value['cid'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
" class="globalText" ><?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
</a><?php }?><?php }} ?>
    </li>
    <li>上架時間：<?php echo $_smarty_tpl->getVariable('info')->value['createtime'];?>
</li>
      <li>影片編號：<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
</li>
    <li class="extra"><em></em><?php echo $_smarty_tpl->getVariable('info')->value['description'];?>
</li>
    <li class="extra"><em></em>關鍵字：
      <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('taglists')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
      <a onclick="_gaq.push(['_trackEvent', 'hotTags','<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
']);" href="/maindex/tag/<?php echo urlencode($_smarty_tpl->tpl_vars['row']->value['name']);?>
" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" class="globalText"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</a>
      <?php }} ?>
      </li>
    </ul>
    </div>
    <div class="fbMessage"><div id="fbcomments" style="margin:10px 0 0 10px;">
        </div></div>
<div class="section">
<h3>其他相關影片</h3>
<ul>
      <?php $_template = new Smarty_Internal_Template("lists.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    </ul>
    </div> 
    </section>
</section>
<script type="text/javascript" src="/js/jquery.js"></script>
<!--
<script type="text/javascript" src="/js/ja/jquery.ui.draggable.js"></script>
<script type="text/javascript" src="/js/ja/jquery.alerts.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="/js/pirobox_extended.js"></script>
-->
<?php if (1){?>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
/js/jwplayer/jwplayer.js"></script>
<?php }?>
<script>
/*
jwplayer("watchVideo").setup({
    image: "<?php echo $_smarty_tpl->getVariable('info')->value['picurl'];?>
",
    //file: "http://content.bitsontherun.com/videos/i8oQD9zd-640.mp4",
    file: "",
    fullscreen: true,
    autostart: false,
    height: 750,
    width: 750
  });
*/
function loadPlay(myFile, myImage){
/*
  jwplayer("watchVideo").load([{
      file: myFile
     ,image: myImage
     ,fullscreen: true
     ,autostart: false
     ,height: 750
     ,width: 750
  }]);
  jwplayer("watchVideo").play();
*/
  pflag = {flag:0,setFlag:function(f){this.flag=f;}}
  jwplayer("watchVideo").setup({
    image: "<?php echo $_smarty_tpl->getVariable('info')->value['picurl'];?>
",
    file: "http://content.bitsontherun.com/videos/i8oQD9zd-640.mp4",
    autostart: true,
    'events':{onReady: function(evt) { $('#watchVideo_menu,#watchVideo_logo').remove(); },onPlay:function(evt){if(pflag.flag==0){$.get('/api/addPlayed/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
');pflag.setFlag(1);return false;}else{return false;}}},
    height: 750,
    width: 750
  });
}
$('#playBtn').click(function(){
  $.getJSON("/api/videourl/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
/0/0",function(result){
    if(result.status == 200){
       myFile = result.videourl;
       myImage = result.picurl;
       loadPlay(myFile,myImage);
       alert(myFile);
    }else{
       alert(result.status);
    }
  },'json');  
return false;
});

$(document).ready(function() {

<?php if ($_smarty_tpl->getVariable('isadmin')->value){?>
$('#delavdown').click(function(e){
  if(!confirm('您確定要下架此影片嗎？')){
      if (e) //停止事件冒泡 
       e.stopPropagation(); 

     return false;
  }
  return true;
});

<?php }?>
/*
  $().piroBox_ext({
        piro_speed : 900,
        bg_alpha : 0.1,
        piro_scroll : true //pirobox always positioned at the center of the page
    });
*/

  $('.isvipbtnplay').click(function(){    
      jConfirm('觀看只提供VIP觀看!!!\n想加入VIP嗎？\n', '確認', function(r) {
        if(r){ 
            _gaq.push(['_trackEvent', 'pay','js-vipopen']);           
            window.open('http://ck101.com/85pay.php?op=info&utm_source=apen&utm_medium=detail&utm_campaign=vipplay');
        }else
            return false;    
    });
  });

  $('.isvipbutton').click(function(){    
      jConfirm('下載只提供VIP觀看!!!\n想加入VIP嗎？\n', '確認', function(r) {
        if(r){    
            _gaq.push(['_trackEvent', 'pay','js-vipsopen']);        
            window.open('http://ck101.com/85pay.php?op=info&utm_source=apen&utm_medium=detail&utm_campaign=svipplay');
        }else
            return false;    
    });
  });

  $('.issvipbutton').click(function(){
    jConfirm('下載只提供S-VIP下載!!!\n想加入S-VIP嗎？\n', '確認', function(r) {
        if(r){
            _gaq.push(['_trackEvent', 'pay','js-vipsopen']);
            window.open('http://ck101.com/85pay.php?op=info&utm_source=apen&utm_medium=detail&utm_campaign=svipplay');
        }else
            return false;
    
    });
  });



  $('#watchlike').click(function() {
    <?php if ($_smarty_tpl->getVariable('userInfo')->value['uid']){?>
    $.get('/maindex/addCollection/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
',function(data){
      if(data.status==1){
          $("#watchlike").removeClass('watchlike'); 
          $("#watchlike").addClass('likeSelected');
          $("#watchlike").html('<a href="#" title="">已加入我的收藏！</a>');
      }
      if(data.status==0){
          $("#watchlike").removeClass('likeSelected'); 
          $("#watchlike").addClass('watchlike');
          $("#watchlike").html('<a href="#" title="">將本片加入到我的收藏</a>');
      }

     }, "json"); 
      return false;
    <?php }else{ ?>
      jConfirm('加入收藏只提供VIP!!!\n想加入VIP嗎？\n', '確認', function(r) {
        if(r){
            _gaq.push(['_trackEvent', 'pay','js-vipopen']);
            window.open('http://ck101.com/85pay.php?op=info&utm_source=apen&utm_medium=detail&utm_campaign=vipplay');
        }else 
            return false;
      });

    <?php }?>
  });
});
</script>
<div id ='fb-root'></div>

<?php $_template = new Smarty_Internal_Template("footer.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
