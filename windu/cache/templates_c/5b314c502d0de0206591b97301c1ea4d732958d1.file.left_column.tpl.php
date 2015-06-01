<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:55:12
         compiled from "C:\xampp\htdocs\windu\data\themes\Orange\tpl_common\left_column.tpl" */ ?>
<?php /*%%SmartyHeaderCode:29738555d9d70c0dd03-00683725%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b314c502d0de0206591b97301c1ea4d732958d1' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\data\\themes\\Orange\\tpl_common\\left_column.tpl',
      1 => 1432115587,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29738555d9d70c0dd03-00683725',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9d70c34e12_22008485',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9d70c34e12_22008485')) {function content_555d9d70c34e12_22008485($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
if (!is_callable('smarty_function_W')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.W.php';
?><div class="box-silver box pad">
	<h2><?php echo smarty_function_L(array('key'=>"editable.front.search"),$_smarty_tpl);?>
</h2>
		<hr>
		<?php echo smarty_function_W(array('name'=>'search','targetPage'=>476),$_smarty_tpl);?>

</div>
<div class="box-silver box pad userlogin-box margin-top logbox">
	<h2><?php echo smarty_function_L(array('key'=>"editable.front.login"),$_smarty_tpl);?>
</h2>
		<hr>
		<?php echo smarty_function_W(array('name'=>'userLogin','registerPage'=>637,'panelPage'=>639),$_smarty_tpl);?>

</div>
<?php }} ?>
