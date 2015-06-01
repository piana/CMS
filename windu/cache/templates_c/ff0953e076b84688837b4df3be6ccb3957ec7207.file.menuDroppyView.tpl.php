<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:55:12
         compiled from "C:\xampp\htdocs\windu\data\widgets\menuDroppy\menuDroppyView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2325555d9d70a02597-96500995%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ff0953e076b84688837b4df3be6ccb3957ec7207' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\data\\widgets\\menuDroppy\\menuDroppyView.tpl',
      1 => 1432112869,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2325555d9d70a02597-96500995',
  'function' => 
  array (
    'menuDroppyTree' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'params' => 0,
    'request' => 0,
    'data' => 0,
    'pages' => 0,
    'page' => 0,
    'HOME' => 0,
    'activePagesId' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9d70ba83f3_80965131',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9d70ba83f3_80965131')) {function content_555d9d70ba83f3_80965131($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['params']->value['droppyId']=='') {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['droppyId'] = 'droppyOne';?><?php }?>
<?php if ($_smarty_tpl->tpl_vars['params']->value['sort']=='') {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['sort'] = 'position ASC';?><?php }?>
<?php if ($_smarty_tpl->tpl_vars['params']->value['where']=='') {?><?php ob_start();?><?php echo pagesDB::TYPE_NEWS;?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['where'] = "type != ".$_tmp1;?><?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['activePagesId'])) {$_smarty_tpl->tpl_vars['activePagesId'] = clone $_smarty_tpl->tpl_vars['activePagesId'];
$_smarty_tpl->tpl_vars['activePagesId']->value = $_smarty_tpl->tpl_vars['data']->value['pagesDB']->hasActivePagesIdArray($_smarty_tpl->tpl_vars['request']->value->getVariable('urlKey')); $_smarty_tpl->tpl_vars['activePagesId']->nocache = null; $_smarty_tpl->tpl_vars['activePagesId']->scope = 0;
} else $_smarty_tpl->tpl_vars['activePagesId'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['pagesDB']->hasActivePagesIdArray($_smarty_tpl->tpl_vars['request']->value->getVariable('urlKey')), null, 0);?>

<?php if (!function_exists('smarty_template_function_menuDroppyTree')) {
    function smarty_template_function_menuDroppyTree($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['menuDroppyTree']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
	<?php  $_smarty_tpl->tpl_vars['page'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['page']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['page']->key => $_smarty_tpl->tpl_vars['page']->value) {
$_smarty_tpl->tpl_vars['page']->_loop = true;
?>
		<?php if ($_smarty_tpl->tpl_vars['data']->value['pagesDB']->hasChild($_smarty_tpl->tpl_vars['page']->value->id,$_smarty_tpl->tpl_vars['params']->value['where'])) {?>
			<li>
				<a href="<?php if (strlen($_smarty_tpl->tpl_vars['page']->value->content)>3||$_smarty_tpl->tpl_vars['params']->value['hasContent']!=true) {?><?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['page']->value->urlKey;?>
<?php } else { ?>#<?php }?>"  class="<?php if (in_array($_smarty_tpl->tpl_vars['page']->value->id,$_smarty_tpl->tpl_vars['activePagesId']->value)) {?>menuOpen<?php }?> <?php echo $_smarty_tpl->tpl_vars['page']->value->menuCssClass;?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value->name;?>
</a>
				<ul>
				<?php smarty_template_function_menuDroppyTree($_smarty_tpl,array('pages'=>$_smarty_tpl->tpl_vars['data']->value['pagesDB']->getPagesByParent($_smarty_tpl->tpl_vars['page']->value->id,$_smarty_tpl->tpl_vars['params']->value['where'],$_smarty_tpl->tpl_vars['params']->value['sort'],'*',$_smarty_tpl->tpl_vars['params']->value['limit'],null,true)));?>

				</ul>
			</li>
		<?php } else { ?>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['page']->value->urlKey;?>
"  class="<?php if (in_array($_smarty_tpl->tpl_vars['page']->value->id,$_smarty_tpl->tpl_vars['activePagesId']->value)) {?>menuOpen<?php }?> <?php echo $_smarty_tpl->tpl_vars['page']->value->menuCssClass;?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value->name;?>
</a></li>
		<?php }?>
	<?php } ?>
<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;
foreach (Smarty::$global_tpl_vars as $key => $value) if(!isset($_smarty_tpl->tpl_vars[$key])) $_smarty_tpl->tpl_vars[$key] = $value;}}?>


<ul id="droppy" class="<?php echo $_smarty_tpl->tpl_vars['params']->value['droppyId'];?>
">
<?php smarty_template_function_menuDroppyTree($_smarty_tpl,array('pages'=>$_smarty_tpl->tpl_vars['data']->value['pagesDB']->getPages($_smarty_tpl->tpl_vars['params']->value['parent'],$_smarty_tpl->tpl_vars['params']->value['where'],$_smarty_tpl->tpl_vars['params']->value['sort'],'*',$_smarty_tpl->tpl_vars['params']->value['limit'],null,true)));?>

</ul>
<script>
    
    $(document).ready(function(){
        $(function() {
            $('.<?php echo $_smarty_tpl->tpl_vars['params']->value['droppyId'];?>
').droppy({speed: 100});
        });
    });
    
</script>
<?php }} ?>
