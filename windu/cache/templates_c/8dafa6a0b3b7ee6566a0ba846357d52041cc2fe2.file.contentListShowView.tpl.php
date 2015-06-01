<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:08:02
         compiled from "C:\xampp\htdocs\windu\data\widgets\contentListShow\contentListShowView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6755555da0720a3ef9-38049931%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8dafa6a0b3b7ee6566a0ba846357d52041cc2fe2' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\data\\widgets\\contentListShow\\contentListShowView.tpl',
      1 => 1432112866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6755555da0720a3ef9-38049931',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'params' => 0,
    'where' => 0,
    'sort' => 0,
    'data' => 0,
    'results' => 0,
    'HOME' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da072510d05_02816135',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da072510d05_02816135')) {function content_555da072510d05_02816135($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'C:\\xampp\\htdocs\\windu/app/plugins/html/smarty/plugins\\modifier.truncate.php';
if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><?php if (!isset($_smarty_tpl->tpl_vars['params']->value['imageWidth'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['imageWidth'] = config::get('imgSmallWidth');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['imageHeight'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['imageHeight'] = config::get('imgSmallHeight');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['fit'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['fit'] = config::get('imgFit');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['filter'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['filter'] = config::get('imgFilter');?><?php }?>

<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['count'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['count'] = config::get('contentListCount');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['length'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['length'] = config::get('contentListLength');?><?php }?>

<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['cssUl'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['cssUl'] = 'tagsShowList';?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['cssLi'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['cssLi'] = '';?><?php }?>

<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showDate'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showDate'] = true;?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showAuthor'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showAuthor'] = true;?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showSource'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showSource'] = true;?><?php }?>

<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['limit'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['limit'] = 10;?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['elementtype'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['elementtype'] = 2;?><?php }?>

<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['type'])) {?>
	<?php if (isset($_smarty_tpl->tpl_vars['sort'])) {$_smarty_tpl->tpl_vars['sort'] = clone $_smarty_tpl->tpl_vars['sort'];
$_smarty_tpl->tpl_vars['sort']->value = 'createTime ASC'; $_smarty_tpl->tpl_vars['sort']->nocache = null; $_smarty_tpl->tpl_vars['sort']->scope = 0;
} else $_smarty_tpl->tpl_vars['sort'] = new Smarty_variable('createTime ASC', null, 0);?>
<?php } elseif ($_smarty_tpl->tpl_vars['params']->value['type']=='lastest') {?>
	<?php if (isset($_smarty_tpl->tpl_vars['sort'])) {$_smarty_tpl->tpl_vars['sort'] = clone $_smarty_tpl->tpl_vars['sort'];
$_smarty_tpl->tpl_vars['sort']->value = 'date DESC'; $_smarty_tpl->tpl_vars['sort']->nocache = null; $_smarty_tpl->tpl_vars['sort']->scope = 0;
} else $_smarty_tpl->tpl_vars['sort'] = new Smarty_variable('date DESC', null, 0);?>
<?php } elseif ($_smarty_tpl->tpl_vars['params']->value['type']=='views') {?>
	<?php if (isset($_smarty_tpl->tpl_vars['sort'])) {$_smarty_tpl->tpl_vars['sort'] = clone $_smarty_tpl->tpl_vars['sort'];
$_smarty_tpl->tpl_vars['sort']->value = 'views DESC'; $_smarty_tpl->tpl_vars['sort']->nocache = null; $_smarty_tpl->tpl_vars['sort']->scope = 0;
} else $_smarty_tpl->tpl_vars['sort'] = new Smarty_variable('views DESC', null, 0);?>
<?php } elseif ($_smarty_tpl->tpl_vars['params']->value['type']=='position') {?>
	<?php if (isset($_smarty_tpl->tpl_vars['sort'])) {$_smarty_tpl->tpl_vars['sort'] = clone $_smarty_tpl->tpl_vars['sort'];
$_smarty_tpl->tpl_vars['sort']->value = 'position ASC'; $_smarty_tpl->tpl_vars['sort']->nocache = null; $_smarty_tpl->tpl_vars['sort']->scope = 0;
} else $_smarty_tpl->tpl_vars['sort'] = new Smarty_variable('position ASC', null, 0);?>  
<?php } elseif ($_smarty_tpl->tpl_vars['params']->value['type']=='position-group') {?>
	<?php if (isset($_smarty_tpl->tpl_vars['sort'])) {$_smarty_tpl->tpl_vars['sort'] = clone $_smarty_tpl->tpl_vars['sort'];
$_smarty_tpl->tpl_vars['sort']->value = 'parentId ASC,position ASC'; $_smarty_tpl->tpl_vars['sort']->nocache = null; $_smarty_tpl->tpl_vars['sort']->scope = 0;
} else $_smarty_tpl->tpl_vars['sort'] = new Smarty_variable('parentId ASC,position ASC', null, 0);?>      
<?php } elseif ($_smarty_tpl->tpl_vars['params']->value['type']=='author') {?>
	<?php if (isset($_smarty_tpl->tpl_vars['sort'])) {$_smarty_tpl->tpl_vars['sort'] = clone $_smarty_tpl->tpl_vars['sort'];
$_smarty_tpl->tpl_vars['sort']->value = 'createTime DESC'; $_smarty_tpl->tpl_vars['sort']->nocache = null; $_smarty_tpl->tpl_vars['sort']->scope = 0;
} else $_smarty_tpl->tpl_vars['sort'] = new Smarty_variable('createTime DESC', null, 0);?>
	<?php if (isset($_smarty_tpl->tpl_vars['where'])) {$_smarty_tpl->tpl_vars['where'] = clone $_smarty_tpl->tpl_vars['where'];
$_smarty_tpl->tpl_vars['where']->value = " AND authorId = ".((string)$_smarty_tpl->tpl_vars['params']->value['authorId']); $_smarty_tpl->tpl_vars['where']->nocache = null; $_smarty_tpl->tpl_vars['where']->scope = 0;
} else $_smarty_tpl->tpl_vars['where'] = new Smarty_variable(" AND authorId = ".((string)$_smarty_tpl->tpl_vars['params']->value['authorId']), null, 0);?>	
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['dateNow'])) {$_smarty_tpl->tpl_vars['dateNow'] = clone $_smarty_tpl->tpl_vars['dateNow'];
$_smarty_tpl->tpl_vars['dateNow']->value = generate::sqlDatetime(); $_smarty_tpl->tpl_vars['dateNow']->nocache = null; $_smarty_tpl->tpl_vars['dateNow']->scope = 0;
} else $_smarty_tpl->tpl_vars['dateNow'] = new Smarty_variable(generate::sqlDatetime(), null, 0);?>

<?php if (!empty($_smarty_tpl->tpl_vars['params']->value['bucket'])) {?>
	<?php if (isset($_smarty_tpl->tpl_vars['results'])) {$_smarty_tpl->tpl_vars['results'] = clone $_smarty_tpl->tpl_vars['results'];
$_smarty_tpl->tpl_vars['results']->value = $_smarty_tpl->tpl_vars['data']->value['pagesDB']->getAllBucketPagesSmart($_smarty_tpl->tpl_vars['params']->value['bucket'],"type=".((string)$_smarty_tpl->tpl_vars['params']->value['elementtype'])." ".((string)$_smarty_tpl->tpl_vars['where']->value)." and (date is null or date <= '".((string)$_smarty_tpl->tpl_vars['dateNow']->value)."')",$_smarty_tpl->tpl_vars['sort']->value,'*',$_smarty_tpl->tpl_vars['params']->value['limit']); $_smarty_tpl->tpl_vars['results']->nocache = null; $_smarty_tpl->tpl_vars['results']->scope = 0;
} else $_smarty_tpl->tpl_vars['results'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['pagesDB']->getAllBucketPagesSmart($_smarty_tpl->tpl_vars['params']->value['bucket'],"type=".((string)$_smarty_tpl->tpl_vars['params']->value['elementtype'])." ".((string)$_smarty_tpl->tpl_vars['where']->value)." and (date is null or date <= '".((string)$_smarty_tpl->tpl_vars['dateNow']->value)."')",$_smarty_tpl->tpl_vars['sort']->value,'*',$_smarty_tpl->tpl_vars['params']->value['limit']), null, 0);?>
<?php } else { ?>
	<?php if (isset($_smarty_tpl->tpl_vars['results'])) {$_smarty_tpl->tpl_vars['results'] = clone $_smarty_tpl->tpl_vars['results'];
$_smarty_tpl->tpl_vars['results']->value = $_smarty_tpl->tpl_vars['data']->value['pagesDB']->getAllPagesSmart("type=".((string)$_smarty_tpl->tpl_vars['params']->value['elementtype']).((string)$_smarty_tpl->tpl_vars['where']->value)." and (date is null or date <= '".((string)$_smarty_tpl->tpl_vars['dateNow']->value)."')",$_smarty_tpl->tpl_vars['sort']->value,'*',$_smarty_tpl->tpl_vars['params']->value['limit']); $_smarty_tpl->tpl_vars['results']->nocache = null; $_smarty_tpl->tpl_vars['results']->scope = 0;
} else $_smarty_tpl->tpl_vars['results'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['pagesDB']->getAllPagesSmart("type=".((string)$_smarty_tpl->tpl_vars['params']->value['elementtype']).((string)$_smarty_tpl->tpl_vars['where']->value)." and (date is null or date <= '".((string)$_smarty_tpl->tpl_vars['dateNow']->value)."')",$_smarty_tpl->tpl_vars['sort']->value,'*',$_smarty_tpl->tpl_vars['params']->value['limit']), null, 0);?>
<?php }?>


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
    <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['page']->value->urlKey;?>
">
  	<?php if ($_smarty_tpl->tpl_vars['page']->value->hasImage) {?>
  	
  		<img src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo pagesDB::getMainImageEkey($_smarty_tpl->tpl_vars['page']->value->id);?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['imageWidth'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['imageHeight'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['fit'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['filter'];?>
/" class="pull-left img-margin">
 	
 	<?php }?>
 	<h4><?php echo $_smarty_tpl->tpl_vars['page']->value->name;?>
</h4>
    <?php if ($_smarty_tpl->tpl_vars['params']->value['showAuthor']||$_smarty_tpl->tpl_vars['params']->value['showDate']||$_smarty_tpl->tpl_vars['params']->value['showSource']) {?>
	    <p class="contentLastest-meta">
	    	<?php if ($_smarty_tpl->tpl_vars['params']->value['showSource']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['data']->value['pagesDB']->get($_smarty_tpl->tpl_vars['page']->value->parentId,'urlKey');?>
"><span class="label label-important margin-right"><?php echo $_smarty_tpl->tpl_vars['data']->value['pagesDB']->get($_smarty_tpl->tpl_vars['page']->value->parentId,'name');?>
</span></a><?php }?>
	    	<?php if ($_smarty_tpl->tpl_vars['params']->value['showAuthor']) {?><span class="label label-inverse margin-right"><?php echo $_smarty_tpl->tpl_vars['data']->value['usersDB']->get($_smarty_tpl->tpl_vars['page']->value->authorId,'username');?>
</span><?php }?>
          <?php if ($_smarty_tpl->tpl_vars['params']->value['showDate']) {?><span class="label margin-right"><?php echo $_smarty_tpl->tpl_vars['page']->value->date;?>
</span><?php }?>
		</p>
	<?php }?> 	
 	<?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['page']->value->content),$_smarty_tpl->tpl_vars['params']->value['length']);?>

    </a>
  </li>
<?php } ?>
</ul>
<?php } else { ?>
<div class="pad">
	<?php echo smarty_function_L(array('key'=>"content.list.show.noresults"),$_smarty_tpl);?>

</div>	
<?php }?><?php }} ?>
