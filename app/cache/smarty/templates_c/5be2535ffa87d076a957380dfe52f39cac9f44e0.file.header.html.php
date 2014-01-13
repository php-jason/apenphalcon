<?php /* Smarty version Smarty-3.0.7, created on 2014-01-09 17:52:15
         compiled from "../app/views/header.html" */ ?>
<?php /*%%SmartyHeaderCode:61508783052ce714fc88e89-50382613%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5be2535ffa87d076a957380dfe52f39cac9f44e0' => 
    array (
      0 => '../app/views/header.html',
      1 => 1389257699,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '61508783052ce714fc88e89-50382613',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/"
      xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title> 免費A片 <?php if ($_smarty_tpl->getVariable('pageMethod')->value==='tag'){?>tag類表 > <?php echo $_smarty_tpl->getVariable('tagname')->value;?>
<?php }elseif($_smarty_tpl->getVariable('pageMethod')->value==='lists'){?>影片類表 > <?php  $_smarty_tpl->tpl_vars['channel'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('channels')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['channel']->key => $_smarty_tpl->tpl_vars['channel']->value){
?><?php if ($_smarty_tpl->getVariable('cid')->value==$_smarty_tpl->tpl_vars['channel']->value['cid']){?><?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
<?php }?><?php }} ?><?php }elseif($_smarty_tpl->getVariable('pageMethod')->value==='collected'){?>我的收藏<?php }else{ ?>影片類表<?php }?> <?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
  成人專區</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($_smarty_tpl->getVariable('info')->value['title']){?>
<meta property="og:title" content="<?php echo $_smarty_tpl->getVariable('info')->value['title'];?>
 <?php if ($_smarty_tpl->getVariable('pageMethod')->value==='tag'){?>tag類表 > <?php echo $_smarty_tpl->getVariable('tagname')->value;?>
<?php }elseif($_smarty_tpl->getVariable('pageMethod')->value==='lists'){?>影片類表 > <?php  $_smarty_tpl->tpl_vars['channel'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('channels')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['channel']->key => $_smarty_tpl->tpl_vars['channel']->value){
?><?php if ($_smarty_tpl->getVariable('cid')->value==$_smarty_tpl->tpl_vars['channel']->value['cid']){?><?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
<?php }?><?php }} ?><?php }elseif($_smarty_tpl->getVariable('pageMethod')->value==='collected'){?>我的收藏<?php }else{ ?>影片類表<?php }?>"/>
<meta property="og:image" content="<?php echo $_smarty_tpl->getVariable('info')->value['picurl'];?>
"/>
<meta property="og:description" content="<?php echo $_smarty_tpl->getVariable('info')->value['description'];?>
"/> 
<?php }?>
<meta name="keywords" content="AV <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('taglists')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
<?php }} ?> <?php if ($_smarty_tpl->getVariable('pageMethod')->value==='tag'){?>tag類表 > <?php echo $_smarty_tpl->getVariable('tagname')->value;?>
<?php }elseif($_smarty_tpl->getVariable('pageMethod')->value==='lists'){?>影片類表 > <?php  $_smarty_tpl->tpl_vars['channel'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('channels')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['channel']->key => $_smarty_tpl->tpl_vars['channel']->value){
?><?php if ($_smarty_tpl->getVariable('cid')->value==$_smarty_tpl->tpl_vars['channel']->value['cid']){?><?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
<?php }?><?php }} ?><?php }elseif($_smarty_tpl->getVariable('pageMethod')->value==='collected'){?>我的收藏<?php }else{ ?>影片類表<?php }?> 成人專區" />
<meta name="description" content="<?php echo $_smarty_tpl->getVariable('info')->value['description'];?>
 AV 成人專區" />
<meta name="generator" content="ck101.com" />
<meta name="author" content="ck101.com" />
<meta name="copyright" content="成人專區" />
<meta name="MSSmartTagsPreventParsing" content="True" />
<meta http-equiv="MSThemeCompatible" content="Yes" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<link rel="stylesheet" type="text/css" href="http://av.ckcdn.com/css/global.css?20130922"/>
<link rel="stylesheet" type="text/css" href="http://av.ckcdn.com/css/style_1/style.css"/>
<?php if ($_smarty_tpl->getVariable('pageMethod')->value==='detail'||$_smarty_tpl->getVariable('pageProg')->value==='pay'||$_smarty_tpl->getVariable('pageMethod')->value==='play'){?>
<link   href="http://av.ckcdn.com/js/ja/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
<?php }?> 
<!--[if IE]>
   <script src="http://av.ckcdn.com/js/html5_ie.js"></script>
<![endif]-->
</head>
<body>
<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"1Nevh1aYY900M9", domain:"ck101.com",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=1Nevh1aYY900M9" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript -->
<script type="text/javascript">

  var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-622529-8']);
    _gaq.push(['_trackPageview']);

  (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
   })();

</script>
<header id="header">
<nav class="navTv" id="globalheader">
  <ul class="globalnav">
    <li class="navVideo"><a href="/" title="成人專區"><span>成人專區</span></a></li>
    <li class="navTv"><a href="/maindex" title="影片列表"><span>影片列表</span></a></li>
    <li class="navArts"><a target="_blank"  href="http://goo.gl/9kprpk" title="成人短片"><span>成人短片</span></a></li>
    <li class="navOverview"><a target="_blank"  href="http://goo.gl/f7sPDP" /title="動漫影音"><span>動漫影音</span></a></li>
    <li class="navAdult"><a target="_blank" href="http://goo.gl/uQkDGP" title="貼圖區"><span>貼圖區</span></a></li>
    <li class="navPay"><a target="_blank"  href="http://goo.gl/XEhOat" title="娛樂中心"><span>娛樂中心</span></a></li>
    <li class="station"><a target="_blank"  href="http://goo.gl/BdO6lY" title="AV情報站"><span>AV情報站</span></a></li>
    <li class="navCK101"><a target="_blank" href="http://goo.gl/MjnEH" title="成人BT"><span>成人BT</span></a></li>
    <li class="support"><a target="_blank" href="http://goo.gl/45qpH" title="支援服務"><span>支援服務</span></a></li>
  </ul>
  <div class="globalsearch">
<script>
function checktext(){
myTextField = document.getElementById('keyword');
if(myTextField.value != '')
    return true;


return false;

}
</script>
    <form id="seacher" action="/search/lists/" method="get" onsubmit="return checktext()" >
      <div>
        <label for="sp-searchtext">
        <input type="text" accesskey="s" class="sp-searchtext" id='keyword' name="keyword" autocomplete="off" value="<?php echo $_smarty_tpl->getVariable('keyWord')->value;?>
">
        <div class="reset"></div>
        <div class="spinner hclasse"></div>
        </label>
      </div>
    </form>
    <div class="sp-magnify">
      <div class="magnify-searchmode"></div>
      <div class="magnify"></div>
    </div>
  </div>
</nav>
<article id="productheader">
  <h1><a href="/maindex" title="成人專區">成人專區</a></h1>
  <ul>
<?php if (0){?>
    <li><a href="/pay"  class="buynows">立即付費</a></li>
<?php }?>
        <?php if ($_smarty_tpl->getVariable('userInfo')->value){?>
        <li><a href="/maindex/offer" title="提供影片">提供影片</a></li>
        <li><a href="/maindex/collected" title="我的收藏">我的收藏</a></li>
        <li><a href="/maindex/logout" title="會員登出">會員登出</a></li>
        <?php }else{ ?>
<li><a href="http://ck101.com/member.php?mod=register.php" title="註冊會員">註冊會員</a></li>
 <li><a href="http://ck101.com/member.php?mod=logging&action=login&goto=<?php echo urlencode($_smarty_tpl->getVariable('nowurl')->value);?>
" title="登入">登入</a></li>
    <?php }?>
    <li><a onclick="_gaq.push(['_trackEvent', 'pay','<?php if ($_smarty_tpl->getVariable('pageMethod')->value=='index'){?>maindex<?php }elseif($_smarty_tpl->getVariable('pageProg')->value=='search'){?>search<?php }else{ ?><?php echo $_smarty_tpl->getVariable('pageMethod')->value;?>
<?php }?>-vipopen']);" href="http://ck101.com/85pay.php?op=info&utm_source=apen&utm_medium=<?php if ($_smarty_tpl->getVariable('pageMethod')->value=='index'){?>maindex<?php }elseif($_smarty_tpl->getVariable('pageProg')->value=='search'){?>search<?php }else{ ?><?php echo $_smarty_tpl->getVariable('pageMethod')->value;?>
<?php }?>&utm_campaign=<?php if ($_smarty_tpl->getVariable('pageMethod')->value=='index'){?>maindex<?php }elseif($_smarty_tpl->getVariable('pageProg')->value=='search'){?>search<?php }else{ ?><?php echo $_smarty_tpl->getVariable('pageMethod')->value;?>
<?php }?>" class="buynows">立即付費</a></li>
  </ul>
</article>
</header>
<?php if ($_smarty_tpl->getVariable('info')->value['ismp4']){?>
<div id="yt-alert-warn">
<div  class="yt-alert-content">
              <div id="browser-upgrade-box">
      <p class="upgrade-message">
        <strong class="nobr1">如果您覺得影片快轉太慢。</strong>
        <span class="nobr">建議您使用以下兩種瀏覽器。</span>
      </p>
      <p class="browser-links">
        <a href="http://www.apple.com/safari/" class="browser-link" onmousedown="sendBrowserUpgradeGen204('safari');">
          <img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="safari-link">
        </a>

        <a href="http://windows.microsoft.com/zh-TW/internet-explorer/downloads/ie-9/worldwide-languages" class="browser-link" onmousedown="sendBrowserUpgradeGen204('ie9');">
          <img src="http://s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="ie8-link">
        </a>
      </p>
    </div>

    </div>
    
      <button type="button" onclick="_hidediv(this.parentNode);setCookie('hideBrowserUpgradeBox');return false;" id="closeIe6">
        关闭
      </button>
  </div>
<?php }?>
<?php if ($_smarty_tpl->getVariable('userInfo')->value){?>
  <?php if ($_smarty_tpl->getVariable('userInfo')->value['isvip']==0){?>
<div class="alerts"><p>您的帳號24小時可免費觀看一部影片，若要無限觀看影片，請按此<a onclick="_gaq.push(['_trackEvent', 'pay','html-vipopen']);" href="/pay">升級VIP會員</a>。<?php if ($_smarty_tpl->getVariable('isWarrning')->value){?>您尚未加入VIP會員，請加入VIP後"再請重新登入.<?php }?></p></div>
  <?php }?>
<?php }else{ ?>
<?php if ($_smarty_tpl->getVariable('pageProg')->value==='pay'){?>
<div class="alerts"><p>您尚未登入.請登入後再觀看影片.</p></div>
<?php }?>
<?php }?>
