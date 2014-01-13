<?php /* Smarty version Smarty-3.0.7, created on 2014-01-10 11:57:09
         compiled from "../app/views/play.new.html" */ ?>
<?php /*%%SmartyHeaderCode:12572088252cf6f95cdcef1-78222063%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b7bbd54176de7988d82465de1729f167db18fb62' => 
    array (
      0 => '../app/views/play.new.html',
      1 => 1389325899,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12572088252cf6f95cdcef1-78222063',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<section class="watchVideoContainer">
    <div class="masthead">
      <ul class="watchTitle">
<p>目前位置：</p>
        <li>
        <?php  $_smarty_tpl->tpl_vars['channel'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('channels')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['channel']->key => $_smarty_tpl->tpl_vars['channel']->value){
?><?php if ($_smarty_tpl->getVariable('cid')->value==$_smarty_tpl->tpl_vars['channel']->value['cid']){?><a href="/maindex/lists/<?php echo $_smarty_tpl->tpl_vars['channel']->value['cid'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
" class="globalText" ><?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
</a><?php }?><?php }} ?>
        </li>
        <li>></li>
        <li class="selected"><?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
</li>

      </ul>
    </div>
    
    <div class="watchVideo" id="watchVideo">
<?php if ($_smarty_tpl->getVariable('info')->value['ismp4']){?>
    <div class="video-js-box">
    <video class="video-js" id="videoplayer" ended="0" poster="<?php echo $_smarty_tpl->getVariable('info')->value['picurl'];?>
" height="480" width="800" controls="controls" >
            <source <?php if ($_smarty_tpl->getVariable('info')->value['ismp4']){?>type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' <?php }?>src="<?php echo $_smarty_tpl->getVariable('info')->value['videourl'];?>
"></source>
    </video>
    </div>
<?php }?>
    </div>

    <div class="downloadBox">
    <ul>
<?php if ($_smarty_tpl->getVariable('userInfo')->value['isvip']==2){?>
    <?php if ($_smarty_tpl->getVariable('isb')->value){?>
    <li><a href="/maindex/download/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
/B"  target="_blank" title="按此下載珍藏『高畫質影片原始檔』 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
">按此下載珍藏『高畫質影片原始檔』</a></li>
    <?php }else{ ?>
    <li><a href="/maindex/download/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
"    target="_blank" title="按此下載珍藏『高畫質影片原始檔』 <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
" >按此下載珍藏『高畫質影片原始檔』</a></li>
    <?php }?>
    <?php }else{ ?>
    <li><a href="#" class='issvipbutton'  title="按此下載珍藏『高畫質影片原始檔』<?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
" >按此下載珍藏『高畫質影片原始檔』</a></li>
    <?php }?>

    </ul>
    </div>
</section>
    <section class="mainBox">
    <div class="relatedVideo">
    <h3>相關影片</h3>
      <ul>
        <?php $_template = new Smarty_Internal_Template("lists.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
      </ul>
    </div>
</section>

<script type="text/javascript" src="http://av.ckcdn.com/js/jquery.js"></script>
<script type="text/javascript" src="http://av.ckcdn.com/js/ja/jquery.ui.draggable.js"></script>
<script type="text/javascript" src="http://av.ckcdn.com/js/ja/jquery.alerts.js"></script>
<?php if ($_smarty_tpl->getVariable('info')->value['ismp4']){?>
<script type="text/javascript" src="http://av.ckcdn.com/js/video.js"></script>
<link rel="stylesheet" href="http://av.ckcdn.com/css/video-js.css" type="text/css" media="screen" title="Video JS">
<?php }?>
<script type="text/javascript" src="http://av.ckcdn.com/jw/jwplayer.js"></script>
<script type="text/javascript">

    
<?php if ($_smarty_tpl->getVariable('userInfo')->value){?>
<?php if ($_smarty_tpl->getVariable('userInfo')->value['isvip']>0||!$_smarty_tpl->getVariable('lastFreeLog')->value){?>
<?php if ($_smarty_tpl->getVariable('ismp4')->value){?>
if($('video').attr('ended') != undefined) {
    VideoJS.setupAllWhenReady();
    $(document).ready(function() { $.get('/maindex/addPlayed/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
'); });

}else{
  $('#yt-alert-warn').show();
<?php }?>

  pflag = {flag:0,setFlag:function(f){this.flag=f;}}
  jwplayer("watchVideo").setup({
    'flashplayer': '/jw/player.swf',
    'provider':'http',
    'margin':'0',
    'id': 'playerID',
    'width': '900',
    'height': '540',
    'skin':'/skin/bekle.zip',
    'file': '<?php echo $_smarty_tpl->getVariable('info')->value['videourl'];?>
',
    'image': '<?php echo $_smarty_tpl->getVariable('info')->value['picurl'];?>
',
    'autostart':'true',
     'events':{onPlay:function(event){if(pflag.flag==0){jQ.get('/maindex/addPlayed/<?php echo $_smarty_tpl->getVariable('info')->value['avkey'];?>
');pflag.setFlag(1);return false;}else{return false;}}},
    'plugins': {
       'timeslidertooltipplugin-1': {}
    }
  });

<?php if ($_smarty_tpl->getVariable('ismp4')->value){?>
}
<?php }?>
<?php }?>
<?php }?>

  </script>
<script>
<?php if ($_smarty_tpl->getVariable('userInfo')->value['isvip']<1&&$_smarty_tpl->getVariable('lastFreeLog')->value){?>
jConfirm('觀看請先登入CK VIP!!!\n想登入VIP嗎？\n', '確認', function(r) {
        if(r){
           _gaq.push(['_trackEvent', 'pay','js-vipopen']);
           self.location.href=('http://ck101.com/85pay.php?op=info&utm_source=apen&utm_medium=play&utm_campaign=vipplay');
         }else
         return false;
 });

<?php }?>


$(document).ready(function() {
$('.issvipbutton').click(function(){
    jConfirm('下載只提供S-VIP下載!!!\n想加入S-VIP嗎？\n', '確認', function(r) {
        if(r){
            _gaq.push(['_trackEvent', 'pay','js-vipsopen']);
            window.open('http://ck101.com/85pay.php?op=info&utm_source=apen&utm_medium=play&utm_campaign=svipplay');
        }else
            return false;
    
    });
  });
});
</script>
<?php $_template = new Smarty_Internal_Template("footer.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
