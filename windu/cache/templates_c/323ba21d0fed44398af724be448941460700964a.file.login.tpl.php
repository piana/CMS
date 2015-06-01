<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:16:21
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13109555da265c5a501-07440023%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '323ba21d0fed44398af724be448941460700964a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\login.tpl',
      1 => 1400626394,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13109555da265c5a501-07440023',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
    'form' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da265c79910_06637457',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da265c79910_06637457')) {function content_555da265c79910_06637457($_smarty_tpl) {?>	<div class="loginbox">
		<img src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/admin/resources/img/logo-login<?php echo license::get();?>
.png">
		<div class="loginbox-white">
		<?php echo $_smarty_tpl->getSubTemplate ('common/alert.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
	
		<?php echo $_smarty_tpl->tpl_vars['form']->value->toHtml();?>

		</div>
		<p class="text-shadow">Windu 3.1 rev. <?php echo config::get('revision');?>
</p>
	</div>
<?php }} ?>
