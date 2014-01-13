<?php /* Smarty version Smarty-3.0.7, created on 2014-01-09 18:04:51
         compiled from "../app/views/video_lists.html" */ ?>
<?php /*%%SmartyHeaderCode:98181206252ce74439bd415-76918879%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9546e8ea6f82f376bfbb5a12ee75ccc38f769d56' => 
    array (
      0 => '../app/views/video_lists.html',
      1 => 1389261214,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '98181206252ce74439bd415-76918879',
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
<li> 
<a href="/maindex/detail/<?php echo $_smarty_tpl->tpl_vars['row']->value['avkey'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['picurl'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
" onError="this.src='/images/global/error.jpg';" /></a>
<h3><a href="/maindex/detail/<?php echo $_smarty_tpl->tpl_vars['row']->value['avkey'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
</a></h3>
<p>上傳帳號：<?php echo substr($_smarty_tpl->tpl_vars['row']->value['username'],5);?>
****</p>
<?php if ($_smarty_tpl->tpl_vars['row']->value['isessence']){?>
<span class="watermark">精選好片</span>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['row']->value['cid']==9){?>
<span class="ismasked">店長推薦</span>
<?php }?>
<?php if ($_smarty_tpl->getVariable('isAdmin')->value){?>
<p><a href="/avadmin/detail/<?php echo $_smarty_tpl->tpl_vars['row']->value['avkey'];?>
" target="_blank">edit</a></p>
<?php }?>
</li>
<?php }} ?>
