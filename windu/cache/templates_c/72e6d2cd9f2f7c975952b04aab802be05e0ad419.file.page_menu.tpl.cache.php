<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:59:31
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\page_menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6110555d9e737271c2-67345549%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '72e6d2cd9f2f7c975952b04aab802be05e0ad419' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\page_menu.tpl',
      1 => 1400167150,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6110555d9e737271c2-67345549',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
    'REQUEST' => 0,
    'loggedUser' => 0,
    'subpage' => 0,
    'configDB' => 0,
    'buckets' => 0,
    'key' => 0,
    'menuExtList' => 0,
    'menuItem' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9e741dfb19_00542773',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9e741dfb19_00542773')) {function content_555d9e741dfb19_00542773($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><center>
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/" class="mobileHidden logo"><img src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/admin/resources/img/logo-icon<?php echo license::get();?>
.png" ></a>
</center>
<a href="#" onclick="
	$( '#sidebar').toggle();
	$('#content').toggleClass('mobileHidden');
	$( '.smallTopNav').toggle();"
	class="noMobileHidden slideButton" style="display:block;">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>
<ul class="menu accordion" id="leftMenu">
	<?php if (usersDB::permissionCheck('adminContentController')&&usertypesDB::havePanelPermission('mainContent')) {?>
	<li class="accordion-group <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminContentController') {?>active<?php }?>">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuContent">
	        <i class="fa fa-file-text "> </i> <span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.menu.content"),$_smarty_tpl);?>
</span>
	      </a>
	    </div>	
	    <div id="leftMenuContent" class="accordion-body collapse <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminContentController'&&config::get("smallSidebar".((string)$_smarty_tpl->tpl_vars['loggedUser']->value->id))!=1) {?>in<?php }?>">
      		<div class="accordion-inner">
				<ul>
				    <?php if (usertypesDB::havePanelPermission('pages')) {?><?php if (usertypesDB::havePanelPermission('pages')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='pages') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/"><i class="color-icons icons-clipboard-list icon-margin"> </i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.content.tpl.pages"),$_smarty_tpl);?>
</span></a></li><?php }?><?php }?>
				   	<?php if (usertypesDB::havePanelPermission('files')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='files') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/files/"><i class="color-icons icons-blue-folder-horizontal icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.file"),$_smarty_tpl);?>
</span></a></li><?php }?>	
				   	<?php if (usertypesDB::havePanelPermission('images')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='images') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/images/"><i class="color-icons icons-inbox-slide icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.images"),$_smarty_tpl);?>
</span></a></li><?php }?>
					<?php if (usertypesDB::havePanelPermission('banners')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='banners') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/banners/"><i class="color-icons icons-caution-board icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.banners"),$_smarty_tpl);?>
<?php if (!license::hasPro()) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?>
					<?php if (usertypesDB::havePanelPermission('polls')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='polls') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/polls/"><i class="color-icons icons-document-task icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.polls"),$_smarty_tpl);?>
<?php if (!license::hasPro()) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?>
					<?php if (usertypesDB::havePanelPermission('calendar')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='calendar') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/calendar/"><i class="color-icons icons-calendar-list icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.calendar"),$_smarty_tpl);?>
<?php if (!license::hasPro()) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?>
				  		   		
				    <?php if (!usersDB::isNoob()) {?><?php if (usertypesDB::havePanelPermission('lang')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='lang') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/lang/"><i class="color-icons icons-direction icon-margin"> </i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.content.common.tpl.languages"),$_smarty_tpl);?>
</span></a></li><?php }?><?php }?>
				    <?php if (usertypesDB::havePanelPermission('trash')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='trash') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/trash/"><i class="color-icons icons-popcorn icon-margin"> </i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.content.tpl.trash"),$_smarty_tpl);?>
</span></a></li><?php }?>
				    <?php if (usertypesDB::havePanelPermission('autosave')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='autosave') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/autosave/"><i class="color-icons icons-disk-black icon-margin"> </i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.content.tpl.autosave"),$_smarty_tpl);?>
