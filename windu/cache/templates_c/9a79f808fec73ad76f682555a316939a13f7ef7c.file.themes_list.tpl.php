<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:11:22
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\themes_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14618555da13a4f72f3-03730316%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a79f808fec73ad76f682555a316939a13f7ef7c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\themes_list.tpl',
      1 => 1399459474,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14618555da13a4f72f3-03730316',
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
    'data' => 0,
    'tpl' => 0,
    'REQUEST' => 0,
    'theme' => 0,
    'separator' => 0,
    'hiddenKey' => 0,
    'HOME' => 0,
    'hidden' => 0,
    'separatorMain' => 0,
    'dirname' => 0,
    'themes' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da13a810328_89856897',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da13a810328_89856897')) {function content_555da13a810328_89856897($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'C:\xampp\htdocs\windu/app/plugins/html/smarty/plugins\modifier.truncate.php';
?><?php if (!function_exists('smarty_template_function_treelist')) {
    function smarty_template_function_treelist($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['treelist']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?> 
 	<?php  $_smarty_tpl->tpl_vars['tpl'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tpl']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value->subdir; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tpl']->key => $_smarty_tpl->tpl_vars['tpl']->value) {
$_smarty_tpl->tpl_vars['tpl']->_loop = true;
?>
		 	<?php if (is_dir($_smarty_tpl->tpl_vars['tpl']->value->path)) {?>
		 	<tr <?php if (((string)$_smarty_tpl->tpl_vars['tpl']->value->name)==((string)$_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('tpl'))) {?>class="active theme-<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
"<?php } else { ?>class="theme-<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
"<?php }?>>
		 		<?php if (isset($_smarty_tpl->tpl_vars['separatorMain'])) {$_smarty_tpl->tpl_vars['separatorMain'] = clone $_smarty_tpl->tpl_vars['separatorMain'];
$_smarty_tpl->tpl_vars['separatorMain']->value = $_smarty_tpl->tpl_vars['separator']->value; $_smarty_tpl->tpl_vars['separatorMain']->nocache = null; $_smarty_tpl->tpl_vars['separatorMain']->scope = 0;
} else $_smarty_tpl->tpl_vars['separatorMain'] = new Smarty_variable($_smarty_tpl->tpl_vars['separator']->value, null, 0);?>
		 		<?php if (isset($_smarty_tpl->tpl_vars['separator'])) {$_smarty_tpl->tpl_vars['separator'] = clone $_smarty_tpl->tpl_vars['separator'];
$_smarty_tpl->tpl_vars['separator']->value = ((string)$_smarty_tpl->tpl_vars['separator']->value)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; $_smarty_tpl->tpl_vars['separator']->nocache = null; $_smarty_tpl->tpl_vars['separator']->scope = 0;
} else $_smarty_tpl->tpl_vars['separator'] = new Smarty_variable(((string)$_smarty_tpl->tpl_vars['separator']->value)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", null, 0);?>	
		 		<?php if (isset($_smarty_tpl->tpl_vars['hiddenKey'])) {$_smarty_tpl->tpl_vars['hiddenKey'] = clone $_smarty_tpl->tpl_vars['hiddenKey'];
$_smarty_tpl->tpl_vars['hiddenKey']->value = "themes_".((string)$_smarty_tpl->tpl_vars['tpl']->value->name); $_smarty_tpl->tpl_vars['hiddenKey']->nocache = null; $_smarty_tpl->tpl_vars['hiddenKey']->scope = 0;
} else $_smarty_tpl->tpl_vars['hiddenKey'] = new Smarty_variable("themes_".((string)$_smarty_tpl->tpl_vars['tpl']->value->name), null, 0);?>
			    <td><?php echo $_smarty_tpl->tpl_vars['separator']->value;?>

			    	<a href="#" onclick="toggleHidden('<?php echo $_smarty_tpl->tpl_vars['hiddenKey']->value;?>
')">
					    <?php if (preg_match('/tpl_views*/',$_smarty_tpl->tpl_vars['tpl']->value->name)) {?>	
					    	<i class="color-icons icons-folder-horizontal icon-margin"> </i>				    	
						<?php } elseif (preg_match('/tpl_*/',$_smarty_tpl->tpl_vars['tpl']->value->name)) {?>
					    	<i class="color-icons icons-folder-horizontal icon-margin"> </i>
					    <?php } elseif (preg_match('/tpl_views*/',$_smarty_tpl->tpl_vars['tpl']->value->name)) {?>	
					    	<i class="color-icons icons-applications-blue icon-margin"> </i>						    	
					    <?php } elseif (preg_match('/img*/',$_smarty_tpl->tpl_vars['tpl']->value->name)) {?>	
					    	<i class="color-icons icons-blue-folder-horizontal icon-margin"> </i>	
					    <?php } elseif (preg_match('/css*/',$_smarty_tpl->tpl_vars['tpl']->value->name)||preg_match('/less*/',$_smarty_tpl->tpl_vars['tpl']->value->name)) {?>	
					    	<i class="color-icons icons-blue-folder-horizontal icon-margin"> </i>		
					    <?php } elseif (preg_match('/js*/',$_smarty_tpl->tpl_vars['tpl']->value->name)) {?>	
					    	<i class="color-icons icons-blue-folder-horizontal icon-margin"> </i>						    					    	
					    <?php } else { ?>
					    	<i class="color-icons icons-folder-horizontal icon-margin"> </i>	
						<?php }?>  			   			
						<?php echo ltrim(str_replace(array('_','-'),array(' ',' '),$_smarty_tpl->tpl_vars['tpl']->value->name),'tpl_');?>

					</a>
				</td>
			    <td>
				    <div class="buttons">
				      	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/add/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/<?php echo $_smarty_tpl->tpl_vars['tpl']->value->name;?>
/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;
				    </div>
			    </td>
			    <?php if (cookie::readCookie($_smarty_tpl->tpl_vars['hiddenKey']->value)==1) {?><?php if (isset($_smarty_tpl->tpl_vars['hidden'])) {$_smarty_tpl->tpl_vars['hidden'] = clone $_smarty_tpl->tpl_vars['hidden'];
$_smarty_tpl->tpl_vars['hidden']->value = 0; $_smarty_tpl->tpl_vars['hidden']->nocache = null; $_smarty_tpl->tpl_vars['hidden']->scope = 0;
} else $_smarty_tpl->tpl_vars['hidden'] = new Smarty_variable(0, null, 0);?><?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['hidden'])) {$_smarty_tpl->tpl_vars['hidden'] = clone $_smarty_tpl->tpl_vars['hidden'];
$_smarty_tpl->tpl_vars['hidden']->value = 1; $_smarty_tpl->tpl_vars['hidden']->nocache = null; $_smarty_tpl->tpl_vars['hidden']->scope = 0;
} else $_smarty_tpl->tpl_vars['hidden'] = new Smarty_variable(1, null, 0);?><?php }?>
	 			<?php smarty_template_function_treelist($_smarty_tpl,array('data'=>$_smarty_tpl->tpl_vars['tpl']->value,'hidden'=>$_smarty_tpl->tpl_vars['hidden']->value,'hiddenKey'=>$_smarty_tpl->tpl_vars['hiddenKey']->value,'dirname'=>$_smarty_tpl->tpl_vars['tpl']->value->name));?>

	 			<?php if (isset($_smarty_tpl->tpl_vars['separator'])) {$_smarty_tpl->tpl_vars['separator'] = clone $_smarty_tpl->tpl_vars['separator'];
$_smarty_tpl->tpl_vars['separator']->value = ((string)$_smarty_tpl->tpl_vars['separatorMain']->value); $_smarty_tpl->tpl_vars['separator']->nocache = null; $_smarty_tpl->tpl_vars['separator']->scope = 0;
} else $_smarty_tpl->tpl_vars['separator'] = new Smarty_variable(((string)$_smarty_tpl->tpl_vars['separatorMain']->value), null, 0);?>
	 		</tr>
		 	<?php } else { ?>
		 	<tr class="<?php if ($_smarty_tpl->tpl_vars['hidden']->value==true) {?>hidden <?php }?><?php echo $_smarty_tpl->tpl_vars['hiddenKey']->value;?>
<?php if (((string)$_smarty_tpl->tpl_vars['tpl']->value->name)==((string)$_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('tpl'))) {?> active<?php }?> theme-<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
" id="themefile-<?php echo md5(((string)$_smarty_tpl->tpl_vars['theme']->value->name).((string)$_smarty_tpl->tpl_vars['data']->value->name).((string)$_smarty_tpl->tpl_vars['tpl']->value->name));?>
">
			    <td><span<?php if ($_smarty_tpl->tpl_vars['data']->value->name=='img') {?> data-toggle="tooltip" data-placement="right" data-original-title="<img src='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
data/themes/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/<?php echo $_smarty_tpl->tpl_vars['data']->value->name;?>
/<?php echo $_smarty_tpl->tpl_vars['tpl']->value->name;?>
'>"<?php }?>><?php echo $_smarty_tpl->tpl_vars['separator']->value;?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->getSubTemplate ('common/files_list_icon.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('name'=>$_smarty_tpl->tpl_vars['tpl']->value->name), 0);?>
<?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['tpl']->value->name,20,"...",true);?>
</span></td>
			    <td>
				    <div class="buttons">
				      	<?php if ($_smarty_tpl->tpl_vars['data']->value->name!='img') {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/edit/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/<?php echo $_smarty_tpl->tpl_vars['dirname']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['data']->value->name;?>
/<?php echo $_smarty_tpl->tpl_vars['tpl']->value->name;?>
/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
						<?php } else { ?>
						<span>
							<i onclick="togglepopover('<?php echo md5($_smarty_tpl->tpl_vars['tpl']->value->name);?>
');" style="cursor:pointer; " style="cursor:normal; " id="popover-id-<?php echo md5($_smarty_tpl->tpl_vars['tpl']->value->name);?>
" class="fa fa-info-circle icon-grey cl-<?php echo md5($_smarty_tpl->tpl_vars['tpl']->value->name);?>
" rel="popovercontentlist" data-content="{{$TEMPLATE_HOME}}/img/<?php echo $_smarty_tpl->tpl_vars['tpl']->value->name;?>
">&nbsp;</i>
						</span>
						<?php }?>
				      	<?php if (usersDB::isDeveloper()) {?>
				      		<span onclick="loadDoActionDelete('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/delete/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/<?php echo $_smarty_tpl->tpl_vars['data']->value->name;?>
/<?php echo $_smarty_tpl->tpl_vars['tpl']->value->name;?>
/','#themefile-<?php echo md5(((string)$_smarty_tpl->tpl_vars['theme']->value->name).((string)$_smarty_tpl->tpl_vars['data']->value->name).((string)$_smarty_tpl->tpl_vars['tpl']->value->name));?>
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
	<?php  $_smarty_tpl->tpl_vars['theme'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['theme']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['themes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->key => $_smarty_tpl->tpl_vars['theme']->value) {
$_smarty_tpl->tpl_vars['theme']->_loop = true;
?>
    <tr <?php if (((string)$_smarty_tpl->tpl_vars['theme']->value->name)==((string)$_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('theme'))&&$_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('tpl')==null) {?>class="active"<?php }?> id="theme-<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
">
      <td>
      	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/show/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/">
      		<i class="color-icons icons-newspaper icon-margin"> </i>
			<?php echo str_replace(array('_','-'),array(' ',' '),$_smarty_tpl->tpl_vars['theme']->value->name);?>

		</a>
      </td>
      <td>
	    <div class="buttons buttons-five">
	    	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/editTheme/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
	    	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/duplicateTemplate/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/"><i class="fa fa-random icon-green">&nbsp;</i></a>
	    	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/downloadTemplate/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/"><i class="fa fa-download icon-green">&nbsp;</i></a>
			<?php if ($_smarty_tpl->tpl_vars['theme']->value->name==config::get('template')) {?>
				<span><i class="fa fa-eye icon-blue">&nbsp;</i></span>
			<?php } else { ?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/setTempleteActive/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/"><i class="fa fa-eye-slash icon-grey">&nbsp;</i></a>
			<?php }?>	    
	      	<?php if (usersDB::isDeveloper()&&$_smarty_tpl->tpl_vars['theme']->value->name!=config::get('template')) {?>
	      		<span onclick="loadDoActionDelete('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/delete_template/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/','#theme-<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
',0)"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
			<?php } else { ?>
				<span><i class="fa fa-times-circle icon-grey">&nbsp;</i></span>
			<?php }?>
	    </div>
      </td>
    </tr>
		<?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('theme')==$_smarty_tpl->tpl_vars['theme']->value->name) {?>
  			<?php smarty_template_function_treelist($_smarty_tpl,array('data'=>$_smarty_tpl->tpl_vars['theme']->value));?>

		<?php }?>
	<?php } ?>	  	
  </tbody>
</table>


<?php }} ?>
