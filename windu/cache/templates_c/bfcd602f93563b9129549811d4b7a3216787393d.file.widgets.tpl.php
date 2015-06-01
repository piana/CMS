<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:11:15
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\widgets.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17417555da13340f230-49278817%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bfcd602f93563b9129549811d4b7a3216787393d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\widgets.tpl',
      1 => 1399458802,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17417555da13340f230-49278817',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
    'widgetsToUpdate' => 0,
    'hideWidgetFileForm' => 0,
    'widgetsFromAddonsServer' => 0,
    'widget' => 0,
    'formWidget' => 0,
    'formWidgetFile' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da133509267_18233950',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da133509267_18233950')) {function content_555da133509267_18233950($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><div class="tab-menu-top">
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/widgets/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
	<h3 class="pull-left tab-title"> <?php echo smarty_function_L(array('key'=>"admin.themes.tpl.widgets"),$_smarty_tpl);?>
</h3>
	<?php if (is_array($_smarty_tpl->tpl_vars['widgetsToUpdate']->value)) {?><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/updateAllWidgets/" class="btn btn-warning"><?php echo smarty_function_L(array('key'=>"admin.themes.common.tpl.updateall"),$_smarty_tpl);?>
</a><?php }?>
</div>
<?php if (count($_smarty_tpl->tpl_vars['widgetsToUpdate']->value)>0) {?>
<div class="alert alert-warning">
	<?php echo smarty_function_L(array('key'=>"admin.themes.common.tpl.newupdate"),$_smarty_tpl);?>

</div>
<?php }?>
<div class="row-fluid">
	<div class="span5 box">
		<h5><i class="fa fa-map-marker icon-margin icon-grey"></i> <?php echo smarty_function_L(array('key'=>"admin.themes.common.tpl.widgets"),$_smarty_tpl);?>

		<div class="buttons">
		    <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/updateAllWidgets/" class="btn btn-small btn-warning"><?php echo smarty_function_L(array('key'=>"admin.themes.common.tpl.updateall"),$_smarty_tpl);?>
</a>
			<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/widgets/" class="btn btn-small btn-primary"><?php echo smarty_function_L(array('key'=>"admin.themes.controller.add"),$_smarty_tpl);?>
</a>
		</div></h5>
		<?php echo $_smarty_tpl->getSubTemplate ('common/widget_list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('active'=>1), 0);?>

		<h5><?php echo smarty_function_L(array('key'=>"admin.themes.common.tpl.widgets.deactivated"),$_smarty_tpl);?>
</h5>
		<?php echo $_smarty_tpl->getSubTemplate ('common/widget_list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('active'=>0), 0);?>

	</div>
	<div class="span7">
		<?php if ($_smarty_tpl->tpl_vars['hideWidgetFileForm']->value!=1) {?>
    		<div class="box" style="overflow:hidden;">
    			<h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> <?php echo smarty_function_L(array('key'=>"admin.themes.common.tpl.widgetsnotinst"),$_smarty_tpl);?>
</h5>
    			<table class="table table-striped tablesort">
                    <tbody>
    				<?php  $_smarty_tpl->tpl_vars['widget'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['widget']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgetsFromAddonsServer']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['widget']->key => $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->_loop = true;
?>
        				<?php if (!widgetsDB::widgetExists($_smarty_tpl->tpl_vars['widget']->value['name'])) {?>
                            <tr>
                                <td><?php echo $_smarty_tpl->getSubTemplate ('common/widget_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('themename'=>$_smarty_tpl->tpl_vars['widget']->value['name']), 0);?>
 <?php echo $_smarty_tpl->tpl_vars['widget']->value['name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['widget']->value['description'];?>
</td>
                                <td><span class="badge"><?php echo $_smarty_tpl->tpl_vars['widget']->value['downloads'];?>
</span></td>
                                <td>
                                    <div class="buttons">
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/addWidgetFromAddonsServer/<?php echo $_smarty_tpl->tpl_vars['widget']->value['fileEkey'];?>
/<?php echo $_smarty_tpl->tpl_vars['widget']->value['name'];?>
/"><i class="fa fa-download icon-blue">&nbsp;</i></a>
                                    </div>
                                </td>
                            </tr>
        				<?php }?>
    				<?php } ?>
    				</tbody>
    			</table>
    		</div>
       		<div class="box margin-top">
    			<h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> <?php echo smarty_function_L(array('key'=>"admin.themes.controller.addclean"),$_smarty_tpl);?>
</h5>
    			<?php echo $_smarty_tpl->tpl_vars['formWidget']->value->toHtml();?>

    		</div>
    		<div class="box margin-top">
    			<h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> <?php echo smarty_function_L(array('key'=>"admin.themes.controller.addfromzip"),$_smarty_tpl);?>
</h5>
    			<?php echo $_smarty_tpl->tpl_vars['formWidgetFile']->value->toHtml();?>

    		</div>
		<?php } else { ?>
		<div class="box box-floating">
			<h5><i class="fa fa-pencil icon-margin icon-grey"></i> <?php echo smarty_function_L(array('key'=>"admin.content.tpl.edit"),$_smarty_tpl);?>
</h5>
			<?php echo $_smarty_tpl->tpl_vars['formWidget']->value->toHtml();?>

		</div>
		<?php }?>
	</div>
</div><?php }} ?>