</span></a></li><?php }?>
			
				    <?php if (!usersDB::isNoob()) {?><?php if (usertypesDB::havePanelPermission('configContent')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='config'&&$_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminContentController') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/config/"><i class="color-icons icons-gear icon-margin"> </i><span class="menu-description"><?php echo smarty_function_L(array('key'=>'admin.menu.config'),$_smarty_tpl);?>
</span></a></li><?php }?><?php }?>
				</ul>	
			</div>
		</div>			
	</li>
	<?php }?>
	<?php if (usersDB::permissionCheck('adminUsersController')&&usertypesDB::havePanelPermission('mainForum')) {?>
	<li class="accordion-group <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminForumController') {?>active<?php }?>">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuForum">
	        <i class="fa fa-comments "> </i> <span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.menu.forum"),$_smarty_tpl);?>
</span>
	      </a>
	    </div>	
	    <div id="leftMenuForum" class="accordion-body collapse <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminForumController'&&config::get("smallSidebar".((string)$_smarty_tpl->tpl_vars['loggedUser']->value->id))!=1) {?>in<?php }?>">
      		<div class="accordion-inner">	
				<ul>
				    <?php if (usertypesDB::havePanelPermission('forums')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='forums') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/forum/forums/"><i class="color-icons icons-application-list icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.forum.tpl.forums"),$_smarty_tpl);?>
</span></a></li><?php }?>
				    <?php if (usertypesDB::havePanelPermission('posts')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='posts') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/forum/posts/"><i class="color-icons icons-balloon-white-left icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.forum.tpl.posts"),$_smarty_tpl);?>
</span></a></li><?php }?>
					<?php if (usertypesDB::havePanelPermission('stats')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='stats') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/forum/stats/"><i class="color-icons icons-chart-up icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.forum.tpl.stats"),$_smarty_tpl);?>
</span></a></li><?php }?>
					
				    <?php if (!usersDB::isNoob()) {?><?php if (usertypesDB::havePanelPermission('configForum')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='config'&&$_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminForumController') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/forum/config/"><i class="color-icons icons-gear icon-margin"> </i><span class="menu-description"><?php echo smarty_function_L(array('key'=>'admin.menu.config'),$_smarty_tpl);?>
</span></a></li><?php }?><?php }?>
			  	</ul>	
			</div>
		</div>				  		
	</li>
	<?php }?>	
	<?php if (usersDB::permissionCheck('adminUsersController')&&usertypesDB::havePanelPermission('mainUsers')) {?>
	<li class="accordion-group <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminUsersController') {?>active<?php }?>">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuUsers">
	        <i class="fa fa-users "> </i> <span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.menu.users"),$_smarty_tpl);?>
</span>
	      </a>
	    </div>	
	    <div id="leftMenuUsers" class="accordion-body collapse <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminUsersController'&&config::get("smallSidebar".((string)$_smarty_tpl->tpl_vars['loggedUser']->value->id))!=1) {?>in<?php }?>">
      		<div class="accordion-inner">	
				<ul>
				    <?php if (usertypesDB::havePanelPermission('moderator')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='moderator') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/moderator/"><i class="color-icons icons-balloon-white-left icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.moderator"),$_smarty_tpl);?>
</span></a></li><?php }?>
				    <?php if (!usersDB::isNoob()) {?><?php if (usertypesDB::havePanelPermission('admins')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='admins') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/admins/"><i class="color-icons icons-user-black icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.users.ctpl.admins"),$_smarty_tpl);?>
</span></a></li><?php }?><?php }?>
				    <?php if (usertypesDB::havePanelPermission('users')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='users') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/users/"><i class="color-icons icons-user-yellow icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.users.ctpl.users"),$_smarty_tpl);?>
