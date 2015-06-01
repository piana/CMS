<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:15:52
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\config.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10686555da248ca1f69-03861375%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '387203a951070d8e0c9e050ac1ea2bfda5e318a3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\config.tpl',
      1 => 1398498526,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10686555da248ca1f69-03861375',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
    'class' => 0,
    'formConfig' => 0,
    'configList' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da248ea9862_17887374',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da248ea9862_17887374')) {function content_555da248ea9862_17887374($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><div class="tab-menu-top">
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
/config/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
	<h3 class="pull-left tab-title"> <?php echo smarty_function_L(array('key'=>"admin.menu.config"),$_smarty_tpl);?>
</h3>
</div>
<div class="row-fluid">
	<?php if (is_object($_smarty_tpl->tpl_vars['formConfig']->value)) {?>
	<div class="span7 box">
		<?php echo $_smarty_tpl->getSubTemplate ('common/config_list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('list'=>$_smarty_tpl->tpl_vars['configList']->value,'class'=>$_smarty_tpl->tpl_vars['class']->value), 0);?>

	</div>
	<div class="span5">
		<div class="box-floating">
			<div class="box">
				<h5><i class="fa fa-pencil icon-margin icon-grey"></i> <?php echo smarty_function_L(array('key'=>"admin.users.tpl.edit"),$_smarty_tpl);?>
</h5>
				<?php echo $_smarty_tpl->tpl_vars['formConfig']->value->toHtml();?>

			</div>
		</div>
	</div>
	<?php } else { ?>
	<div class="span12 box">
		<?php echo $_smarty_tpl->getSubTemplate ('common/config_list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('list'=>$_smarty_tpl->tpl_vars['configList']->value,'class'=>$_smarty_tpl->tpl_vars['class']->value,'extended'=>1), 0);?>

	</div>
	<?php }?>
</div>
<?php }} ?>
