<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:07:54
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\content_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9244555da06a63bd27-62503952%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b3b10a57d69fd7e7df5ef5be7caab82584c6d0fa' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\content_list.tpl',
      1 => 1400609414,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9244555da06a63bd27-62503952',
  'function' => 
  array (
    'treelist' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'creator' => 0,
    'data' => 0,
    'entry' => 0,
    'id' => 0,
    'HOME' => 0,
    'creatorSelect' => 0,
    'sort' => 0,
    'pagesDB' => 0,
    'nowDatetime' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da06a9e1785_96271806',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da06a9e1785_96271806')) {function content_555da06a9e1785_96271806($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['nowDatetime'])) {$_smarty_tpl->tpl_vars['nowDatetime'] = clone $_smarty_tpl->tpl_vars['nowDatetime'];
$_smarty_tpl->tpl_vars['nowDatetime']->value = generate::sqlDatetime(); $_smarty_tpl->tpl_vars['nowDatetime']->nocache = null; $_smarty_tpl->tpl_vars['nowDatetime']->scope = 0;
} else $_smarty_tpl->tpl_vars['nowDatetime'] = new Smarty_variable(generate::sqlDatetime(), null, 0);?>
<?php if ($_smarty_tpl->tpl_vars['creator']->value==1) {?><?php if (isset($_smarty_tpl->tpl_vars['creatorSelect'])) {$_smarty_tpl->tpl_vars['creatorSelect'] = clone $_smarty_tpl->tpl_vars['creatorSelect'];
$_smarty_tpl->tpl_vars['creatorSelect']->value = ' and status != 2'; $_smarty_tpl->tpl_vars['creatorSelect']->nocache = null; $_smarty_tpl->tpl_vars['creatorSelect']->scope = 0;
} else $_smarty_tpl->tpl_vars['creatorSelect'] = new Smarty_variable(' and status != 2', null, 0);?><?php }?>
<?php if (!is_callable('smarty_modifier_truncate')) include 'C:\xampp\htdocs\windu/app/plugins/html/smarty/plugins\modifier.truncate.php';
?><?php if (!function_exists('smarty_template_function_treelist')) {
    function smarty_template_function_treelist($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['treelist']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?> 
  <?php  $_smarty_tpl->tpl_vars['entry'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['entry']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['entry']->key => $_smarty_tpl->tpl_vars['entry']->value) {
$_smarty_tpl->tpl_vars['entry']->_loop = true;
?> 
    <?php if ($_smarty_tpl->tpl_vars['entry']->value->type>=pagesDB::TYPE_LANG_CATALOG) {?>
    	<li id="item-id-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
" class="<?php if ($_smarty_tpl->tpl_vars['entry']->value->type==pagesDB::TYPE_GALLERY||$_smarty_tpl->tpl_vars['entry']->value->type==pagesDB::TYPE_NEWS_GROUP) {?>no-nest<?php }?>">
	    	<div class="<?php if ($_smarty_tpl->tpl_vars['entry']->value->id==$_smarty_tpl->tpl_vars['id']->value) {?>active<?php }?>">
				 <?php echo $_smarty_tpl->getSubTemplate ('common/content_list_icon.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('type'=>$_smarty_tpl->tpl_vars['entry']->value->type,'name'=>$_smarty_tpl->tpl_vars['entry']->value->name), 0);?>

				 <?php if ($_smarty_tpl->tpl_vars['entry']->value->type==pagesDB::TYPE_LANG_CATALOG||$_smarty_tpl->tpl_vars['entry']->value->type==pagesDB::TYPE_CATALOG||$_smarty_tpl->tpl_vars['entry']->value->type==pagesDB::TYPE_NEWS_GROUP) {?>
				 	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/showTreelist/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['entry']->value->name,30);?>
</a>
				 <?php } else { ?>
				 	<?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['entry']->value->name,30);?>

				 <?php }?>
				 <div class="buttons">
					 <?php if ($_smarty_tpl->tpl_vars['entry']->value->type==pagesDB::TYPE_GALLERY) {?>
						<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/gallery/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
					 <?php } elseif ($_smarty_tpl->tpl_vars['entry']->value->type==pagesDB::TYPE_NEWS_GROUP) {?>
						<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/news/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
					 <?php } else { ?>					 
					 	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/add/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
					 <?php }?>		
					 
					 <?php if ($_smarty_tpl->tpl_vars['entry']->value->type==pagesDB::TYPE_URL&&$_smarty_tpl->tpl_vars['entry']->value->lock==0) {?>
					 	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/editUrl/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a> 
					 <?php } elseif ($_smarty_tpl->tpl_vars['entry']->value->lock==0) {?>
					 	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/edit/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a> 
					 <?php } else { ?>
					 	<span><i class="fa fa-pencil icon-grey">&nbsp;</i></span>
					 <?php }?> 
					<?php if (usersDB::isDeveloper()&&$_smarty_tpl->tpl_vars['creator']->value!==1) {?> 		 
						<a class="smallWidthHidden" href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/duplicateItem/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/"><i class="fa fa-random icon-green">&nbsp;</i></a>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['creator']->value!==1) {?> 	
						<span href="#" onclick="loadDoAction('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/toggleHide/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/','#hidden-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
')" id='hidden-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
'><i class="fa fa-eye <?php if ($_smarty_tpl->tpl_vars['entry']->value->status==1) {?>icon-grey<?php } else { ?>icon-red<?php }?>">&nbsp;</i></span>
					<?php }?>
					<?php if (usersDB::isDeveloper()&&$_smarty_tpl->tpl_vars['creator']->value!==1) {?>
						<span class="smallWidthHidden" onclick="loadDoAction('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/toggleLoggedContent/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/','#loggedcontent-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
')" id='loggedcontent-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
'><i class="fa fa-lock <?php if ($_smarty_tpl->tpl_vars['entry']->value->logged==1) {?>icon-red<?php } else { ?>icon-grey<?php }?>">&nbsp;</i></span>
						<span class="smallWidthHidden" onclick="loadDoAction('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/toggleLock/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/','#lock-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
')" id='lock-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
'><i class="fa fa-pencil-square <?php if ($_smarty_tpl->tpl_vars['entry']->value->lock==1) {?>icon-red<?php } else { ?>icon-grey<?php }?>">&nbsp;</i></span>
						<span class="smallWidthHidden" onclick="loadDoAction('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/toggleSearchable/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/','#search-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
')" id='search-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
'><i class="fa fa-search <?php if ($_smarty_tpl->tpl_vars['entry']->value->searchable==0) {?>icon-red<?php } else { ?>icon-grey<?php }?>">&nbsp;</i></span>
					<?php }?>				
					
					<?php if ($_smarty_tpl->tpl_vars['entry']->value->lock==0&&$_smarty_tpl->tpl_vars['entry']->value->id!=config::get('language-admin')) {?>
						<span onclick="loadDoActionDelete('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/delete/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/','#item-id-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
',<?php if (!usersDB::isDeveloper()) {?>1<?php } else { ?>0<?php }?>)"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
					<?php } else { ?><span><i class="fa fa-times-circle icon-grey">&nbsp;</i></span><?php }?>
					<?php if (usersDB::isDeveloper()&&$_smarty_tpl->tpl_vars['creator']->value!==1) {?><p class="badge inline-block smallWidthHidden"><?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
</p><?php }?>
				</div>
			</div>
			<?php if ($_smarty_tpl->tpl_vars['entry']->value->type==pagesDB::TYPE_NEWS_GROUP) {?><?php if (isset($_smarty_tpl->tpl_vars['sort'])) {$_smarty_tpl->tpl_vars['sort'] = clone $_smarty_tpl->tpl_vars['sort'];
$_smarty_tpl->tpl_vars['sort']->value = 'date DESC'; $_smarty_tpl->tpl_vars['sort']->nocache = null; $_smarty_tpl->tpl_vars['sort']->scope = 0;
} else $_smarty_tpl->tpl_vars['sort'] = new Smarty_variable('date DESC', null, 0);?><?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['sort'])) {$_smarty_tpl->tpl_vars['sort'] = clone $_smarty_tpl->tpl_vars['sort'];
$_smarty_tpl->tpl_vars['sort']->value = 'position ASC'; $_smarty_tpl->tpl_vars['sort']->nocache = null; $_smarty_tpl->tpl_vars['sort']->scope = 0;
} else $_smarty_tpl->tpl_vars['sort'] = new Smarty_variable('position ASC', null, 0);?><?php }?>
			<?php if (cookie::readCookie('showAllOn')) {?>
				<ul style="padding-left:20px;"><?php smarty_template_function_treelist($_smarty_tpl,array('data'=>$_smarty_tpl->tpl_vars['pagesDB']->value->getPagesByParent($_smarty_tpl->tpl_vars['entry']->value->id,"status !=0".((string)$_smarty_tpl->tpl_vars['creatorSelect']->value),$_smarty_tpl->tpl_vars['sort']->value)));?>
</ul>
		    <?php } else { ?>
				<?php if ($_smarty_tpl->tpl_vars['pagesDB']->value->checkParentsOpen(unserialize(cookie::readCookie('contentOpenId')),$_smarty_tpl->tpl_vars['entry']->value)) {?>
		    	<ul style="padding-left:20px;"><?php smarty_template_function_treelist($_smarty_tpl,array('data'=>$_smarty_tpl->tpl_vars['pagesDB']->value->getPagesByParent($_smarty_tpl->tpl_vars['entry']->value->id,"status !=0".((string)$_smarty_tpl->tpl_vars['creatorSelect']->value),$_smarty_tpl->tpl_vars['sort']->value)));?>
</ul>
		    	<?php }?>		    	
		    <?php }?>

    	</li>
	<?php } else { ?>
		<li id="item-id-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
" class="no-nest <?php if ($_smarty_tpl->tpl_vars['entry']->value->id==$_smarty_tpl->tpl_vars['id']->value) {?>active<?php }?> <?php if ($_smarty_tpl->tpl_vars['entry']->value->date>=$_smarty_tpl->tpl_vars['nowDatetime']->value) {?>silver<?php }?>">
			<div>
				<?php echo $_smarty_tpl->getSubTemplate ('common/content_list_icon.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('type'=>$_smarty_tpl->tpl_vars['entry']->value->type,'name'=>$_smarty_tpl->tpl_vars['entry']->value->name), 0);?>
<?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['entry']->value->name,30);?>

				<div class="buttons">
					 <?php if ($_smarty_tpl->tpl_vars['entry']->value->type==pagesDB::TYPE_URL&&$_smarty_tpl->tpl_vars['entry']->value->lock==0) {?>
					 	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/editUrl/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a> 
					 <?php } elseif ($_smarty_tpl->tpl_vars['entry']->value->lock==0) {?>
					 	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/edit/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a> 
					 <?php } else { ?>
					 	<span><i class="fa fa-pencil icon-grey">&nbsp;</i></span>
					 <?php }?>
					<?php if (usersDB::isDeveloper()&&$_smarty_tpl->tpl_vars['creator']->value!==1) {?> 		 
						<a class="smallWidthHidden" href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/duplicateItem/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/"><i class="fa fa-random icon-green">&nbsp;</i></a>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['creator']->value!==1) {?>					 
						<span onclick="loadDoAction('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/toggleHide/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/','#hidden-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
')" id='hidden-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
'><i class="fa fa-eye <?php if ($_smarty_tpl->tpl_vars['entry']->value->status==1) {?>icon-grey<?php } else { ?>icon-red<?php }?>">&nbsp;</i></span>
					<?php }?>
					<?php if (usersDB::isDeveloper()&&$_smarty_tpl->tpl_vars['creator']->value!==1) {?>
						<span class="smallWidthHidden" onclick="loadDoAction('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/toggleLoggedContent/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/','#loggedcontent-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
')" id='loggedcontent-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
'><i class="fa fa-lock <?php if ($_smarty_tpl->tpl_vars['entry']->value->logged==1) {?>icon-red<?php } else { ?>icon-grey<?php }?>">&nbsp;</i></span>
						<span class="smallWidthHidden" onclick="loadDoAction('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/toggleLock/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/','#lock-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
')" id='lock-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
'><i class="fa fa-pencil-square <?php if ($_smarty_tpl->tpl_vars['entry']->value->lock==1) {?>icon-red<?php } else { ?>icon-grey<?php }?>">&nbsp;</i></span>
						<span class="smallWidthHidden" onclick="loadDoAction('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/toggleSearchable/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/','#search-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
')" id='search-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
'><i class="fa fa-search <?php if ($_smarty_tpl->tpl_vars['entry']->value->searchable==0) {?>icon-red<?php } else { ?>icon-grey<?php }?>">&nbsp;</i></span>
					<?php }?>					
					<?php if ($_smarty_tpl->tpl_vars['entry']->value->lock==0&&$_smarty_tpl->tpl_vars['creator']->value!==1) {?>
						<span onclick="loadDoActionDelete('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/delete/<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
/','#item-id-<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
',<?php if (!usersDB::isDeveloper()) {?>1<?php } else { ?>0<?php }?>)"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
					<?php } else { ?><span><i class="fa fa-times-circle icon-grey">&nbsp;</i></span><?php }?>
					<?php if (usersDB::isDeveloper()&&$_smarty_tpl->tpl_vars['creator']->value!==1) {?><p class="badge inline-block smallWidthHidden"><?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
</p><?php }?>
				</div>
			</div>
		</li> 
	<?php }?> 
  <?php } ?> 
<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;
foreach (Smarty::$global_tpl_vars as $key => $value) if(!isset($_smarty_tpl->tpl_vars[$key])) $_smarty_tpl->tpl_vars[$key] = $value;}}?>


<ul class="sortable <?php if (cookie::readCookie('sortableOn')) {?>sortable-cursor<?php }?> list-bg" <?php if (cookie::readCookie('sortableOn')) {?>id="sortableTreeList"<?php }?>>
<?php smarty_template_function_treelist($_smarty_tpl,array('data'=>$_smarty_tpl->tpl_vars['pagesDB']->value->getPagesByParent(0,"status !=0".((string)$_smarty_tpl->tpl_vars['creatorSelect']->value))));?>

<?php smarty_template_function_treelist($_smarty_tpl,array('data'=>$_smarty_tpl->tpl_vars['pagesDB']->value->getPagesByParent(-1,"status !=0".((string)$_smarty_tpl->tpl_vars['creatorSelect']->value))));?>

</ul>  <?php }} ?>