</span></a></li><?php }?>
				    <?php if (!usersDB::isNoob()) {?><?php if (usertypesDB::havePanelPermission('authorization')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='authorization') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/authorization/"><i class="color-icons icons-wallet icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.users.ctpl.authorization"),$_smarty_tpl);?>
<?php if (!license::hasPro()) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?><?php }?>
                    <?php if (!usersDB::isNoob()) {?><?php if (usertypesDB::havePanelPermission('history')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='history') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/history/"><i class="color-icons icons-clipboard-invoice icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.users.ctpl.history"),$_smarty_tpl);?>
<?php if (!license::hasPro()) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?><?php }?>

                    <?php if (!usersDB::isNoob()) {?><?php if (usertypesDB::havePanelPermission('configUsers')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='config'&&$_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminUsersController') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/config/"><i class="color-icons icons-gear icon-margin"> </i><span class="menu-description"><?php echo smarty_function_L(array('key'=>'admin.menu.config'),$_smarty_tpl);?>
</span></a></li><?php }?><?php }?>
				</ul>  
			</div>
		</div>						
	</li>
	<?php }?>
	<?php if (usersDB::permissionCheck('adminThemesController')&&usertypesDB::havePanelPermission('mainThemes')) {?>
	<li class="accordion-group <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminThemesController') {?>active<?php }?>">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuThemes">
	        <i class="fa fa-desktop "> </i> <span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.menu.themes"),$_smarty_tpl);?>
</span>
	      </a>
	    </div>	
	    <div id="leftMenuThemes" class="accordion-body collapse <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminThemesController'&&config::get("smallSidebar".((string)$_smarty_tpl->tpl_vars['loggedUser']->value->id))!=1) {?>in<?php }?>">
      		<div class="accordion-inner">	
				<ul>
				    <?php if (usertypesDB::havePanelPermission('themes')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='themes') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/"><i class="color-icons icons-resource-monitor icon-margin"> </i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.themes.tpl.graphictemplates"),$_smarty_tpl);?>
</span></a></li><?php }?>
				    <?php if (!usersDB::isNoob()) {?><?php if (usertypesDB::havePanelPermission('widgets')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='widgets') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/widgets/"><i class="color-icons icons-resource-monitor-protector icon-margin"> </i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.themes.tpl.widgets"),$_smarty_tpl);?>
</span></a></li><?php }?><?php }?>
				    
				    <?php if (!usersDB::isNoob()) {?><?php if (usertypesDB::havePanelPermission('configThemes')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='config'&&$_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminThemesController') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/config/"><i class="color-icons icons-gear icon-margin"> </i><span class="menu-description"><?php echo smarty_function_L(array('key'=>'admin.menu.config'),$_smarty_tpl);?>
</span></a></li><?php }?><?php }?>
				</ul>	
			</div>
		</div>			
	</li>
	<?php }?>
	<?php if (usersDB::permissionCheck('adminToolsController')&&usertypesDB::havePanelPermission('mainTools')) {?>
	<li class="accordion-group <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminToolsController') {?>active<?php }?>">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuTools">
	        <i class="fa fa-wrench "> </i> <span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.menu.tools"),$_smarty_tpl);?>
</span>
	      </a>
	    </div>	
	    <div id="leftMenuTools" class="accordion-body collapse <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminToolsController'&&config::get("smallSidebar".((string)$_smarty_tpl->tpl_vars['loggedUser']->value->id))!=1) {?>in<?php }?>">
      		<div class="accordion-inner">		
				<ul>
				  	<?php if (usertypesDB::havePanelPermission('tools')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='tools') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/tools/"><i class="color-icons icons-wooden-box icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.tools"),$_smarty_tpl);?>
</span></a></li><?php }?>
				  	<?php if (usertypesDB::havePanelPermission('monitoring')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='monitoring') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/monitoring/"><i class="color-icons icons-application-monitor icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.monitoring"),$_smarty_tpl);?>
<?php if (!license::hasPro()) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?>
					<?php if (usertypesDB::havePanelPermission('rss')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='rss') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/rss/"><i class="color-icons icons-printer icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.rss"),$_smarty_tpl);?>
<?php if (!license::hasPro()) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?>
				  	<?php if (usertypesDB::havePanelPermission('seo')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='seo') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/seo/"><i class="color-icons icons-globe icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.seo"),$_smarty_tpl);?>
<?php if (!license::hasPro()) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?>
					<?php if (usertypesDB::havePanelPermission('mailing')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='mailing') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/mailing/"><i class="color-icons icons-mail--arrow icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.mailing"),$_smarty_tpl);?>
<?php if (!license::hasPro('pro')) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?>	
					<?php if (usertypesDB::havePanelPermission('contacts')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='contacts') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/contacts/"><i class="color-icons icons-inbox-document-text icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.contact"),$_smarty_tpl);?>
