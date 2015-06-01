<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:00:59
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\ajax\imageSelectModal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20261555d9ecbb9bee9-53096353%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '82944c602fd50790885fe2180cd6f1c47b30fdb2' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\ajax\\imageSelectModal.tpl',
      1 => 1398323024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20261555d9ecbb9bee9-53096353',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
    'imgUrl' => 0,
    'imageForm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9ecbc09504_86803939',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9ecbc09504_86803939')) {function content_555d9ecbc09504_86803939($_smarty_tpl) {?><center><img src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['imgUrl']->value;?>
?ver=<?php echo microtime();?>
" style="margin-bottom:50px; margin-top:20px; max-height: 300px"></center>
<?php echo $_smarty_tpl->tpl_vars['imageForm']->value->toHtml();?>
		

<?php }} ?>
