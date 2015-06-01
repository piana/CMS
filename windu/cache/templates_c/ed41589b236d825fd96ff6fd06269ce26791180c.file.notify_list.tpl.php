<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:18:35
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\notify_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10220555da2eb279836-35263929%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ed41589b236d825fd96ff6fd06269ce26791180c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\notify_list.tpl',
      1 => 1399112326,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10220555da2eb279836-35263929',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'simple' => 0,
    'notifications' => 0,
    'notify' => 0,
    'HOME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da2eb367cf0_59485699',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da2eb367cf0_59485699')) {function content_555da2eb367cf0_59485699($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><?php if (notifyDB::count()>0) {?>
<table class="table table-striped tablesort">
<thead>
	<tr>
		<th><?php echo smarty_function_L(array('key'=>"admin.notify_list.tpl.type"),$_smarty_tpl);?>
</th>
		<th><?php echo smarty_function_L(array('key'=>"admin.notify_list.tpl.notification"),$_smarty_tpl);?>
</th>
		<?php if ($_smarty_tpl->tpl_vars['simple']->value==null) {?><th><?php echo smarty_function_L(array('key'=>"admin.notify_list.tpl.dateofading"),$_smarty_tpl);?>
</th><?php }?>
		<th></th>
	</tr>
</thead>
  <tbody>
  <?php  $_smarty_tpl->tpl_vars['notify'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['notify']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['notifications']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['notify']->key => $_smarty_tpl->tpl_vars['notify']->value) {
$_smarty_tpl->tpl_vars['notify']->_loop = true;
?>
	<tr>
		<td class="align-right">
			<?php if ($_smarty_tpl->tpl_vars['notify']->value->priority==notifyDB::STATUS_LIGHT) {?>
				<span class="badge">info</span>
			<?php } elseif ($_smarty_tpl->tpl_vars['notify']->value->priority==notifyDB::STATUS_INFO) {?>
				<span class="badge badge-info">info</span>
			<?php } elseif ($_smarty_tpl->tpl_vars['notify']->value->priority==notifyDB::STATUS_WORNING) {?>
				<span class="badge badge-warning">warning</span>
			<?php } elseif ($_smarty_tpl->tpl_vars['notify']->value->priority==notifyDB::STATUS_DANGER) {?>
				<span class="badge badge-important">danger</span>
			<?php } elseif ($_smarty_tpl->tpl_vars['notify']->value->priority==notifyDB::STATUS_ERROR) {?>
				<span class="badge badge-inverse">error</span>
			<?php } else { ?>
				<span class="badge"><?php echo $_smarty_tpl->tpl_vars['notify']->value->priority;?>
</span>
			<?php }?>
		</td>
		<td>
			<?php if ($_smarty_tpl->tpl_vars['notify']->value->url!=null) {?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['notify']->value->url;?>
"><?php echo smarty_function_L(array('key'=>$_smarty_tpl->tpl_vars['notify']->value->content),$_smarty_tpl);?>
</a>
			<?php } else { ?>
				<?php echo smarty_function_L(array('key'=>$_smarty_tpl->tpl_vars['notify']->value->content),$_smarty_tpl);?>

			<?php }?>
		</td>
		<?php if ($_smarty_tpl->tpl_vars['simple']->value==null) {?><td><?php echo generate::showDatatime($_smarty_tpl->tpl_vars['notify']->value->insertTime);?>
</td><?php }?>
		<td>
			<div class="buttons" style="width:22px;">
				<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/system/closeNotify/<?php echo $_smarty_tpl->tpl_vars['notify']->value->id;?>
/"><i class="fa fa-check-circle icon-blue">&nbsp;</i></a>
			</div>
		</td>
	</tr>
  <?php } ?>   
  </tbody>
</table>
<?php } else { ?>
	<div class="pad">
		<?php echo smarty_function_L(array('key'=>"admin.system.tpl.noelements"),$_smarty_tpl);?>

	</div>
<?php }?><?php }} ?>
