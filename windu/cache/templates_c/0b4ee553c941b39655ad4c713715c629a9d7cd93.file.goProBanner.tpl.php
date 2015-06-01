<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:11:08
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\goProBanner.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2169555da12cd971e4-27834560%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0b4ee553c941b39655ad4c713715c629a9d7cd93' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\goProBanner.tpl',
      1 => 1398323024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2169555da12cd971e4-27834560',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da12cddd6f9_17262981',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da12cddd6f9_17262981')) {function content_555da12cddd6f9_17262981($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><?php if (!license::hasPro()&&cookie::get('closeGoProBanner')!=1) {?>
	<div class="goProBaner margin-bottom mobileHidden">
		<h1><?php echo smarty_function_L(array('key'=>"admin.templates.common.goprobanner.buypro"),$_smarty_tpl);?>
</h1>
		<h4><?php echo smarty_function_L(array('key'=>"admin.templates.common.goprobanner.gain"),$_smarty_tpl);?>
</h4><br>
		<a href="<?php if (lang::read('lang')=='PL') {?><?php echo license::$buyLicensesLinkPL;?>
<?php } else { ?><?php echo license::$buyLicensesLinkEN;?>
<?php }?>" class="btn btn-inverse btn-large"><?php echo smarty_function_L(array('key'=>"admin.templates.common.goprobanner.gopro"),$_smarty_tpl);?>
</a>
		<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/closeGoProBanner/" class="closeBanner"><i class="fa fa-times-circle"></i></a>
	</div>
<?php }?>
<?php }} ?>
