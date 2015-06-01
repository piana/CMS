<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:11:08
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\tools.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13507555da12c9979f0-13388908%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd5c7448b28d18a35efa1ec23bae6449d7eba5ce2' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\tools.tpl',
      1 => 1398323024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13507555da12c9979f0-13388908',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'subpage' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da12cc0c908_67357009',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da12cc0c908_67357009')) {function content_555da12cc0c908_67357009($_smarty_tpl) {?><script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div class="tabbable">
	<div class="tab-content">
		<?php if ($_smarty_tpl->tpl_vars['subpage']->value=='help') {?>
	    	<?php echo $_smarty_tpl->getSubTemplate ('common/help.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('ekey'=>lang::read('admin.help.tools')), 0);?>
 
	    <?php } elseif ($_smarty_tpl->tpl_vars['subpage']->value=='tools') {?>		  
	    		<?php echo $_smarty_tpl->getSubTemplate ('common/tools.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
		<?php } elseif ($_smarty_tpl->tpl_vars['subpage']->value=='mailing') {?>	
	    	<?php if (license::hasPro('pro')) {?>
	    		<?php echo $_smarty_tpl->getSubTemplate ('common/pro/mailing.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
	    	<?php } else { ?>
	    		<?php echo $_smarty_tpl->getSubTemplate ('common/goPro.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
	    	<?php }?>
		<?php } elseif ($_smarty_tpl->tpl_vars['subpage']->value=='contacts') {?>	
<?php echo $_smarty_tpl->getSubTemplate ('common/contacts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
	     	
		<?php } elseif ($_smarty_tpl->tpl_vars['subpage']->value=='seo') {?>	
	    	<?php if (license::hasPro()) {?>
	    		<?php echo $_smarty_tpl->getSubTemplate ('common/plus/seo.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	    	<?php } else { ?>
	    		<?php echo $_smarty_tpl->getSubTemplate ('common/goPro.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
	    	<?php }?>
		<?php } elseif ($_smarty_tpl->tpl_vars['subpage']->value=='monitoring') {?>	
	    	<?php if (license::hasPro('')) {?>
	    		<?php echo $_smarty_tpl->getSubTemplate ('common/plus/monitoring.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	    	<?php } else { ?>
	    		<?php echo $_smarty_tpl->getSubTemplate ('common/goPro.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
	    	<?php }?>
	    <?php } elseif ($_smarty_tpl->tpl_vars['subpage']->value=='rss') {?>	
	    	<?php if (license::hasPro('')) {?>
	    		<?php echo $_smarty_tpl->getSubTemplate ('common/plus/rss.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	    	<?php } else { ?>
	    		<?php echo $_smarty_tpl->getSubTemplate ('common/goPro.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
	    	<?php }?>
	    <?php } elseif ($_smarty_tpl->tpl_vars['subpage']->value=='database') {?>	
	    	<?php if (license::hasPro('pro')) {?>
	    		<?php echo $_smarty_tpl->getSubTemplate ('common/pro/database.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	    	<?php } else { ?>
	    		<?php echo $_smarty_tpl->getSubTemplate ('common/goPro.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
	    	<?php }?>
		<?php } elseif ($_smarty_tpl->tpl_vars['subpage']->value=='config') {?>	
			<?php echo $_smarty_tpl->getSubTemplate ('common/config.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('class'=>'tools'), 0);?>

		<?php }?>           	        	        	 
	</div>
</div><?php }} ?>