<?php if (!license::hasPro('pro')) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?>
			 	 	<?php if (!usersDB::isNoob()) {?>
			 	 		<?php if (usertypesDB::havePanelPermission('database')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='database') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/database/"><i class="color-icons icons-databases icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.database"),$_smarty_tpl);?>
<?php if (!license::hasPro('pro')) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?>
			 	  	<?php }?>
			 	 	
				    <?php if (!usersDB::isNoob()) {?><?php if (usertypesDB::havePanelPermission('configTools')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='config'&&$_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminToolsController') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><i class="color-icons icons-gear icon-margin"> </i><span class="menu-description"><?php echo smarty_function_L(array('key'=>'admin.menu.config'),$_smarty_tpl);?>
</span></a></li><?php }?><?php }?>
			 	</ul>	
			</div>
		</div>	 		
	</li>
	<?php }?>
	<?php if (usersDB::permissionCheck('adminConfigController')&&!usersDB::isNoob()&&usertypesDB::havePanelPermission('mainConfig')) {?>
	<li class="accordion-group <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminConfigController') {?>active<?php }?>">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuConfig">
	        <i class="fa fa-cogs "> </i> <span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.menu.config"),$_smarty_tpl);?>
</span>
	      </a>
	    </div>	
	    <div id="leftMenuConfig" class="accordion-body collapse <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminConfigController'&&config::get("smallSidebar".((string)$_smarty_tpl->tpl_vars['loggedUser']->value->id))!=1) {?>in<?php }?>">
      		<div class="accordion-inner">
				<ul>
					<?php if (isset($_smarty_tpl->tpl_vars['buckets'])) {$_smarty_tpl->tpl_vars['buckets'] = clone $_smarty_tpl->tpl_vars['buckets'];
$_smarty_tpl->tpl_vars['buckets']->value = $_smarty_tpl->tpl_vars['configDB']->value->fetchGroup('bucket','bucket!=99','name ASC'); $_smarty_tpl->tpl_vars['buckets']->nocache = null; $_smarty_tpl->tpl_vars['buckets']->scope = 0;
} else $_smarty_tpl->tpl_vars['buckets'] = new Smarty_variable($_smarty_tpl->tpl_vars['configDB']->value->fetchGroup('bucket','bucket!=99','name ASC'), null, 0);?>
				    <?php  $_smarty_tpl->tpl_vars['bucket'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['bucket']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['buckets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['bucket']->key => $_smarty_tpl->tpl_vars['bucket']->value) {
$_smarty_tpl->tpl_vars['bucket']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['bucket']->key;
?>
				    <li <?php if ($_smarty_tpl->tpl_vars['subpage']->value==$_smarty_tpl->tpl_vars['key']->value) {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/config/<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
/"><i class="color-icons icons-gear icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>$_smarty_tpl->tpl_vars['configDB']->value->bucketNames[$_smarty_tpl->tpl_vars['key']->value]),$_smarty_tpl);?>
</a></li>
				    <?php } ?>
				</ul>	
			</div>
		</div>			
	</li>
	<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['menuExtList'])) {$_smarty_tpl->tpl_vars['menuExtList'] = clone $_smarty_tpl->tpl_vars['menuExtList'];
$_smarty_tpl->tpl_vars['menuExtList']->value = pluginManager::loadAdminMenuItems()&&usertypesDB::havePanelPermission('mainCustomPanels'); $_smarty_tpl->tpl_vars['menuExtList']->nocache = null; $_smarty_tpl->tpl_vars['menuExtList']->scope = 0;
} else $_smarty_tpl->tpl_vars['menuExtList'] = new Smarty_variable(pluginManager::loadAdminMenuItems()&&usertypesDB::havePanelPermission('mainCustomPanels'), null, 0);?>
	<?php if (is_array($_smarty_tpl->tpl_vars['menuExtList']->value)) {?>
		<?php  $_smarty_tpl->tpl_vars['menuItem'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menuItem']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menuExtList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menuItem']->key => $_smarty_tpl->tpl_vars['menuItem']->value) {
$_smarty_tpl->tpl_vars['menuItem']->_loop = true;
?>
			<li <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()==$_smarty_tpl->tpl_vars['menuItem']->value['controllerName']) {?>class="active"<?php }?>>
				<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['menuItem']->value['adminUrl'];?>
