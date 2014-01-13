<?php /* Smarty version Smarty-3.0.7, created on 2014-01-09 17:52:15
         compiled from "../app/views/index.html" */ ?>
<?php /*%%SmartyHeaderCode:22194553852ce714fb0c1f7-75978584%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '71095971d2b82ef507ec86765d3140bf6df0bf4c' => 
    array (
      0 => '../app/views/index.html',
      1 => 1389257645,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22194553852ce714fb0c1f7-75978584',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php if ($_smarty_tpl->getVariable('isWarrning')->value&&!$_smarty_tpl->getVariable('userInfo')->value){?>
<div class="alerts"><p>您的IP[ <?php echo $_smarty_tpl->getVariable('ip')->value;?>
 ]已被占用!!!! 請點此<a onclick="_gaq.push(['_trackEvent', 'pay','html-vipopen']);" href="/pay" target="_blank">升級VIP</a>之後,重新登入觀看.&nbsp;&nbsp;&nbsp; (誤將帳號分享給朋友.)</p></div>
<?php }?>
<section class="mainContainer">
<?php $_template = new Smarty_Internal_Template("directory.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
  <section class="focusArea">
    <?php if ($_smarty_tpl->getVariable('pageMethod')->value==='index'&&$_smarty_tpl->getVariable('nowpage')->value<2){?>
    <div class="poster">無與倫比的VIP權限更新，更快，更值得。</div>
    <?php }?>
    <div class="masthead">
      <ul class="breadcrumbs">
        <p>目前位置：</p>

<?php if ($_smarty_tpl->getVariable('pageProg')->value==='maindex'){?>
<?php if ($_smarty_tpl->getVariable('pageMethod')->value==='tag'){?>
        <li><a href="#" title="">tag列表 > <?php echo $_smarty_tpl->getVariable('tagname')->value;?>
</a></li>
<?php }elseif($_smarty_tpl->getVariable('pageMethod')->value==='lists'){?>
        <li><a href="#" title="">影片列表 > <?php  $_smarty_tpl->tpl_vars['channel'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('channels')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['channel']->key => $_smarty_tpl->tpl_vars['channel']->value){
?><?php if ($_smarty_tpl->getVariable('cid')->value==$_smarty_tpl->tpl_vars['channel']->value['cid']){?><?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
<?php }?><?php }} ?></a></li>
<?php }elseif($_smarty_tpl->getVariable('pageMethod')->value==='collected'){?>
        <li><a href="#" title="">我的收藏</a></li>
<?php }else{ ?>
        <li><a href="#" title="">影片列表</a></li>
<?php }?>
<?php }elseif($_smarty_tpl->getVariable('pageProg')->value==='search'){?>
        <li><a href="#" title="">搜尋結果</a></li>
<?php }?>
<?php if ($_smarty_tpl->getVariable('lists')->value){?>
        <li>></li>
        <?php if ($_smarty_tpl->getVariable('order')->value==='new'||$_smarty_tpl->getVariable('order')->value==='0'||!$_smarty_tpl->getVariable('order')->value){?>
        <li class="selected"><a href="#" title="最新上架">最新上架</a></li>
        <?php }elseif($_smarty_tpl->getVariable('order')->value==='hot'){?>
        <li class="selected"><a href="#" title="熱門程度">熱門程度</a></li>
        <?php }elseif($_smarty_tpl->getVariable('order')->value==='scores'){?>
        <li class="selected"><a href="#" title="網友評分">網友評分</a></li>
        <?php }?>
<?php }?>
      </ul>
<?php if ($_smarty_tpl->getVariable('lists')->value){?>
      <ul class="sortList">
        <p>排序方法:</p>
<?php if ($_smarty_tpl->getVariable('pageProg')->value==='maindex'){?>        
<li <?php if ($_smarty_tpl->getVariable('order')->value==='new'||$_smarty_tpl->getVariable('order')->value==='0'||!$_smarty_tpl->getVariable('order')->value){?>class='selected'<?php }?>><a href='<?php if ($_smarty_tpl->getVariable('order')->value==='new'||$_smarty_tpl->getVariable('order')->value==='0'||!$_smarty_tpl->getVariable('order')->value){?>#<?php }else{ ?>/maindex/<?php echo $_smarty_tpl->getVariable('pageMethod')->value;?>
/<?php if ($_smarty_tpl->getVariable('pageMethod')->value==='tag'){?><?php echo urlencode($_smarty_tpl->getVariable('tagname')->value);?>
<?php }?><?php echo $_smarty_tpl->getVariable('cid')->value;?>
/new<?php }?>' title='上架日期'>上架日期</a><span class='pipe'>|</span></li>
        <li <?php if ($_smarty_tpl->getVariable('order')->value==='hot'){?>class='selected'<?php }?>><a href='<?php if ($_smarty_tpl->getVariable('order')->value==='hot'){?>#<?php }else{ ?>/maindex/<?php echo $_smarty_tpl->getVariable('pageMethod')->value;?>
/<?php if ($_smarty_tpl->getVariable('pageMethod')->value==='tag'){?><?php echo urlencode($_smarty_tpl->getVariable('tagname')->value);?>
<?php }?><?php echo $_smarty_tpl->getVariable('cid')->value;?>
/hot<?php }?>' title='熱門程度'>熱門程度</a>
<?php if (0){?>
        <span class='pipe'>|</span></li>
        <li <?php if ($_smarty_tpl->getVariable('order')->value==='scores'){?>class='selected'<?php }?>><a href='<?php if ($_smarty_tpl->getVariable('order')->value==='scores'){?>#<?php }else{ ?>/maindex/<?php echo $_smarty_tpl->getVariable('pageMethod')->value;?>
/<?php if ($_smarty_tpl->getVariable('pageMethod')->value==='tag'){?><?php echo urlencode($_smarty_tpl->getVariable('tagname')->value);?>
/<?php }?><?php echo $_smarty_tpl->getVariable('cid')->value;?>
/scores<?php }?>' title='網友評分'>網友評分</a></li>
<?php }?>
<?php }elseif($_smarty_tpl->getVariable('pageProg')->value==='search'){?>
        <li <?php if ($_smarty_tpl->getVariable('order')->value==='new'||$_smarty_tpl->getVariable('order')->value==='0'||!$_smarty_tpl->getVariable('order')->value){?>class='selected'<?php }?>>
        <a href="<?php if ($_smarty_tpl->getVariable('order')->value==='new'||$_smarty_tpl->getVariable('order')->value==='0'||!$_smarty_tpl->getVariable('order')->value){?>#<?php }else{ ?>/search/lists/<?php echo $_smarty_tpl->getVariable('urlFomat')->value;?>
&order=new<?php }?>" title="上架日期">上架日期</a>
        <span class="pipe">|</span>
        </li>
        <li <?php if ($_smarty_tpl->getVariable('order')->value==='hot'){?>class='selected'<?php }?>><a href="<?php if ($_smarty_tpl->getVariable('order')->value==='hot'){?>#<?php }else{ ?>/search/lists/<?php echo $_smarty_tpl->getVariable('urlFomat')->value;?>
&order=hot<?php }?>" title="熱門程度">熱門程度</a>
        </li>

<?php }?>

      </ul>



<?php }?>
    </div>
    <?php echo $_smarty_tpl->getVariable('PAGESTR')->value;?>

    <div class="imgList">
<?php if ($_smarty_tpl->getVariable('lists')->value){?>
      <ul>
              <?php $_template = new Smarty_Internal_Template("video_lists.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>                                                                                                                          </ul>
<?php }else{ ?>
<div class="searchBox">
<h4>您在尋找什麼嗎？</h4>
<p>很抱歉，無法找到您要找的內容。您可能輸入了錯誤的關鍵字或我們沒有您要的內容。您可以將您的需求回報給我們，謝謝。</p>
</div>
<?php }?>
    </div>
  <?php echo $_smarty_tpl->getVariable('PAGESTR')->value;?>

</section>
</section>
<?php $_template = new Smarty_Internal_Template("footer.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
