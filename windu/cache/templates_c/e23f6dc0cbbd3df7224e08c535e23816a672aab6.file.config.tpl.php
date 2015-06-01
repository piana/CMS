<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:12:46
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\config.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5961555da18e0ef1c1-89295539%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e23f6dc0cbbd3df7224e08c535e23816a672aab6' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\config.tpl',
      1 => 1398498526,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5961555da18e0ef1c1-89295539',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'buckets' => 0,
    'subpage' => 0,
    'key' => 0,
    'HOME' => 0,
    'configDB' => 0,
    'bucket' => 0,
    'variable' => 0,
    'REQUEST' => 0,
    'forms' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da18e3546d6_15272090',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da18e3546d6_15272090')) {function content_555da18e3546d6_15272090($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?>  	<div class="tabbable">
	  <div class="tab-content">
		  
	    <?php  $_smarty_tpl->tpl_vars['bucket'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['bucket']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['buckets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['bucket']->key => $_smarty_tpl->tpl_vars['bucket']->value) {
$_smarty_tpl->tpl_vars['bucket']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['bucket']->key;
?>
		    <?php if ($_smarty_tpl->tpl_vars['subpage']->value==$_smarty_tpl->tpl_vars['key']->value) {?>
				<div class="tab-menu-top">				
					<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/config/<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
					<h3 class="pull-left tab-title"> <?php echo smarty_function_L(array('key'=>$_smarty_tpl->tpl_vars['configDB']->value->bucketNames[$_smarty_tpl->tpl_vars['key']->value]),$_smarty_tpl);?>
</h3>
	 				<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/config/<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
/" class="btn btn-small btn-primary"><i class="fa fa-times-circle "></i> <?php echo smarty_function_L(array('key'=>"admin.config.tpl.add"),$_smarty_tpl);?>
</a>
				</div>		    
		    	<div class="row-fluid">
				  <div class= "span6">
				  	<div class="box">
					<table class="table table-striped tablesort">
					<thead>
						<tr>
							<th><?php echo smarty_function_L(array('key'=>"admin.config.tpl.constant"),$_smarty_tpl);?>
</th>
							<th><?php echo smarty_function_L(array('key'=>"admin.config.controller.value"),$_smarty_tpl);?>
</th>
							<th class="smallWidthHidden"><?php echo smarty_function_L(array('key'=>"admin.config.controller.description"),$_smarty_tpl);?>
</th>
							<th></th>
						</tr>
					</thead>				
					<tbody>
					  <?php  $_smarty_tpl->tpl_vars['variable'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['variable']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['bucket']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['variable']->key => $_smarty_tpl->tpl_vars['variable']->value) {
$_smarty_tpl->tpl_vars['variable']->_loop = true;
?>
						<tr <?php if ($_smarty_tpl->tpl_vars['variable']->value->id==$_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('id')) {?>class="active"<?php }?>>
							<td><i class="color-icons icons-pill icon-margin">&nbsp;</i><?php echo $_smarty_tpl->tpl_vars['variable']->value->name;?>
</td>
							<td><span class="badge badge-inverse"><?php echo $_smarty_tpl->tpl_vars['variable']->value->value;?>
</span></td>
							<td class="smallWidthHidden"><?php echo smarty_function_L(array('key'=>"config.short.description.".((string)$_smarty_tpl->tpl_vars['variable']->value->name)),$_smarty_tpl);?>
</td>
							<td>
								<div class="buttons buttons-three" style="min-width: 75px;">
									<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/config/<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
/edit/<?php echo $_smarty_tpl->tpl_vars['variable']->value->id;?>
/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
									<?php if (usersDB::isDeveloper()) {?>
										<?php if ($_smarty_tpl->tpl_vars['variable']->value->nodelete==1) {?>
										
										<?php } else { ?>
										<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/config/delete/<?php echo $_smarty_tpl->tpl_vars['variable']->value->id;?>
/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
										<?php }?>
									<?php }?>
									<a href="#config_tab4" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo smarty_function_L(array('key'=>"config.long.description.".((string)$_smarty_tpl->tpl_vars['variable']->value->name)),$_smarty_tpl);?>
">	
										<i class="fa fa-question-circle icon-grey" >&nbsp;</i>
									</a>								
								</div>
							</td>
						</tr>
					  <?php } ?>   
					  </tbody>
					</table>
		      		</div>
				  </div>
				  <div class="span6">
				  	<?php if ($_smarty_tpl->tpl_vars['key']->value==1) {?><div><?php }?>
				  		<div class="box box-floating">
				  			<h5><i class="fa fa-plus-circle icon-margin icon-grey">&nbsp;</i><?php echo smarty_function_L(array('key'=>"admin.config.tpl.addconstanttoconfig"),$_smarty_tpl);?>
</h5>
				  			<?php echo $_smarty_tpl->tpl_vars['forms']->value[$_smarty_tpl->tpl_vars['key']->value]->toHtml();?>

				  		</div>	
				  	<?php if ($_smarty_tpl->tpl_vars['key']->value==1) {?></div><?php }?>
				  </div>
				</div>	     	
			<?php }?>
	    <?php } ?>	    
	</div><?php }} ?>
