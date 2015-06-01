<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:11:15
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\widget_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:26126555da133557485-52673994%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c8b0264b6337878bf7472b6c8fe75b707a627ca' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\widget_list.tpl',
      1 => 1399461054,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26126555da133557485-52673994',
  'function' => 
  array (
    'widgettreelist' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'data' => 0,
    'tpl' => 0,
    'REQUEST' => 0,
    'theme' => 0,
    'padding' => 0,
    'hiddenKey' => 0,
    'HOME' => 0,
    'hidden' => 0,
    'subdir' => 0,
    'active' => 0,
    'widgetsOff' => 0,
    'widgets' => 0,
    'widgetsToUpdate' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da1339b8703_69544832',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da1339b8703_69544832')) {function content_555da1339b8703_69544832($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><?php if (!function_exists('smarty_template_function_widgettreelist')) {
    function smarty_template_function_widgettreelist($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['widgettreelist']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?> 
 	<?php  $_smarty_tpl->tpl_vars['tpl'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tpl']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value->subdir; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tpl']->key => $_smarty_tpl->tpl_vars['tpl']->value) {
$_smarty_tpl->tpl_vars['tpl']->_loop = true;
?>
 		<?php if (is_dir($_smarty_tpl->tpl_vars['tpl']->value->path)) {?>
	 		<tr <?php if (((string)$_smarty_tpl->tpl_vars['tpl']->value->name)==((string)$_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('tpl'))) {?>class="active widget-<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
"<?php } else { ?>class="widget-<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
"<?php }?>>
	 			<?php if (isset($_smarty_tpl->tpl_vars['hiddenKey'])) {$_smarty_tpl->tpl_vars['hiddenKey'] = clone $_smarty_tpl->tpl_vars['hiddenKey'];
$_smarty_tpl->tpl_vars['hiddenKey']->value = "widget_".((string)$_smarty_tpl->tpl_vars['tpl']->value->name); $_smarty_tpl->tpl_vars['hiddenKey']->nocache = null; $_smarty_tpl->tpl_vars['hiddenKey']->scope = 0;
} else $_smarty_tpl->tpl_vars['hiddenKey'] = new Smarty_variable("widget_".((string)$_smarty_tpl->tpl_vars['tpl']->value->name), null, 0);?>
			    <td style="padding-left:<?php echo $_smarty_tpl->tpl_vars['padding']->value;?>
px;"><i class="color-icons icons-folder-horizontal-open icon-margin"> </i>
				<a href="#" onclick="toggleHidden('<?php echo $_smarty_tpl->tpl_vars['hiddenKey']->value;?>
')"><?php echo $_smarty_tpl->tpl_vars['tpl']->value->name;?>
</a>
				</td>
			    <td>
				    <div class="buttons">
				      	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/widgets/addWidget/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/<?php echo $_smarty_tpl->tpl_vars['tpl']->value->name;?>
/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
				    </div>
			    </td>
			    <?php if (isset($_smarty_tpl->tpl_vars['padding'])) {$_smarty_tpl->tpl_vars['padding'] = clone $_smarty_tpl->tpl_vars['padding'];
$_smarty_tpl->tpl_vars['padding']->value = $_smarty_tpl->tpl_vars['padding']->value+25; $_smarty_tpl->tpl_vars['padding']->nocache = null; $_smarty_tpl->tpl_vars['padding']->scope = 0;
} else $_smarty_tpl->tpl_vars['padding'] = new Smarty_variable($_smarty_tpl->tpl_vars['padding']->value+25, null, 0);?>
			    <?php if (isset($_smarty_tpl->tpl_vars['subdir'])) {$_smarty_tpl->tpl_vars['subdir'] = clone $_smarty_tpl->tpl_vars['subdir'];
$_smarty_tpl->tpl_vars['subdir']->value = $_smarty_tpl->tpl_vars['tpl']->value->name; $_smarty_tpl->tpl_vars['subdir']->nocache = null; $_smarty_tpl->tpl_vars['subdir']->scope = 0;
} else $_smarty_tpl->tpl_vars['subdir'] = new Smarty_variable($_smarty_tpl->tpl_vars['tpl']->value->name, null, 0);?>
			    
				<?php if (cookie::readCookie($_smarty_tpl->tpl_vars['hiddenKey']->value)==1) {?><?php if (isset($_smarty_tpl->tpl_vars['hidden'])) {$_smarty_tpl->tpl_vars['hidden'] = clone $_smarty_tpl->tpl_vars['hidden'];
$_smarty_tpl->tpl_vars['hidden']->value = 0; $_smarty_tpl->tpl_vars['hidden']->nocache = null; $_smarty_tpl->tpl_vars['hidden']->scope = 0;
} else $_smarty_tpl->tpl_vars['hidden'] = new Smarty_variable(0, null, 0);?><?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['hidden'])) {$_smarty_tpl->tpl_vars['hidden'] = clone $_smarty_tpl->tpl_vars['hidden'];
$_smarty_tpl->tpl_vars['hidden']->value = 1; $_smarty_tpl->tpl_vars['hidden']->nocache = null; $_smarty_tpl->tpl_vars['hidden']->scope = 0;
} else $_smarty_tpl->tpl_vars['hidden'] = new Smarty_variable(1, null, 0);?><?php }?>
			    <?php smarty_template_function_widgettreelist($_smarty_tpl,array('hidden'=>$_smarty_tpl->tpl_vars['hidden']->value,'data'=>$_smarty_tpl->tpl_vars['tpl']->value,'hiddenKey'=>$_smarty_tpl->tpl_vars['hiddenKey']->value,'dirname'=>$_smarty_tpl->tpl_vars['tpl']->value->name));?>

				<?php if (isset($_smarty_tpl->tpl_vars['hiddenKey'])) {$_smarty_tpl->tpl_vars['hiddenKey'] = clone $_smarty_tpl->tpl_vars['hiddenKey'];
$_smarty_tpl->tpl_vars['hiddenKey']->value = ''; $_smarty_tpl->tpl_vars['hiddenKey']->nocache = null; $_smarty_tpl->tpl_vars['hiddenKey']->scope = 0;
} else $_smarty_tpl->tpl_vars['hiddenKey'] = new Smarty_variable('', null, 0);?>
				
			    <?php if (isset($_smarty_tpl->tpl_vars['subdir'])) {$_smarty_tpl->tpl_vars['subdir'] = clone $_smarty_tpl->tpl_vars['subdir'];
$_smarty_tpl->tpl_vars['subdir']->value = ''; $_smarty_tpl->tpl_vars['subdir']->nocache = null; $_smarty_tpl->tpl_vars['subdir']->scope = 0;
} else $_smarty_tpl->tpl_vars['subdir'] = new Smarty_variable('', null, 0);?>
			    <?php if (isset($_smarty_tpl->tpl_vars['padding'])) {$_smarty_tpl->tpl_vars['padding'] = clone $_smarty_tpl->tpl_vars['padding'];
$_smarty_tpl->tpl_vars['padding']->value = 30; $_smarty_tpl->tpl_vars['padding']->nocache = null; $_smarty_tpl->tpl_vars['padding']->scope = 0;
} else $_smarty_tpl->tpl_vars['padding'] = new Smarty_variable(30, null, 0);?>
			    <?php if (isset($_smarty_tpl->tpl_vars['hidden'])) {$_smarty_tpl->tpl_vars['hidden'] = clone $_smarty_tpl->tpl_vars['hidden'];
$_smarty_tpl->tpl_vars['hidden']->value = false; $_smarty_tpl->tpl_vars['hidden']->nocache = null; $_smarty_tpl->tpl_vars['hidden']->scope = 0;
} else $_smarty_tpl->tpl_vars['hidden'] = new Smarty_variable(false, null, 0);?>
		    </tr>
	    <?php }?>
	<?php } ?> 
	
 	<?php  $_smarty_tpl->tpl_vars['tpl'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tpl']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value->subdir; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tpl']->key => $_smarty_tpl->tpl_vars['tpl']->value) {
$_smarty_tpl->tpl_vars['tpl']->_loop = true;
?>
 		<?php if (!is_dir($_smarty_tpl->tpl_vars['tpl']->value->path)) {?>
		 	<tr class="widget-<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
 <?php if ($_smarty_tpl->tpl_vars['hidden']->value==true) {?>hidden <?php }?><?php echo $_smarty_tpl->tpl_vars['hiddenKey']->value;?>
<?php if (((string)$_smarty_tpl->tpl_vars['tpl']->value->name)==((string)$_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('tpl'))) {?> active<?php }?>" id="widgetfile-<?php echo md5(((string)$_smarty_tpl->tpl_vars['theme']->value->name).((string)$_smarty_tpl->tpl_vars['subdir']->value).((string)$_smarty_tpl->tpl_vars['tpl']->value->name));?>
">
			    <td style="padding-left:<?php echo $_smarty_tpl->tpl_vars['padding']->value;?>
px;"><i class="color-icons icons-document-code icon-margin"> </i><?php echo $_smarty_tpl->tpl_vars['tpl']->value->name;?>
</td>
			    <td>
				    <div class="buttons">
				      	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/widgets/editWidget/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/<?php if ($_smarty_tpl->tpl_vars['subdir']->value!='') {?><?php echo $_smarty_tpl->tpl_vars['subdir']->value;?>
/<?php }?><?php echo $_smarty_tpl->tpl_vars['tpl']->value->name;?>
/#widget-<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
				    	<?php if (in_array($_smarty_tpl->tpl_vars['subdir']->value,widgetsDB::$baseWidgetFolders)&&usersDB::isDeveloper()) {?>
							<span onclick="loadDoActionDelete('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/deleteWidgetFile/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/<?php echo $_smarty_tpl->tpl_vars['subdir']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['tpl']->value->name;?>
/','#widgetfile-<?php echo md5(((string)$_smarty_tpl->tpl_vars['theme']->value->name).((string)$_smarty_tpl->tpl_vars['subdir']->value).((string)$_smarty_tpl->tpl_vars['tpl']->value->name));?>
',0)"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
				   		<?php }?>
				    </div>
			    </td>
		    </tr>
	    <?php }?>
	<?php } ?> 	
<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;
foreach (Smarty::$global_tpl_vars as $key => $value) if(!isset($_smarty_tpl->tpl_vars[$key])) $_smarty_tpl->tpl_vars[$key] = $value;}}?>


