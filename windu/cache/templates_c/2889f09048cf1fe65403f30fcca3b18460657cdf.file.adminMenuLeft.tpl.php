<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:55:11
         compiled from "C:\xampp\htdocs\windu\app\plugins\front\templates\adminMenuLeft.tpl" */ ?>
<?php /*%%SmartyHeaderCode:29091555d9d6f746dd5-05873847%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2889f09048cf1fe65403f30fcca3b18460657cdf' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\front\\templates\\adminMenuLeft.tpl',
      1 => 1398323024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29091555d9d6f746dd5-05873847',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 1,
    'page' => 1,
    'loggedIn' => 1,
    'bg' => 1,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9d6f892ea3_90541825',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9d6f892ea3_90541825')) {function content_555d9d6f892ea3_90541825($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?>
	<div id="imagesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel"><?php echo smarty_function_L(array('key'=>"admin.menu.left.tpl.image"),$_smarty_tpl);?>
</h3>
		</div>
		<div class="modal-body">
			<iframe src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/ajax/images/modalUploader/<?php echo $_smarty_tpl->tpl_vars['page']->value->id;?>
/"></iframe>
		</div>
	</div>	
	<div id="widgetsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel"><?php echo smarty_function_L(array('key'=>"admin.menu.left.tpl.widget"),$_smarty_tpl);?>
</h3>
		</div>
		<div class="modal-body">
			<iframe src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/ajax/widgets/choseWidget/"></iframe>
		</div>
	</div>	
	<div id="filesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel"><?php echo smarty_function_L(array('key'=>"admin.menu.left.tpl.file"),$_smarty_tpl);?>
</h3>
		</div>
		<div class="modal-body">
			<iframe src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/ajax/files/modalUploader/<?php echo $_smarty_tpl->tpl_vars['page']->value->id;?>
/"></iframe>
		</div>
	</div>	
	<div id="adminMenuLeft-container" style="<?php if (cookie::readCookie('hideLeftMenu')==1) {?>display:none;<?php }?>">
		<iframe src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/frontEditor/show/<?php echo $_smarty_tpl->tpl_vars['page']->value->id;?>
/" style="width: 250px; height:100%; border:0px;"></iframe>
	</div>
	<?php if (isset($_smarty_tpl->tpl_vars['loggedIn'])) {$_smarty_tpl->tpl_vars['loggedIn'] = clone $_smarty_tpl->tpl_vars['loggedIn'];
$_smarty_tpl->tpl_vars['loggedIn']->value = usersDB::getLoggedIn('AdminUser'); $_smarty_tpl->tpl_vars['loggedIn']->nocache = true; $_smarty_tpl->tpl_vars['loggedIn']->scope = 0;
} else $_smarty_tpl->tpl_vars['loggedIn'] = new Smarty_variable(usersDB::getLoggedIn('AdminUser'), true, 0);?>
	<?php if (isset($_smarty_tpl->tpl_vars['bg'])) {$_smarty_tpl->tpl_vars['bg'] = clone $_smarty_tpl->tpl_vars['bg'];
$_smarty_tpl->tpl_vars['bg']->value = config::get("backgroundAdmin".((string)$_smarty_tpl->tpl_vars['loggedIn']->value->id)); $_smarty_tpl->tpl_vars['bg']->nocache = true; $_smarty_tpl->tpl_vars['bg']->scope = 0;
} else $_smarty_tpl->tpl_vars['bg'] = new Smarty_variable(config::get("backgroundAdmin".((string)$_smarty_tpl->tpl_vars['loggedIn']->value->id)), true, 0);?>
	<a href="#" title="Ukryj menu" id="toggleLeftMenuButton" onclick="toggleLeftMenu()" class="hideLeftMenuButton" style="verflow-x:hidden; background-image: url('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/admin/resources/img/<?php if ($_smarty_tpl->tpl_vars['bg']->value!=null) {?><?php echo $_smarty_tpl->tpl_vars['bg']->value;?>
<?php } else { ?>bgcolor2.jpg<?php }?>'); z-index:998; <?php if (cookie::readCookie('hideLeftMenu')=='1') {?>left:0px;<?php }?>"><?php if (cookie::readCookie('hideLeftMenu')==1) {?>›<?php } else { ?>‹<?php }?></a>
	<?php if (cookie::readCookie('hideLeftMenu')==1) {?>
		<script>
			$('body').css( "padding-left" , "0px");
		</script>
	<?php }?>
<?php }} ?>
