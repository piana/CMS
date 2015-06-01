<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:59:32
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\tabs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21482555d9e74c40182-91334333%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '353c5c03ad9120fab20eaed9e14c5b66e2fc0ee8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\tabs.tpl',
      1 => 1398323024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21482555d9e74c40182-91334333',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pins' => 1,
    'key' => 1,
    'HOME' => 1,
    'pin' => 1,
    'iconName' => 1,
    'pinsIconsArray' => 1,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9e74c8a516_00652706',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9e74c8a516_00652706')) {function content_555d9e74c8a516_00652706($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><?php if ($_smarty_tpl->tpl_vars['pins']->value!='') {?>
	<div id="sidebar-right">
		<ul>
			<?php  $_smarty_tpl->tpl_vars['pin'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pin']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['pins']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pin']->key => $_smarty_tpl->tpl_vars['pin']->value) {
$_smarty_tpl->tpl_vars['pin']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['pin']->key;
?>
				<?php if (isset($_smarty_tpl->tpl_vars['iconName'])) {$_smarty_tpl->tpl_vars['iconName'] = clone $_smarty_tpl->tpl_vars['iconName'];
$_smarty_tpl->tpl_vars['iconName']->value = $_smarty_tpl->tpl_vars['key']->value; $_smarty_tpl->tpl_vars['iconName']->nocache = true; $_smarty_tpl->tpl_vars['iconName']->scope = 0;
} else $_smarty_tpl->tpl_vars['iconName'] = new Smarty_variable($_smarty_tpl->tpl_vars['key']->value, true, 0);?>
				<li data-toggle="tooltip" data-placement="left" data-original-title="<?php echo smarty_function_L(array('key'=>$_smarty_tpl->tpl_vars['key']->value),$_smarty_tpl);?>
">
					<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/showTab/<?php echo base64_encode(str_replace($_smarty_tpl->tpl_vars['HOME']->value,'',$_smarty_tpl->tpl_vars['pin']->value[0]));?>
/<?php echo $_smarty_tpl->tpl_vars['pin']->key;?>
/">
						<i class="color-icons <?php echo $_smarty_tpl->tpl_vars['pinsIconsArray']->value[$_smarty_tpl->tpl_vars['iconName']->value];?>
"></i>
					</a>
				</li>
			<?php } ?>	
			<li data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.templates.common.tabs.cleanpins"),$_smarty_tpl);?>
">
				<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/cleanPins/">
					<i class="fa fa-times-circle "> </i>
				</a>
			</li>				
		</ul>
	</div>
<?php }?><?php }} ?>
