<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:16:48
         compiled from "C:\xampp\htdocs\windu\data\themes\Orange\tpl_views\news_page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21407555da280d799d5-21493530%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b1640249c56b11f8d93a75fa8675215cea35dc3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\data\\themes\\Orange\\tpl_views\\news_page.tpl',
      1 => 1432115587,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21407555da280d799d5-21493530',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da280e21979_20188133',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da280e21979_20188133')) {function content_555da280e21979_20188133($_smarty_tpl) {?><?php if (!is_callable('smarty_function_W')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.W.php';
?><div class="container">
<?php echo $_smarty_tpl->getSubTemplate ('../tpl_common/top.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
<div class="bckground">
	<div class="container">
		<div class="row simplerow">
			<div class="col-md-4 hidden-xs hidden-sm">
				<?php echo $_smarty_tpl->getSubTemplate ('../tpl_common/left_column.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</div>
			<div class="col-md-8 newsmd8">
					<h2><?php echo $_smarty_tpl->tpl_vars['page']->value->name;?>
</h2>
					<?php echo smarty_function_W(array('name'=>'navigation','page'=>$_smarty_tpl->tpl_vars['page']->value),$_smarty_tpl);?>

					<?php $_template = new Smarty_Internal_Template('eval:'.$_smarty_tpl->tpl_vars['page']->value->content, $_smarty_tpl->smarty, $_smarty_tpl);echo $_template->fetch(); ?>
			</div>
		</div>
	</div>
</div>	

<?php echo $_smarty_tpl->getSubTemplate ('../tpl_common/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


</div><?php }} ?>