<table class="table">
  <tbody>
  	<?php if ($_smarty_tpl->tpl_vars['active']->value==0) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['widgets'])) {$_smarty_tpl->tpl_vars['widgets'] = clone $_smarty_tpl->tpl_vars['widgets'];
$_smarty_tpl->tpl_vars['widgets']->value = $_smarty_tpl->tpl_vars['widgetsOff']->value; $_smarty_tpl->tpl_vars['widgets']->nocache = null; $_smarty_tpl->tpl_vars['widgets']->scope = 0;
} else $_smarty_tpl->tpl_vars['widgets'] = new Smarty_variable($_smarty_tpl->tpl_vars['widgetsOff']->value, null, 0);?>
		<?php if (isset($_smarty_tpl->tpl_vars['action'])) {$_smarty_tpl->tpl_vars['action'] = clone $_smarty_tpl->tpl_vars['action'];
$_smarty_tpl->tpl_vars['action']->value = 'activateWidget'; $_smarty_tpl->tpl_vars['action']->nocache = null; $_smarty_tpl->tpl_vars['action']->scope = 0;
} else $_smarty_tpl->tpl_vars['action'] = new Smarty_variable('activateWidget', null, 0);?>
	<?php } else { ?>
		<?php if (isset($_smarty_tpl->tpl_vars['action'])) {$_smarty_tpl->tpl_vars['action'] = clone $_smarty_tpl->tpl_vars['action'];
$_smarty_tpl->tpl_vars['action']->value = 'deactivateWidget'; $_smarty_tpl->tpl_vars['action']->nocache = null; $_smarty_tpl->tpl_vars['action']->scope = 0;
} else $_smarty_tpl->tpl_vars['action'] = new Smarty_variable('deactivateWidget', null, 0);?>
	<?php }?>
	<?php  $_smarty_tpl->tpl_vars['theme'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['theme']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['widgets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->key => $_smarty_tpl->tpl_vars['theme']->value) {
$_smarty_tpl->tpl_vars['theme']->_loop = true;
?>
    <tr id="widget-<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
">
      <td>
      	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/widgets/show/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/#widget-<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
"<?php if ($_smarty_tpl->tpl_vars['widgetsToUpdate']->value[$_smarty_tpl->tpl_vars['theme']->value->name]!='') {?>class="silver"<?php }?>>
			<?php echo $_smarty_tpl->getSubTemplate ('common/widget_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('themename'=>$_smarty_tpl->tpl_vars['theme']->value->name), 0);?>
     	
			<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>

		</a>
      </td>
      <td>
	    <div class="buttons <?php if (usersDB::isDeveloper()) {?> buttons-six <?php } else { ?> buttons-four <?php }?>">
	    	<?php if ($_smarty_tpl->tpl_vars['widgetsToUpdate']->value[$_smarty_tpl->tpl_vars['theme']->value->name]) {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/updateWidget/<?php echo $_smarty_tpl->tpl_vars['widgetsToUpdate']->value[$_smarty_tpl->tpl_vars['theme']->value->name]['fileEkey'];?>
/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/">
                    <?php if (adminThemesDoController::wasWidgetEdited($_smarty_tpl->tpl_vars['theme']->value->name)) {?>
                        <i class="fa fa-arrow-circle-up icon-dark"></i>
                    <?php } else { ?>
                        <i class="fa fa-arrow-circle-up icon-orange"></i>
                    <?php }?>
                </a>
            <?php }?>
	    	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/widgets/editWidgetName/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/#widget-<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
	    	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/duplicateWidget/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/"><i class="fa fa-random icon-green">&nbsp;</i></a>
	    	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/downloadWidget/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/"><i class="fa fa-download icon-green">&nbsp;</i></a>
	    	<?php if (usersDB::isDeveloper()) {?>
	    		<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/"><i class="fa fa-eye <?php if ($_smarty_tpl->tpl_vars['active']->value==0) {?>icon-red<?php } else { ?>icon-blue<?php }?>">&nbsp;</i></a>
	      		<span onclick="loadDoActionDelete('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/delete_widget/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/','#widget-<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
',0)"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
			<?php }?>
	    </div>
      </td>
    </tr>
		<?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('theme')==$_smarty_tpl->tpl_vars['theme']->value->name) {?>
			<?php if (isset($_smarty_tpl->tpl_vars['padding'])) {$_smarty_tpl->tpl_vars['padding'] = clone $_smarty_tpl->tpl_vars['padding'];
$_smarty_tpl->tpl_vars['padding']->value = 30; $_smarty_tpl->tpl_vars['padding']->nocache = null; $_smarty_tpl->tpl_vars['padding']->scope = 0;
} else $_smarty_tpl->tpl_vars['padding'] = new Smarty_variable(30, null, 0);?>
  			<?php smarty_template_function_widgettreelist($_smarty_tpl,array('data'=>$_smarty_tpl->tpl_vars['theme']->value));?>

		<?php }?>
	<?php } ?>
	<?php if (count($_smarty_tpl->tpl_vars['widgets']->value)==0) {?><tr><td><?php echo smarty_function_L(array('key'=>"admin.themes.tpl.noelements"),$_smarty_tpl);?>
</td></tr><?php }?>	  	
  </tbody>
</table>



<?php }} ?>