">
					<i class="fa fa-clipboard "> </i> <span class="menu-description"><?php echo $_smarty_tpl->tpl_vars['menuItem']->value['title'];?>
</span>
				</a>
			</li>
		<?php } ?>	
	<?php }?>		
	<?php if (usersDB::permissionCheck('adminSystemController')&&usertypesDB::havePanelPermission('mainSystem')) {?>
	<li class="accordion-group <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminSystemController') {?>active<?php }?>">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuSystem">
	        <i class="fa fa-tachometer "> </i> <span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.menu.system"),$_smarty_tpl);?>
</span>
	      </a>
	    </div>	
	    <div id="leftMenuSystem" class="accordion-body collapse <?php if ($_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminSystemController'&&config::get("smallSidebar".((string)$_smarty_tpl->tpl_vars['loggedUser']->value->id))!=1) {?>in<?php }?>">
      		<div class="accordion-inner">
				<ul>
				  	<?php if (usertypesDB::havePanelPermission('system')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='system') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/system/"><i class="color-icons icons-system-monitor icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.system.tpl.system"),$_smarty_tpl);?>
</span></a></li><?php }?>
				  	<?php if (usertypesDB::havePanelPermission('stats')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='stats') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/stats/"><i class="color-icons icons-chart-up icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.stats"),$_smarty_tpl);?>
</span></a></li><?php }?>
				  	<?php if (usertypesDB::havePanelPermission('notifications')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='notifications') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/notifications/"><i class="color-icons icons icons-caution-board icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.system.tpl.notifications"),$_smarty_tpl);?>
</span></a></li><?php }?>
					<?php if (usertypesDB::havePanelPermission('backup')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='backup') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/backup/"><i class="color-icons icons-wooden-box-label icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.backup"),$_smarty_tpl);?>
<?php if (!license::hasPro()) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?>	
				     	
					<?php if (!usersDB::isNoob()) {?>
						<?php if (usertypesDB::havePanelPermission('log')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='log') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/log/"><i class="color-icons icons-rocket icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.system.tpl.log"),$_smarty_tpl);?>
<?php if (!license::hasPro()) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?>
				  		<?php if (usertypesDB::havePanelPermission('cron')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='cron') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/cron/"><i class="color-icons icons-clipboard-invoice icon-margin">&nbsp;</i><span class="menu-description">Cron<?php if (!license::hasPro('pro')) {?><span class="small-pro">Pro</span><?php }?></a></span></li><?php }?>
			 	 		<?php if (usertypesDB::havePanelPermission('firewall')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='firewall') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/firewall/"><i class="color-icons icons-network-ethernet icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.firewall"),$_smarty_tpl);?>
<?php if (!license::hasPro('pro')) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?>
			 	 		<?php if (usertypesDB::havePanelPermission('requestlog')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='requestlog') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/requestlog/showLogs/"><i class="color-icons icons-system-monitor-network icon-margin icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.requestlog"),$_smarty_tpl);?>
<?php if (!license::hasPro('pro')) {?><span class="small-pro">Pro</span><?php }?></a></li><?php }?>
					<?php }?>	 
					<?php if (usertypesDB::havePanelPermission('licence')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='licence') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/licence/"><i class="color-icons icons-money icon-margin">&nbsp;</i><span class="menu-description"><?php echo smarty_function_L(array('key'=>"admin.system.tpl.license"),$_smarty_tpl);?>
</span></a></li><?php }?>
			 	 	   
				    <?php if (!usersDB::isNoob()) {?><?php if (usertypesDB::havePanelPermission('configSystem')) {?><li <?php if ($_smarty_tpl->tpl_vars['subpage']->value=='config'&&$_smarty_tpl->tpl_vars['REQUEST']->value->controllerName()=='adminSystemController') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/config/"><i class="color-icons icons-gear icon-margin"> </i><span class="menu-description"><?php echo smarty_function_L(array('key'=>'admin.menu.config'),$_smarty_tpl);?>
</span></a></li><?php }?><?php }?>
				</ul>
			</div>
		</div>				
	</li>
	<?php }?>
</ul><?php }} ?>
