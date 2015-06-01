<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:59:33
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\paginator.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21585555d9e752551c8-68205869%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '260c8f359f5de02c0ebb2ad63151d930c452631c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\paginator.tpl',
      1 => 1398323024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21585555d9e752551c8-68205869',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'REQUEST' => 0,
    'page' => 0,
    'elementsCount' => 0,
    'count' => 0,
    'pages' => 0,
    'pageLimit' => 0,
    'pagesStart' => 0,
    'pagesStop' => 0,
    'pageNum' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9e753ace10_45832606',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9e753ace10_45832606')) {function content_555d9e753ace10_45832606($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['page'])) {$_smarty_tpl->tpl_vars['page'] = clone $_smarty_tpl->tpl_vars['page'];
$_smarty_tpl->tpl_vars['page']->value = $_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('p'); $_smarty_tpl->tpl_vars['page']->nocache = null; $_smarty_tpl->tpl_vars['page']->scope = 0;
} else $_smarty_tpl->tpl_vars['page'] = new Smarty_variable($_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('p'), null, 0);?>
<?php if ($_smarty_tpl->tpl_vars['page']->value=='') {?><?php if (isset($_smarty_tpl->tpl_vars['page'])) {$_smarty_tpl->tpl_vars['page'] = clone $_smarty_tpl->tpl_vars['page'];
$_smarty_tpl->tpl_vars['page']->value = 0; $_smarty_tpl->tpl_vars['page']->nocache = null; $_smarty_tpl->tpl_vars['page']->scope = 0;
} else $_smarty_tpl->tpl_vars['page'] = new Smarty_variable(0, null, 0);?><?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['pageLimit'])) {$_smarty_tpl->tpl_vars['pageLimit'] = clone $_smarty_tpl->tpl_vars['pageLimit'];
$_smarty_tpl->tpl_vars['pageLimit']->value = 8; $_smarty_tpl->tpl_vars['pageLimit']->nocache = null; $_smarty_tpl->tpl_vars['pageLimit']->scope = 0;
} else $_smarty_tpl->tpl_vars['pageLimit'] = new Smarty_variable(8, null, 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['pages'])) {$_smarty_tpl->tpl_vars['pages'] = clone $_smarty_tpl->tpl_vars['pages'];
$_smarty_tpl->tpl_vars['pages']->value = $_smarty_tpl->tpl_vars['elementsCount']->value/$_smarty_tpl->tpl_vars['count']->value; $_smarty_tpl->tpl_vars['pages']->nocache = null; $_smarty_tpl->tpl_vars['pages']->scope = 0;
} else $_smarty_tpl->tpl_vars['pages'] = new Smarty_variable($_smarty_tpl->tpl_vars['elementsCount']->value/$_smarty_tpl->tpl_vars['count']->value, null, 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['pages'])) {$_smarty_tpl->tpl_vars['pages'] = clone $_smarty_tpl->tpl_vars['pages'];
$_smarty_tpl->tpl_vars['pages']->value = ceil($_smarty_tpl->tpl_vars['pages']->value); $_smarty_tpl->tpl_vars['pages']->nocache = null; $_smarty_tpl->tpl_vars['pages']->scope = 0;
} else $_smarty_tpl->tpl_vars['pages'] = new Smarty_variable(ceil($_smarty_tpl->tpl_vars['pages']->value), null, 0);?>

