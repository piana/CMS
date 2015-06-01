<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:25:37
         compiled from "C:\xampp\htdocs\windu\data\widgets\searchShowNormal\searchShowNormalView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:26098555da49130a973-88843153%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1baf0290ba22329092bef1584d1299db8ae3a1b9' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\data\\widgets\\searchShowNormal\\searchShowNormalView.tpl',
      1 => 1432112875,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26098555da49130a973-88843153',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'params' => 0,
    'request' => 0,
    'data' => 0,
    'results' => 0,
    'page' => 0,
    'HOME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da491610125_23930741',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da491610125_23930741')) {function content_555da491610125_23930741($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'C:\\xampp\\htdocs\\windu/app/plugins/html/smarty/plugins\\modifier.truncate.php';
if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><?php if (!isset($_smarty_tpl->tpl_vars['params']->value['imageWidth'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['imageWidth'] = config::get('imgSmallWidth');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['imageHeight'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['imageHeight'] = config::get('imgSmallHeight');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['fit'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['fit'] = config::get('imgFit');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['filter'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['filter'] = config::get('imgFilter');?><?php }?>

<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['cssUl'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['cssUl'] = 'searchList';?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['cssLi'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['cssLi'] = '';?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['length'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['length'] = config::get('contentListLength');?><?php }?>

<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showDate'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showDate'] = true;?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showAuthor'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showAuthor'] = true;?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showSource'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showSource'] = true;?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showMatchCount'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showMatchCount'] = true;?><?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['results'])) {$_smarty_tpl->tpl_vars['results'] = clone $_smarty_tpl->tpl_vars['results'];
$_smarty_tpl->tpl_vars['results']->value = $_smarty_tpl->tpl_vars['data']->value['pagesDB']->fetchSearch(generate::sqlInjesctionStringSecure(urldecode($_smarty_tpl->tpl_vars['request']->value->getVariable('id'))),array('tags','name','content'),null,null,'*',null,null,array()); $_smarty_tpl->tpl_vars['results']->nocache = null; $_smarty_tpl->tpl_vars['results']->scope = 0;
} else $_smarty_tpl->tpl_vars['results'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['pagesDB']->fetchSearch(generate::sqlInjesctionStringSecure(urldecode($_smarty_tpl->tpl_vars['request']->value->getVariable('id'))),array('tags','name','content'),null,null,'*',null,null,array()), null, 0);?>
<?php if (!empty($_smarty_tpl->tpl_vars['results']->value)) {?>
	<ul class="<?php echo $_smarty_tpl->tpl_vars['params']->value['cssUl'];?>
">
	<?php  $_smarty_tpl->tpl_vars['page'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['page']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['results']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['page']->key => $_smarty_tpl->tpl_vars['page']->value) {
$_smarty_tpl->tpl_vars['page']->_loop = true;
?>
	  <li class="<?php echo $_smarty_tpl->tpl_vars['params']->value['cssLi'];?>
">
	  	<?php if ($_smarty_tpl->tpl_vars['page']->value->hasImage) {?>
	  	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['page']->value->urlKey;?>
">
	  		<img src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo pagesDB::getMainImageEkey($_smarty_tpl->tpl_vars['page']->value->id);?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['imageWidth'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['imageHeight'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['fit'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['filter'];?>
/" class="pull-left img-margin">
	 	</a>
	 	<?php }?>
	 	<h4><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['page']->value->urlKey;?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value->name;?>
</a></h4>
	    <?php if ($_smarty_tpl->tpl_vars['params']->value['showAuthor']||$_smarty_tpl->tpl_vars['params']->value['showDate']||$_smarty_tpl->tpl_vars['params']->value['showSource']||$_smarty_tpl->tpl_vars['params']->value['showMatchCount']) {?>
		    <p class="searchShow-meta">
		    	<?php if ($_smarty_tpl->tpl_vars['params']->value['showMatchCount']) {?><span class="label margin-right"><?php echo $_smarty_tpl->tpl_vars['page']->value->searchElementsCount;?>
</span><?php }?>
		    	<?php if ($_smarty_tpl->tpl_vars['params']->value['showSource']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['data']->value['pagesDB']->get($_smarty_tpl->tpl_vars['page']->value->parentId,'urlKey');?>
"><span class="label label-important margin-right"><?php echo $_smarty_tpl->tpl_vars['data']->value['pagesDB']->get($_smarty_tpl->tpl_vars['page']->value->parentId,'name');?>
</span></a><?php }?>
	    		<?php if ($_smarty_tpl->tpl_vars['params']->value['showAuthor']) {?><span class="label margin-right"><?php echo $_smarty_tpl->tpl_vars['data']->value['usersDB']->get($_smarty_tpl->tpl_vars['page']->value->authorId,'username');?>
</span><?php }?>
				<?php if ($_smarty_tpl->tpl_vars['params']->value['showDate']) {?><?php echo $_smarty_tpl->tpl_vars['page']->value->date;?>
<?php }?>
			</p>
		<?php }?> 	
	 	
	 	<?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['page']->value->content),$_smarty_tpl->tpl_vars['params']->value['length']);?>

	  </li>
	<?php } ?>
	</ul>
<?php } else { ?>
<div class="pad">
	<?php echo smarty_function_L(array('key'=>"search.show.noresults"),$_smarty_tpl);?>

</div>	
<?php }?><?php }} ?>
