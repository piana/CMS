<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:08:33
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\ajax\customfieldsModal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6583555da091581365-25096402%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd492b2eb09ce8f88c32046ecb918892a05bd8399' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\ajax\\customfieldsModal.tpl',
      1 => 1398323024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6583555da091581365-25096402',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pagesDB' => 0,
    'counter' => 0,
    'key' => 0,
    'val' => 0,
    'HOME' => 0,
    'form' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da0917000c0_46050036',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da0917000c0_46050036')) {function content_555da0917000c0_46050036($_smarty_tpl) {?><table class="table table-striped" style="margin-top:-1px; border-bottom: 1px solid #dddddd;">
	<tbody>
	<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['pagesDB']->value->getCustomFieldsArray(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
	<?php if (isset($_smarty_tpl->tpl_vars['counter'])) {$_smarty_tpl->tpl_vars['counter'] = clone $_smarty_tpl->tpl_vars['counter'];
$_smarty_tpl->tpl_vars['counter']->value = $_smarty_tpl->tpl_vars['counter']->value+1; $_smarty_tpl->tpl_vars['counter']->nocache = null; $_smarty_tpl->tpl_vars['counter']->scope = 0;
} else $_smarty_tpl->tpl_vars['counter'] = new Smarty_variable($_smarty_tpl->tpl_vars['counter']->value+1, null, 0);?>
		<tr>
			<td><span class="silver margin-right-small"><?php echo $_smarty_tpl->tpl_vars['counter']->value;?>
</span> <?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</td>
			<td><span class="badge badge-inverse"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</span></td>
			<td class='gray'>{{$page->cf_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
}}</td>
			<td class="align-right"><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/ajax/customfields/deleteField/cf_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
/"><i class="fa fa-times-circle icon-red" style="margin-right:6px;">&nbsp;</i></a></td>
		</tr>		
	<?php } ?>		
	</tbody>
</table>  
<div class="notes-form margin-top">	
	<?php echo $_smarty_tpl->tpl_vars['form']->value->toHtml();?>

</div>
<?php }} ?>
