<?php /* Smarty version Smarty-3.0.7, created on 2014-01-10 17:04:48
         compiled from "../app/views/lists.html" */ ?>
<?php /*%%SmartyHeaderCode:120736987752cfb7b0b3bf12-75191438%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'edd85b9978e2b1ff1aa01463706ba3fdf86a3043' => 
    array (
      0 => '../app/views/lists.html',
      1 => 1389344684,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '120736987752cfb7b0b3bf12-75191438',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('lists')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
<li> <a href="/maindex/detail/<?php echo $_smarty_tpl->tpl_vars['row']->value['avkey'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['picurl'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
" onError="this.src='/images/global/error.jpg';" /></a>
<h4><a href="/maindex/detail/<?php echo $_smarty_tpl->tpl_vars['row']->value['avkey'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
</a></h4>
<p>上傳帳號：<?php echo substr($_smarty_tpl->tpl_vars['row']->value['username'],5);?>
****</p>
<?php if ($_smarty_tpl->tpl_vars['row']->value['isessence']){?>
<span class="watermark">業界最新</span>
<?php }?>
</li>
<?php }} ?>
