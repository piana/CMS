<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:55:18
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\ajax\imagesModal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21267555d9d7623b631-71081699%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b301d98ce8fdb2b1229f7c337e43b68654edf14' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\ajax\\imagesModal.tpl',
      1 => 1398323024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21267555d9d7623b631-71081699',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'images' => 0,
    'HOME' => 0,
    'img' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9d7642b822_86308003',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9d7642b822_86308003')) {function content_555d9d7642b822_86308003($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('common/images_multiuploader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="images-box-modal">
<?php  $_smarty_tpl->tpl_vars['img'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['img']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['images']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['img']->key => $_smarty_tpl->tpl_vars['img']->value) {
$_smarty_tpl->tpl_vars['img']->_loop = true;
?>
	<div class="image-box-modal">
		<img src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/170/100/smart/" style="width: 100%;"><br>
		<a href="#" class="label" onclick="parent.editorInsertText('<img src=<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/270/180/fit/ alt=\'<?php echo $_smarty_tpl->tpl_vars['img']->value->name;?>
\'>'); parent.$('#imagesModal').modal('hide');" ><i class="fa fa-picture-o  icon-margin"></i>S</a>
		<a href="#" class="label" onclick="parent.editorInsertText('<a href=\'<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/940/626/original/\' target=\'_blank\'><img src=<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/270/180/fit/ alt=\'<?php echo $_smarty_tpl->tpl_vars['img']->value->name;?>
\'></a>'); parent.$('#imagesModal').modal('hide');"><i class="fa fa-search-plus  icon-margin"></i>S</a>

		<a href="#" class="label label-warning" onclick="parent.editorInsertText('<img src=<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/540/360/fit/ alt=\'<?php echo $_smarty_tpl->tpl_vars['img']->value->name;?>
\'>'); parent.$('#imagesModal').modal('hide');"><i class="fa fa-picture-o  icon-margin"></i>M</a>
		<a href="#" class="label label-warning" onclick="parent.editorInsertText('<a href=\'<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/940/626/original/\' target=\'_blank\'><img src=<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/540/360/fit/ alt=\'<?php echo $_smarty_tpl->tpl_vars['img']->value->name;?>
\'></a>'); parent.$('#imagesModal').modal('hide');"><i class="fa fa-search-plus  icon-margin"></i>M</a>
		
		<a href="#" class="label label-important" onclick="parent.editorInsertText('<img src=<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/940/626/fit/ alt=\'<?php echo $_smarty_tpl->tpl_vars['img']->value->name;?>
\'>'); parent.$('#imagesModal').modal('hide');"><i class="fa fa-picture-o  icon-margin"></i>L</a>
		<a href="#" class="label label-important" onclick="parent.editorInsertText('<a href=\'<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/940/626/original/\' target=\'_blank\'><img src=<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/940/626/fit/ alt=\'<?php echo $_smarty_tpl->tpl_vars['img']->value->name;?>
\'></a>'); parent.$('#imagesModal').modal('hide');"><i class="fa fa-search-plus  icon-margin"></i>L</a>
		
		<a href="#" class="label label-inverse" onclick="parent.editorInsertText('<img src=<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/940/626/original/ alt=\'<?php echo $_smarty_tpl->tpl_vars['img']->value->name;?>
\'>'); parent.$('#imagesModal').modal('hide');"><i class="fa fa-picture-o  icon-margin"></i>O</a>

		<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/deleteImage/<?php echo $_smarty_tpl->tpl_vars['img']->value->id;?>
/" class="deleteImage"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
	</div>
<?php } ?>				
</div>
<?php }} ?>
