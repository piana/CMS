<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:11:15
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\themes.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16656555da13331cef1-79800071%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '61b103a2a18957e016b66d7a5c9ef1ddb2b35927' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\themes.tpl',
      1 => 1398323024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16656555da13331cef1-79800071',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'subpage' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da1333a5a90_48843558',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da1333a5a90_48843558')) {function content_555da1333a5a90_48843558($_smarty_tpl) {?><div class="tabbable">
	<div class="tab-content">
		<?php if ($_smarty_tpl->tpl_vars['subpage']->value=='help') {?>
			<?php echo $_smarty_tpl->getSubTemplate ('common/help.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('ekey'=>lang::read('admin.help.users')), 0);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['subpage']->value=='themes') {?>
			<?php echo $_smarty_tpl->getSubTemplate ('common/themes.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['subpage']->value=='widgets') {?>
			<?php echo $_smarty_tpl->getSubTemplate ('common/widgets.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['subpage']->value=='config') {?>
			<?php echo $_smarty_tpl->getSubTemplate ('common/config.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('class'=>'themes'), 0);?>

		<?php }?>
	</div>
</div>

<?php }} ?>
