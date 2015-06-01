<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:18:12
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\mainSimple.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5919555da2d417a5c4-63301369%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a68c4e6bf1eef7450208f02572254f503555085f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\mainSimple.tpl',
      1 => 1401293976,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5919555da2d417a5c4-63301369',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
    'resourceVersion' => 0,
    'page' => 1,
  ),
  'has_nocache_code' => true,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da2d422e0f3_24183745',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da2d422e0f3_24183745')) {function content_555da2d422e0f3_24183745($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php if (isset($_smarty_tpl->tpl_vars['resourceVersion'])) {$_smarty_tpl->tpl_vars['resourceVersion'] = clone $_smarty_tpl->tpl_vars['resourceVersion'];
$_smarty_tpl->tpl_vars['resourceVersion']->value = intval(config::get('resourcesVersion')); $_smarty_tpl->tpl_vars['resourceVersion']->nocache = null; $_smarty_tpl->tpl_vars['resourceVersion']->scope = 0;
} else $_smarty_tpl->tpl_vars['resourceVersion'] = new Smarty_variable(intval(config::get('resourcesVersion')), null, 0);?>
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/bootstrap/css/bootstrap.min.css?ver=<?php echo $_smarty_tpl->tpl_vars['resourceVersion']->value;?>
">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/admin/resources/css/bootstrap-extends.css?ver=<?php echo $_smarty_tpl->tpl_vars['resourceVersion']->value;?>
">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/css/font-awesome.min.css?ver=<?php echo $_smarty_tpl->tpl_vars['resourceVersion']->value;?>
">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/admin/resources/css/login.css?ver=<?php echo $_smarty_tpl->tpl_vars['resourceVersion']->value;?>
">

		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/js/jquery.js?ver=<?php echo $_smarty_tpl->tpl_vars['resourceVersion']->value;?>
"></script>
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/js/jquery.validate.js?ver=<?php echo $_smarty_tpl->tpl_vars['resourceVersion']->value;?>
"></script>
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/bootstrap/js/bootstrap.min.js?ver=<?php echo $_smarty_tpl->tpl_vars['resourceVersion']->value;?>
"></script>
		
		<title>Windu - Admin</title>
	</head>
<body>
    <noscript>Your browser does not support JavaScript!</noscript>
    
        <?php echo '/*%%SmartyNocache:5919555da2d417a5c4-63301369%%*/<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars[\'page\']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
/*/%%SmartyNocache:5919555da2d417a5c4-63301369%%*/';?>

    
</body> 
</html><?php }} ?>
