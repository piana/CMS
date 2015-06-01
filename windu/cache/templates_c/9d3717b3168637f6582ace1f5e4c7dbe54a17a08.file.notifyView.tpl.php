<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:55:12
         compiled from "C:\xampp\htdocs\windu\data\widgets\notify\notifyView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1279555d9d70124af4-68688437%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9d3717b3168637f6582ace1f5e4c7dbe54a17a08' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\data\\widgets\\notify\\notifyView.tpl',
      1 => 1432112871,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1279555d9d70124af4-68688437',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9d70167180_33276335',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9d70167180_33276335')) {function content_555d9d70167180_33276335($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><?php if ($_smarty_tpl->tpl_vars['data']->value['notifyMessageNegative']!='') {?>
	<div class="alert alert-error">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<?php echo smarty_function_L(array('key'=>$_smarty_tpl->tpl_vars['data']->value['notifyMessageNegative']),$_smarty_tpl);?>

	</div>
<?php } elseif ($_smarty_tpl->tpl_vars['data']->value['notifyMessagePositive']!='') {?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<?php echo smarty_function_L(array('key'=>$_smarty_tpl->tpl_vars['data']->value['notifyMessagePositive']),$_smarty_tpl);?>

	</div>
<?php }?>
<?php }} ?>
