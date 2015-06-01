<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:55:11
         compiled from "C:\xampp\htdocs\windu\data\themes\Orange\tpl_views\simple_page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16473555d9d6fb69851-82083917%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4a721f1e7b4d3add1c4df72a4c238acb4cba4ddb' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\data\\themes\\Orange\\tpl_views\\simple_page.tpl',
      1 => 1432115587,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16473555d9d6fb69851-82083917',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9d6fba8061_81403942',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9d6fba8061_81403942')) {function content_555d9d6fba8061_81403942($_smarty_tpl) {?><?php if (!is_callable('smarty_function_W')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.W.php';
?><div class="container relat mdcontainer">
		<?php echo $_smarty_tpl->getSubTemplate ('../tpl_common/top.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>	
		<div class="bckground">
			<div class="container">
				<div class="row simplerow">
					<div class="col-md-4 hidden-xs hidden-sm">
					<?php echo $_smarty_tpl->getSubTemplate ('../tpl_common/left_column.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
			
					</div>
		<div class="col-md-8 gal">
		 	<div class="pad">
		 		<h2><?php echo $_smarty_tpl->tpl_vars['page']->value->name;?>
</h2>
		 			<?php echo smarty_function_W(array('name'=>'navigation','page'=>$_smarty_tpl->tpl_vars['page']->value),$_smarty_tpl);?>

					<?php $_template = new Smarty_Internal_Template('eval:'.$_smarty_tpl->tpl_vars['page']->value->content, $_smarty_tpl->smarty, $_smarty_tpl);echo $_template->fetch(); ?>
			</div>
			</div>
			</div>
		</div>
	</div>
	<?php echo $_smarty_tpl->getSubTemplate ('../tpl_common/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div><?php }} ?>