<?php if ($_smarty_tpl->tpl_vars['pages']->value>1) {?>
<div class="pagination pagination-centered">
	<ul>
		<li><a href="<?php echo router::selfLink();?>
?p=0">first</a></li>
		<li <?php if ($_smarty_tpl->tpl_vars['page']->value==0) {?>class="disabled"<?php }?>><a href="<?php if ($_smarty_tpl->tpl_vars['page']->value!=0) {?><?php echo router::selfLink();?>
?p=<?php echo $_smarty_tpl->tpl_vars['page']->value-1;?>
<?php } else { ?>#<?php }?>">«</a></li>
		<?php if ($_smarty_tpl->tpl_vars['pages']->value>$_smarty_tpl->tpl_vars['pageLimit']->value) {?>
			<?php if (isset($_smarty_tpl->tpl_vars['pagesStop'])) {$_smarty_tpl->tpl_vars['pagesStop'] = clone $_smarty_tpl->tpl_vars['pagesStop'];
$_smarty_tpl->tpl_vars['pagesStop']->value = $_smarty_tpl->tpl_vars['page']->value+$_smarty_tpl->tpl_vars['pageLimit']->value/2; $_smarty_tpl->tpl_vars['pagesStop']->nocache = null; $_smarty_tpl->tpl_vars['pagesStop']->scope = 0;
} else $_smarty_tpl->tpl_vars['pagesStop'] = new Smarty_variable($_smarty_tpl->tpl_vars['page']->value+$_smarty_tpl->tpl_vars['pageLimit']->value/2, null, 0);?>
			<?php if (isset($_smarty_tpl->tpl_vars['pagesStart'])) {$_smarty_tpl->tpl_vars['pagesStart'] = clone $_smarty_tpl->tpl_vars['pagesStart'];
$_smarty_tpl->tpl_vars['pagesStart']->value = $_smarty_tpl->tpl_vars['page']->value-$_smarty_tpl->tpl_vars['pageLimit']->value/2; $_smarty_tpl->tpl_vars['pagesStart']->nocache = null; $_smarty_tpl->tpl_vars['pagesStart']->scope = 0;
} else $_smarty_tpl->tpl_vars['pagesStart'] = new Smarty_variable($_smarty_tpl->tpl_vars['page']->value-$_smarty_tpl->tpl_vars['pageLimit']->value/2, null, 0);?>
			<?php if ($_smarty_tpl->tpl_vars['pagesStart']->value<1) {?>
				<?php if (isset($_smarty_tpl->tpl_vars['pagesStart'])) {$_smarty_tpl->tpl_vars['pagesStart'] = clone $_smarty_tpl->tpl_vars['pagesStart'];
$_smarty_tpl->tpl_vars['pagesStart']->value = 0; $_smarty_tpl->tpl_vars['pagesStart']->nocache = null; $_smarty_tpl->tpl_vars['pagesStart']->scope = 0;
} else $_smarty_tpl->tpl_vars['pagesStart'] = new Smarty_variable(0, null, 0);?>
				<?php if (isset($_smarty_tpl->tpl_vars['pagesStop'])) {$_smarty_tpl->tpl_vars['pagesStop'] = clone $_smarty_tpl->tpl_vars['pagesStop'];
$_smarty_tpl->tpl_vars['pagesStop']->value = $_smarty_tpl->tpl_vars['pageLimit']->value; $_smarty_tpl->tpl_vars['pagesStop']->nocache = null; $_smarty_tpl->tpl_vars['pagesStop']->scope = 0;
} else $_smarty_tpl->tpl_vars['pagesStop'] = new Smarty_variable($_smarty_tpl->tpl_vars['pageLimit']->value, null, 0);?>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['pagesStop']->value>=$_smarty_tpl->tpl_vars['pages']->value) {?>
				<?php if (isset($_smarty_tpl->tpl_vars['pagesStart'])) {$_smarty_tpl->tpl_vars['pagesStart'] = clone $_smarty_tpl->tpl_vars['pagesStart'];
$_smarty_tpl->tpl_vars['pagesStart']->value = $_smarty_tpl->tpl_vars['pages']->value-$_smarty_tpl->tpl_vars['pageLimit']->value-1; $_smarty_tpl->tpl_vars['pagesStart']->nocache = null; $_smarty_tpl->tpl_vars['pagesStart']->scope = 0;
} else $_smarty_tpl->tpl_vars['pagesStart'] = new Smarty_variable($_smarty_tpl->tpl_vars['pages']->value-$_smarty_tpl->tpl_vars['pageLimit']->value-1, null, 0);?>
				<?php if (isset($_smarty_tpl->tpl_vars['pagesStop'])) {$_smarty_tpl->tpl_vars['pagesStop'] = clone $_smarty_tpl->tpl_vars['pagesStop'];
$_smarty_tpl->tpl_vars['pagesStop']->value = $_smarty_tpl->tpl_vars['pages']->value-1; $_smarty_tpl->tpl_vars['pagesStop']->nocache = null; $_smarty_tpl->tpl_vars['pagesStop']->scope = 0;
} else $_smarty_tpl->tpl_vars['pagesStop'] = new Smarty_variable($_smarty_tpl->tpl_vars['pages']->value-1, null, 0);?>
			<?php }?>			
		<?php } else { ?>
			<?php if (isset($_smarty_tpl->tpl_vars['pagesStart'])) {$_smarty_tpl->tpl_vars['pagesStart'] = clone $_smarty_tpl->tpl_vars['pagesStart'];
$_smarty_tpl->tpl_vars['pagesStart']->value = 0; $_smarty_tpl->tpl_vars['pagesStart']->nocache = null; $_smarty_tpl->tpl_vars['pagesStart']->scope = 0;
} else $_smarty_tpl->tpl_vars['pagesStart'] = new Smarty_variable(0, null, 0);?>
			<?php if (isset($_smarty_tpl->tpl_vars['pagesStop'])) {$_smarty_tpl->tpl_vars['pagesStop'] = clone $_smarty_tpl->tpl_vars['pagesStop'];
$_smarty_tpl->tpl_vars['pagesStop']->value = $_smarty_tpl->tpl_vars['pages']->value; $_smarty_tpl->tpl_vars['pagesStop']->nocache = null; $_smarty_tpl->tpl_vars['pagesStop']->scope = 0;
} else $_smarty_tpl->tpl_vars['pagesStop'] = new Smarty_variable($_smarty_tpl->tpl_vars['pages']->value, null, 0);?>
		<?php }?>

		<?php $_smarty_tpl->tpl_vars['pageNum'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['pageNum']->step = 1;$_smarty_tpl->tpl_vars['pageNum']->total = (int) ceil(($_smarty_tpl->tpl_vars['pageNum']->step > 0 ? $_smarty_tpl->tpl_vars['pagesStop']->value-1+1 - ($_smarty_tpl->tpl_vars['pagesStart']->value) : $_smarty_tpl->tpl_vars['pagesStart']->value-($_smarty_tpl->tpl_vars['pagesStop']->value-1)+1)/abs($_smarty_tpl->tpl_vars['pageNum']->step));
if ($_smarty_tpl->tpl_vars['pageNum']->total > 0) {
for ($_smarty_tpl->tpl_vars['pageNum']->value = $_smarty_tpl->tpl_vars['pagesStart']->value, $_smarty_tpl->tpl_vars['pageNum']->iteration = 1;$_smarty_tpl->tpl_vars['pageNum']->iteration <= $_smarty_tpl->tpl_vars['pageNum']->total;$_smarty_tpl->tpl_vars['pageNum']->value += $_smarty_tpl->tpl_vars['pageNum']->step, $_smarty_tpl->tpl_vars['pageNum']->iteration++) {
$_smarty_tpl->tpl_vars['pageNum']->first = $_smarty_tpl->tpl_vars['pageNum']->iteration == 1;$_smarty_tpl->tpl_vars['pageNum']->last = $_smarty_tpl->tpl_vars['pageNum']->iteration == $_smarty_tpl->tpl_vars['pageNum']->total;?>
			<li <?php if ($_smarty_tpl->tpl_vars['pageNum']->value==$_smarty_tpl->tpl_vars['page']->value) {?>class="active"<?php }?>><a href="<?php echo router::selfLink();?>
?p=<?php echo $_smarty_tpl->tpl_vars['pageNum']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['pageNum']->value;?>
</a></li>
		<?php }} ?>
		<li <?php if ($_smarty_tpl->tpl_vars['page']->value==$_smarty_tpl->tpl_vars['pages']->value-1) {?>class="disabled"<?php }?>><a href="<?php if ($_smarty_tpl->tpl_vars['page']->value!=$_smarty_tpl->tpl_vars['pages']->value-1) {?><?php echo router::selfLink();?>
?p=<?php echo $_smarty_tpl->tpl_vars['page']->value+1;?>
<?php } else { ?>#<?php }?>">»</a></li>
		<li><a href="<?php echo router::selfLink();?>
?p=<?php echo $_smarty_tpl->tpl_vars['pages']->value-1;?>
">last</a></li>
	</ul>
</div>
<?php }?>
<?php }} ?>
