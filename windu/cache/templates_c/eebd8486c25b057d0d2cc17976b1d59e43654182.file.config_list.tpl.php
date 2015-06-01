<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:15:52
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\config_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:23071555da248f2e587-04766579%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eebd8486c25b057d0d2cc17976b1d59e43654182' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\config_list.tpl',
      1 => 1398323024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23071555da248f2e587-04766579',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'variable' => 0,
    'REQUEST' => 0,
    'extended' => 0,
    'HOME' => 0,
    'class' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da2490c2f31_18182858',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da2490c2f31_18182858')) {function content_555da2490c2f31_18182858($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><table class="table table-striped tablesort">
<thead>
	<tr>
		<th><?php echo smarty_function_L(array('key'=>"admin.config.tpl.constant"),$_smarty_tpl);?>
</th>
		<th><?php echo smarty_function_L(array('key'=>"admin.config.controller.value"),$_smarty_tpl);?>
</th>
		<th><?php echo smarty_function_L(array('key'=>"admin.config.controller.description"),$_smarty_tpl);?>
</th>
		<th></th>
	</tr>
</thead>
<tbody>
  <?php  $_smarty_tpl->tpl_vars['variable'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['variable']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['variable']->key => $_smarty_tpl->tpl_vars['variable']->value) {
$_smarty_tpl->tpl_vars['variable']->_loop = true;
?>
	<tr <?php if ($_smarty_tpl->tpl_vars['variable']->value->id==$_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('id')) {?>class="active"<?php }?>>
		<td><i class="color-icons icons-pill icon-margin">&nbsp;</i><?php echo $_smarty_tpl->tpl_vars['variable']->value->name;?>
</td>
		<td><span class="badge badge-inverse"><?php echo $_smarty_tpl->tpl_vars['variable']->value->value;?>
</span></td>
		<td><?php if ($_smarty_tpl->tpl_vars['extended']->value!=1) {?><?php echo smarty_function_L(array('key'=>"config.short.description.".((string)$_smarty_tpl->tpl_vars['variable']->value->name)),$_smarty_tpl);?>
<?php } else { ?><?php echo smarty_function_L(array('key'=>"config.long.description.".((string)$_smarty_tpl->tpl_vars['variable']->value->name)),$_smarty_tpl);?>
<?php }?></td>
		<td>
			<div class="buttons buttons-two">
				<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
/config/editConfig/<?php echo $_smarty_tpl->tpl_vars['variable']->value->id;?>
/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
				<?php if ($_smarty_tpl->tpl_vars['extended']->value!=1) {?>
				<a href="#" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo smarty_function_L(array('key'=>$_smarty_tpl->tpl_vars['variable']->value->description),$_smarty_tpl);?>
">	
					<i class="fa fa-question-circle icon-grey">&nbsp;</i>
				</a>
				<?php }?>
			</div>
		</td>
	</tr>
  <?php } ?>   
  </tbody>
</table><?php }} ?>
