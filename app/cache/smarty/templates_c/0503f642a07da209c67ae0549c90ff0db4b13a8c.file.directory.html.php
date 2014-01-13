<?php /* Smarty version Smarty-3.0.7, created on 2014-01-09 17:55:46
         compiled from "../app/views/directory.html" */ ?>
<?php /*%%SmartyHeaderCode:18783023052ce7222be6046-26295919%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0503f642a07da209c67ae0549c90ff0db4b13a8c' => 
    array (
      0 => '../app/views/directory.html',
      1 => 1389261343,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18783023052ce7222be6046-26295919',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<aside id="sidebar">
<?php $_template = new Smarty_Internal_Template("channel.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    <div class="divider"></div>
    <ul class="Tags">
      <h3>熱門標籤</h3>
      <?php  $_smarty_tpl->tpl_vars['Tag'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('hotTags')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['Tag']->key => $_smarty_tpl->tpl_vars['Tag']->value){
?>
      <li><a onclick="_gaq.push(['_trackEvent', 'customhotTags','<?php echo $_smarty_tpl->tpl_vars['Tag']->value['name'];?>
']);" href="<?php echo $_smarty_tpl->tpl_vars['Tag']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['Tag']->value['name'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['Tag']->value['name'];?>
</a></li>
      <?php }} ?>
    </ul>
  </aside>
