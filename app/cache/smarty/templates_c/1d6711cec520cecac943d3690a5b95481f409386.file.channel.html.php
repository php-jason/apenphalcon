<?php /* Smarty version Smarty-3.0.7, created on 2014-01-09 18:04:51
         compiled from "../app/views/channel.html" */ ?>
<?php /*%%SmartyHeaderCode:168826286752ce74439728c1-23269987%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d6711cec520cecac943d3690a5b95481f409386' => 
    array (
      0 => '../app/views/channel.html',
      1 => 1389261792,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '168826286752ce74439728c1-23269987',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<ul class="channel">
<?php  $_smarty_tpl->tpl_vars['channel'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('channels')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['channel']->key => $_smarty_tpl->tpl_vars['channel']->value){
?>
      <li <?php if ($_smarty_tpl->getVariable('cid')->value==$_smarty_tpl->tpl_vars['channel']->value['cid']){?>class="selected"<?php }?>><span class="iconList_<?php echo $_smarty_tpl->tpl_vars['channel']->value['cid'];?>
"></span><a onclick="_gaq.push(['_trackEvent', 'channels','<?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
']);" href="<?php if (($_smarty_tpl->getVariable('cid')->value==$_smarty_tpl->tpl_vars['channel']->value['cid']&&$_smarty_tpl->getVariable('pageMethod')->value==='lists')){?>#<?php }else{ ?>/maindex/lists/<?php echo $_smarty_tpl->tpl_vars['channel']->value['cid'];?>
<?php }?>" title="<?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['channel']->value['name'];?>
</a></li>
      <?php }} ?>
</ul>      
