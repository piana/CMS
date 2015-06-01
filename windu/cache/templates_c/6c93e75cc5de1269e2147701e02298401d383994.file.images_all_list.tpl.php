<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:59:33
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\images_all_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17590555d9e755c4116-88312560%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6c93e75cc5de1269e2147701e02298401d383994' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\images_all_list.tpl',
      1 => 1398323024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17590555d9e755c4116-88312560',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'extended' => 0,
    'showImagesLimit' => 0,
    'page' => 0,
    'pageCount' => 0,
    'imagesDB' => 0,
    'img' => 0,
    'REQUEST' => 0,
    'HOME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9e757566f5_04136674',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9e757566f5_04136674')) {function content_555d9e757566f5_04136674($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
if (!is_callable('smarty_modifier_truncate')) include 'C:\\xampp\\htdocs\\windu/app/plugins/html/smarty/plugins\\modifier.truncate.php';
?><table class="table table-striped tablesort">
	<thead>
	<tr>
		<th><?php echo smarty_function_L(array('key'=>"admin.images_all_list.tpl.name"),$_smarty_tpl);?>
</th>
		<?php if ($_smarty_tpl->tpl_vars['extended']->value) {?>
			<th><?php echo smarty_function_L(array('key'=>"admin.images_all_list.tpl.type"),$_smarty_tpl);?>
</th>
			<th><?php echo smarty_function_L(array('key'=>"admin.images_all_list.tpl.basket"),$_smarty_tpl);?>
</th>
		<?php }?>
		<th><?php echo smarty_function_L(array('key'=>"admin.images_all_list.tpl.link"),$_smarty_tpl);?>
</th>
		<?php if ($_smarty_tpl->tpl_vars['extended']->value) {?>
			<th class="smallWidthHidden"><?php echo smarty_function_L(array('key'=>"admin.images_all_list.tpl.created"),$_smarty_tpl);?>
</th>
		<?php }?>
		<th>MB</th>
		<?php if ($_smarty_tpl->tpl_vars['extended']->value) {?>
			<th>W</th>
			<th>H</th>
		<?php }?>
		<th></th>
	</tr>
	</thead>
  <tbody> 
  <?php if ($_smarty_tpl->tpl_vars['showImagesLimit']->value=='') {?><?php if (isset($_smarty_tpl->tpl_vars['showImagesLimit'])) {$_smarty_tpl->tpl_vars['showImagesLimit'] = clone $_smarty_tpl->tpl_vars['showImagesLimit'];
$_smarty_tpl->tpl_vars['showImagesLimit']->value = 11; $_smarty_tpl->tpl_vars['showImagesLimit']->nocache = null; $_smarty_tpl->tpl_vars['showImagesLimit']->scope = 0;
} else $_smarty_tpl->tpl_vars['showImagesLimit'] = new Smarty_variable(11, null, 0);?><?php }?>	
  <?php  $_smarty_tpl->tpl_vars['img'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['img']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['imagesDB']->value->fetchAll(null,'updateTime DESC','*',((string)$_smarty_tpl->tpl_vars['page']->value).",".((string)$_smarty_tpl->tpl_vars['pageCount']->value)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['img']->key => $_smarty_tpl->tpl_vars['img']->value) {
$_smarty_tpl->tpl_vars['img']->_loop = true;
?>
	<tr <?php if ($_smarty_tpl->tpl_vars['img']->value->id==$_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('id')) {?>class="active"<?php }?>>
		<td>
			<img style="margin-top:-6px; margin-bottom:-4px;" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/30/22/smart/"  data-toggle="tooltip" data-placement="left" data-original-title="<img style='height:150px; width:200px;' src='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/200/150/smart/'>">
			<?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['img']->value->name,20);?>

		</td>
		<?php if ($_smarty_tpl->tpl_vars['extended']->value) {?>
			<td><span class="badge"><?php echo $_smarty_tpl->tpl_vars['img']->value->type;?>
</span></td>
			<td><?php echo $_smarty_tpl->tpl_vars['img']->value->bucket;?>
</td>
		<?php }?>
		<td><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/<?php echo $_smarty_tpl->tpl_vars['img']->value->width;?>
/<?php echo $_smarty_tpl->tpl_vars['img']->value->height;?>
/original/" target="blank"><?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
</a></td>
		<?php if ($_smarty_tpl->tpl_vars['extended']->value) {?><td class="smallWidthHidden"><?php echo generate::showDatatime($_smarty_tpl->tpl_vars['img']->value->createTime);?>
</td><?php }?>
		<td><?php echo round($_smarty_tpl->tpl_vars['img']->value->size/(1024*1024),4);?>
</td>
		<?php if ($_smarty_tpl->tpl_vars['extended']->value) {?>
			<td><?php echo $_smarty_tpl->tpl_vars['img']->value->width;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['img']->value->height;?>
</td>
		<?php }?>
		<td>
			<div class="buttons">
				<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/images/editImageAll/<?php echo $_smarty_tpl->tpl_vars['img']->value->id;?>
/?=<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
			</div>
		</td>		
	</tr>
  <?php } ?>  
  </tbody>
</table>

  
 <?php }} ?>
