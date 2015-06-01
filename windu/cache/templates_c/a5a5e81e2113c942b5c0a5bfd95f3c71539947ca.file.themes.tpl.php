<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:11:22
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\themes.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3013555da13a0d86f2-64907986%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5a5e81e2113c942b5c0a5bfd95f3c71539947ca' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\themes.tpl',
      1 => 1401187686,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3013555da13a0d86f2-64907986',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
    'hideFileForm' => 0,
    'theme' => 0,
    'formTheme' => 0,
    'formThemeFile' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da13a326501_80836441',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da13a326501_80836441')) {function content_555da13a326501_80836441($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><div class="tab-menu-top">
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
	<h3 class="pull-left tab-title"> <?php echo smarty_function_L(array('key'=>"admin.themes.tpl.graphictemplates"),$_smarty_tpl);?>
</h3>
</div>
<div class="row-fluid">
	<div class="span4 box">
		<h5><i class="fa fa-picture-o icon-margin icon-grey"></i> <?php echo smarty_function_L(array('key'=>"admin.themes.common.tpl.graphicstyles"),$_smarty_tpl);?>
</h5>
		<?php echo $_smarty_tpl->getSubTemplate ('common/widgets_modal.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		<?php echo $_smarty_tpl->getSubTemplate ('common/themes_list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</div>
	<div class="span8">
		<?php if ($_smarty_tpl->tpl_vars['hideFileForm']->value!=1) {?>
            <ul class="nav nav-tabs nav-tabs-top" id="tabModerator" style="margin-top:0px!important;">
                <li class="active">
                    <a href="#tabModerator1"><i class="color-icons icons-clipboard-list icon-margin"></i><?php echo smarty_function_L(array('key'=>"creator.tpl.webst"),$_smarty_tpl);?>
</a>
                </li>
                <li class="">
                    <a href="#tabModerator2"><i class="color-icons icons-calendar-list icon-margin"></i><?php echo smarty_function_L(array('key'=>"creator.tpl.blog"),$_smarty_tpl);?>
</a>
                </li>
                <li class="">
                    <a href="#tabModerator3"><i class="color-icons icons-chart-up icon-margin"></i><?php echo smarty_function_L(array('key'=>"creator.tpl.portal"),$_smarty_tpl);?>
</a>
                </li>
                <li class="">
                    <a href="#tabModerator4"><i class="color-icons icons-balloon-white-left icon-margin"></i><?php echo smarty_function_L(array('key'=>"creator.tpl.forum"),$_smarty_tpl);?>
</a>
                </li> 
                <li class="">
                    <a href="#tabModerator5"><i class="color-icons icons-newspaper icon-margin"> </i><?php echo smarty_function_L(array('key'=>"admin.themes.controller.addtemp"),$_smarty_tpl);?>
</a>
                </li>                               
            </ul>		    
            <div class="tab-content tab-moderator box no-padding">
                <div class="tab-pane active" id="tabModerator1">
                    <?php  $_smarty_tpl->tpl_vars['theme'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['theme']->_loop = false;
 $_from = themesDB::getThemesFromAddonsServer('web'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->key => $_smarty_tpl->tpl_vars['theme']->value) {
$_smarty_tpl->tpl_vars['theme']->_loop = true;
?>
                        <?php if (!themesDB::themeExists($_smarty_tpl->tpl_vars['theme']->value['name'])) {?>
                        <div class="addonsBox">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/addThemeFromAddonsServer/<?php echo $_smarty_tpl->tpl_vars['theme']->value['fileEkey'];?>
/<?php echo $_smarty_tpl->tpl_vars['theme']->value['name'];?>
/"> <?php if ($_smarty_tpl->tpl_vars['theme']->value['imageUrl']!='0'||$_smarty_tpl->tpl_vars['theme']->value['imageUrl']!='') {?> <img src="<?php echo $_smarty_tpl->tpl_vars['theme']->value['imageUrl'];?>
"> <?php } else { ?> <img src="<?php echo @constant('ADDONS_SERVER');?>
image/<?php echo $_smarty_tpl->tpl_vars['theme']->value['imageEkey'];?>
/150/150/smart/original/90/"> <?php }?> 
                                <div class="buttons">
                                    <span class="badge badge-inverse"><?php echo str_replace(array('_','-'),array(' ',' '),$_smarty_tpl->tpl_vars['theme']->value['name']);?>
</span>
                                </div>
                            </a>
                        </div>
                        <?php }?>
                    <?php } ?>            
                </div>
                <div class="tab-pane" id="tabModerator2">
                    <?php  $_smarty_tpl->tpl_vars['theme'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['theme']->_loop = false;
 $_from = themesDB::getThemesFromAddonsServer('blog'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->key => $_smarty_tpl->tpl_vars['theme']->value) {
$_smarty_tpl->tpl_vars['theme']->_loop = true;
?>
                        <?php if (!themesDB::themeExists($_smarty_tpl->tpl_vars['theme']->value['name'])) {?>
                        <div class="addonsBox">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/addThemeFromAddonsServer/<?php echo $_smarty_tpl->tpl_vars['theme']->value['fileEkey'];?>
/<?php echo $_smarty_tpl->tpl_vars['theme']->value['name'];?>
/"> <?php if ($_smarty_tpl->tpl_vars['theme']->value['imageUrl']!='0'||$_smarty_tpl->tpl_vars['theme']->value['imageUrl']!='') {?> <img src="<?php echo $_smarty_tpl->tpl_vars['theme']->value['imageUrl'];?>
"> <?php } else { ?> <img src="<?php echo @constant('ADDONS_SERVER');?>
image/<?php echo $_smarty_tpl->tpl_vars['theme']->value['imageEkey'];?>
/150/150/smart/original/90/"> <?php }?> 
                                <div class="buttons">
                                    <span class="badge badge-inverse"><?php echo str_replace(array('_','-'),array(' ',' '),$_smarty_tpl->tpl_vars['theme']->value['name']);?>
</span>
                                </div>
                            </a>
                        </div>
                        <?php }?>
                    <?php } ?>               
                </div>
                <div class="tab-pane" id="tabModerator3">
                    <?php  $_smarty_tpl->tpl_vars['theme'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['theme']->_loop = false;
 $_from = themesDB::getThemesFromAddonsServer('portal'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->key => $_smarty_tpl->tpl_vars['theme']->value) {
$_smarty_tpl->tpl_vars['theme']->_loop = true;
?>
                        <?php if (!themesDB::themeExists($_smarty_tpl->tpl_vars['theme']->value['name'])) {?>
                        <div class="addonsBox">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/addThemeFromAddonsServer/<?php echo $_smarty_tpl->tpl_vars['theme']->value['fileEkey'];?>
/<?php echo $_smarty_tpl->tpl_vars['theme']->value['name'];?>
/"> <?php if ($_smarty_tpl->tpl_vars['theme']->value['imageUrl']!='0'||$_smarty_tpl->tpl_vars['theme']->value['imageUrl']!='') {?> <img src="<?php echo $_smarty_tpl->tpl_vars['theme']->value['imageUrl'];?>
"> <?php } else { ?> <img src="<?php echo @constant('ADDONS_SERVER');?>
image/<?php echo $_smarty_tpl->tpl_vars['theme']->value['imageEkey'];?>
/150/150/smart/original/90/"> <?php }?> 
                                <div class="buttons">
                                    <span class="badge badge-inverse"><?php echo str_replace(array('_','-'),array(' ',' '),$_smarty_tpl->tpl_vars['theme']->value['name']);?>
</span>
                                </div>
                            </a>
                        </div>
                        <?php }?>
                    <?php } ?>              
                </div>
                <div class="tab-pane" id="tabModerator4">
                    <?php  $_smarty_tpl->tpl_vars['theme'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['theme']->_loop = false;
 $_from = themesDB::getThemesFromAddonsServer('forum'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->key => $_smarty_tpl->tpl_vars['theme']->value) {
$_smarty_tpl->tpl_vars['theme']->_loop = true;
?>
                        <?php if (!themesDB::themeExists($_smarty_tpl->tpl_vars['theme']->value['name'])) {?>
                        <div class="addonsBox">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/addThemeFromAddonsServer/<?php echo $_smarty_tpl->tpl_vars['theme']->value['fileEkey'];?>
/<?php echo $_smarty_tpl->tpl_vars['theme']->value['name'];?>
/"> <?php if ($_smarty_tpl->tpl_vars['theme']->value['imageUrl']!='0'||$_smarty_tpl->tpl_vars['theme']->value['imageUrl']!='') {?> <img src="<?php echo $_smarty_tpl->tpl_vars['theme']->value['imageUrl'];?>
"> <?php } else { ?> <img src="<?php echo @constant('ADDONS_SERVER');?>
image/<?php echo $_smarty_tpl->tpl_vars['theme']->value['imageEkey'];?>
/150/150/smart/original/90/"> <?php }?> 
                                <div class="buttons">
                                    <span class="badge badge-inverse"><?php echo str_replace(array('_','-'),array(' ',' '),$_smarty_tpl->tpl_vars['theme']->value['name']);?>
</span>
                                </div>
                            </a>
                        </div>
                        <?php }?>
                    <?php } ?>              
                </div>    
                <div class="tab-pane" id="tabModerator5">
                    <div class="margin-top">
                        <h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> <?php echo smarty_function_L(array('key'=>"admin.themes.controller.addtemp"),$_smarty_tpl);?>
</h5>
                        <?php echo $_smarty_tpl->tpl_vars['formTheme']->value->toHtml();?>

                    </div>
                    <div class="margin-top">
                        <h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> <?php echo smarty_function_L(array('key'=>"admin.themes.controller.addtemplatezip"),$_smarty_tpl);?>
</h5>
                        <?php echo $_smarty_tpl->tpl_vars['formThemeFile']->value->toHtml();?>

                    </div>            
                </div>                                           
            </div>		    

		<?php } else { ?>
		<div class="box box-floating">
			<h5><i class="fa fa-pencil icon-margin icon-grey"></i> <?php echo smarty_function_L(array('key'=>"admin.content.tpl.edit"),$_smarty_tpl);?>
</h5>
			<?php echo $_smarty_tpl->tpl_vars['formTheme']->value->toHtml();?>

		</div>
		<?php }?>
	</div>
</div>
<?php }} ?>
