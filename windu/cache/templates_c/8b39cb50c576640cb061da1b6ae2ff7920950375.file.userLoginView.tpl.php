<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:55:13
         compiled from "C:\xampp\htdocs\windu\data\widgets\userLogin\userLoginView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11348555d9d71724278-10937287%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b39cb50c576640cb061da1b6ae2ff7920950375' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\data\\widgets\\userLogin\\userLoginView.tpl',
      1 => 1432112877,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11348555d9d71724278-10937287',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'HOME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9d71789b97_48971740',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9d71789b97_48971740')) {function content_555d9d71789b97_48971740($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><?php if (!empty($_smarty_tpl->tpl_vars['data']->value['loggedIn'])) {?>
<div class="pad">
	<?php echo smarty_function_L(array('key'=>"userlogin.tpl.loggedas"),$_smarty_tpl);?>
<br> <strong><?php echo $_smarty_tpl->tpl_vars['data']->value['loggedIn']->email;?>
</strong> <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
do/logout/"><?php echo smarty_function_L(array('key'=>"userlogin.tpl.logout"),$_smarty_tpl);?>
</a><br>
	
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['data']->value['panelPage'];?>
"><?php echo smarty_function_L(array('key'=>"userlogin.tpl.accsettings"),$_smarty_tpl);?>
</a>
</div>	
<?php } else { ?>
	<?php echo $_smarty_tpl->tpl_vars['data']->value['form']->toHtml();?>

<?php }?>

<?php }} ?>
