<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:59:32
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\top_right_buttons.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4053555d9e7468b131-14663130%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05fc1d3405c5259211ee3859dba0d7f00c1c96a2' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\top_right_buttons.tpl',
      1 => 1401123096,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4053555d9e7468b131-14663130',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 1,
    'notifications' => 0,
    'notify' => 0,
    'notesCount' => 0,
    'pins' => 1,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9e74bd2b73_29977686',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9e74bd2b73_29977686')) {function content_555d9e74bd2b73_29977686($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><a href="#" onclick="
	$('#sidebar').toggle();
	$('#content').toggleClass('mobileHidden');
	$('.smallTopNav').toggle();"
	class="noMobileHidden slideButton" style="float:left;">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>

<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo smarty_function_L(array('key'=>'admin.system.tpl.main'),$_smarty_tpl);?>
"><i class="fa fa-globe "></i></a>


<?php if (notifyDB::count()>0&&usersDB::permissionCheck('adminSystemController')) {?>
<a data-content='<?php if (notifyDB::count()>0) {?>
			<table class="table table-striped tablesort">
			  <tbody>
			  <?php  $_smarty_tpl->tpl_vars['notify'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['notify']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['notifications']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['notify']->key => $_smarty_tpl->tpl_vars['notify']->value) {
$_smarty_tpl->tpl_vars['notify']->_loop = true;
?>
				<tr>
					<td>
						<?php if ($_smarty_tpl->tpl_vars['notify']->value->priority==notifyDB::STATUS_LIGHT) {?>
							<span class="badge"><?php echo $_smarty_tpl->tpl_vars['notify']->value->priority;?>
</span>
						<?php } elseif ($_smarty_tpl->tpl_vars['notify']->value->priority==notifyDB::STATUS_INFO) {?>
							<span class="badge badge-info"><?php echo $_smarty_tpl->tpl_vars['notify']->value->priority;?>
</span>				
						<?php } elseif ($_smarty_tpl->tpl_vars['notify']->value->priority==notifyDB::STATUS_WORNING) {?>
							<span class="badge badge-warning"><?php echo $_smarty_tpl->tpl_vars['notify']->value->priority;?>
</span>
						<?php } elseif ($_smarty_tpl->tpl_vars['notify']->value->priority==notifyDB::STATUS_DANGER) {?>
							<span class="badge badge-important"><?php echo $_smarty_tpl->tpl_vars['notify']->value->priority;?>
</span>	
						<?php } elseif ($_smarty_tpl->tpl_vars['notify']->value->priority==notifyDB::STATUS_ERROR) {?>
							<span class="badge badge-inverse"><?php echo $_smarty_tpl->tpl_vars['notify']->value->priority;?>
</span>												
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
				</tr>
			  <?php } ?>   
			  </tbody>
			</table>
			<?php }?>' data-toggle="popover" data-placement="bottom" href="#" data-original-title="<?php echo smarty_function_L(array('key'=>'admin.system.tpl.notices'),$_smarty_tpl);?>
 <a href='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/system/cleanNotifications/' class='btn btn-small pull-right btn-primary'><i class='fa fa-check'></i></a>">
	<i class="fa fa-bell " ></i><span class="badge badge-notifications"><?php echo notifyDB::count();?>
</span>
</a>
<?php }?>		
<?php if (check::update(false,false)) {?>
  	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/update/" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo smarty_function_L(array('key'=>'admin.system.tpl.updatesystem'),$_smarty_tpl);?>
">
		<i class="fa fa-arrow-circle-up ">&nbsp;</i><span class="badge badge-notifications">1</span>
  	</a>   
<?php }?>	
<?php if (isset($_smarty_tpl->tpl_vars['notesCount'])) {$_smarty_tpl->tpl_vars['notesCount'] = clone $_smarty_tpl->tpl_vars['notesCount'];
$_smarty_tpl->tpl_vars['notesCount']->value = notesDB::count(); $_smarty_tpl->tpl_vars['notesCount']->nocache = null; $_smarty_tpl->tpl_vars['notesCount']->scope = 0;
} else $_smarty_tpl->tpl_vars['notesCount'] = new Smarty_variable(notesDB::count(), null, 0);?>         
<a class="tooltip-force mobileHidden" data-placement="bottom" title="<?php echo smarty_function_L(array('key'=>"admin.main.tpl.notes"),$_smarty_tpl);?>
" onclick="$('#noteModalIframe').html('<iframe src=\'<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/ajax/notes/showNotes/\'></iframe>');" href="#modal" data-toggle="modal" data-target="#notesModal" >
	<i class="fa fa-tasks">&nbsp;</i><?php if ($_smarty_tpl->tpl_vars['notesCount']->value>0) {?><span class="badge badge-notifications"><?php echo $_smarty_tpl->tpl_vars['notesCount']->value;?>
</span><?php }?>
</a>

<div class="searchAdminPanel mobileHidden">
	<script src='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/html/resources/select2/select2.min.js' type='text/javascript'></script>
	<script type='text/javascript'>
	
		$(document).ready(function() {
			$("#searchAdminPanel").select2({placeholder: "Wpisz szukane hasło"});
			$("#searchAdminPanel").on("change", function(e) { window.location = e.val; });
		});
		
	</script>
    
	<select id="searchAdminPanel">
		<option value=""></option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.content'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.pageedit'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.contedit'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.orderchange'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.addnews'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.addcontent'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.addpage'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.addphoto'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.addfile'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.gallery'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.editmenu'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/files/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.filelist'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/files/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.fielsadded'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/images/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.photolist'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/images/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.photosadded'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/banners/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.banners'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/polls/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.polls'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/calendar/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.calendar'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/lang/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.langs'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/lang/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.tanslations'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/lang/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.addeditlang'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/trash/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.bin'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/trash/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.deletedelements'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/autosave/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.autosave'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/moderator/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.users'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/moderator/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.usersview'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/moderator/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.commentview'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/moderator/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.comments'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/moderator/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.contentadded'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/admins/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.admins'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/admins/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.addingadmin'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/users/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.editrights'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/users/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.siteusers'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/users/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.addingusers'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/users/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.siteusers'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/users/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.editusers'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/authorization/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.permits'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/authorization/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.edituserpermits'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.graphtemps'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.sitegraphics'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.templates'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.sitegraphics'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.graphtempinst'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.editsitesgraph'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.logotypechange'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.logotype'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.addanalitcode'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/widgets/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.widgets'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/widgets/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.widupdate'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/widgets/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.widgets'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/widgets/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.addonsinstall'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/tools/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.tools'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/tools/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.protools'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/monitoring/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.monitoring'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/monitoring/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.systemstats'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/rss/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.rss'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/rss/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.rsschan'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/seo/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.seo'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/seo/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.errorredirect'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/mailing/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.mailing'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/mailing/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.massmail'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/contacts/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.contacts'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/contacts/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.contactbase'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/database/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.database'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/database/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.tabellist'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/database/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.viewdata'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.config'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.gensettings'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.generalconfig'),$_smarty_tpl);?>
</option>

		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.configcont'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.settingscont'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.configusers'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.userpermits'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.graphconfig'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.graphsetting'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.toolsconfig'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.toolssetting'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.systemconfig'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/config/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.systemsettings'),$_smarty_tpl);?>
</option>

		
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/stats/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.system'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/stats/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.stats'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/stats/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.visits'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/stats/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.entries'),$_smarty_tpl);?>
</option>

		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/notifications/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.notice'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/backup/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.backup'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/backup/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.backupcopy'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/backup/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.systemcopy'),$_smarty_tpl);?>
</option>

		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/log/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.systemlogs'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/log/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.404errors'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/log/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.systemerrors'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/log/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.logins'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/log/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.updates'),$_smarty_tpl);?>
</option>

		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/cron/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.cron'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/cron/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.systemtasks'),$_smarty_tpl);?>
</option>

		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/firewall/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.firewall'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/firewall/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.systemfirewall'),$_smarty_tpl);?>
</option>

		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/requestlog/showLogs/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.reqlog'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/requestlog/showLogs/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.references'),$_smarty_tpl);?>
</option>

		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/licence/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.license'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/licence/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.windupro'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/licence/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.winduplus'),$_smarty_tpl);?>
</option>
		<option value="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/licence/"><?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.keyactivation'),$_smarty_tpl);?>
</option>
	</select>
    
</div>


<a data-content='<ul class="paneltype-menu">
                      <li><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/setPanelMode/0/"><i class="fa fa-leaf icon-green"></i> <?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.simplified'),$_smarty_tpl);?>
</a></li>
                      <li><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/setPanelMode/1/"><i class="fa fa-plane"></i> <?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.basic'),$_smarty_tpl);?>
</a></li>
                      <li><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/setPanelMode/2/"><i class="fa fa-bolt icon-red"></i> <?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.advanced'),$_smarty_tpl);?>
</a></li>
                </ul>' data-toggle="popover" data-placement="bottom" href="#" data-original-title="Tryb panelu" class="<?php if (usersDB::isDeveloper()) {?> user-dropdown-danger<?php } elseif (usersDB::isNoob()) {?> user-dropdown-green<?php } else { ?> user-dropdown-blue<?php }?>  <?php if (is_array($_smarty_tpl->tpl_vars['pins']->value)) {?>top-menu-margin-right<?php }?> smallMobileHidden">
	<?php if (usersDB::isNoob()) {?>
		<i class="fa fa-leaf icon-margin"></i> <?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.simplifiedmod'),$_smarty_tpl);?>

	<?php } elseif (usersDB::isDeveloper()) {?>
		<i class="fa fa-bolt icon-margin"></i> <?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.advmod'),$_smarty_tpl);?>

	<?php } else { ?>
		<i class="fa fa-plane icon-margin"></i> <?php echo smarty_function_L(array('key'=>'admin.system.rightbuttons.tpl.basicmod'),$_smarty_tpl);?>

	<?php }?>
</a>
<?php if (!license::hasPro()) {?>
	<a href="<?php if (lang::read('lang')=='PL') {?><?php echo license::$buyLicensesLinkPL;?>
<?php } else { ?><?php echo license::$buyLicensesLinkEN;?>
<?php }?>" target="blank" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo smarty_function_L(array('key'=>'admin.main.tpl.buypro'),$_smarty_tpl);?>
" class="goPro mobileHidden smallWidthHidden"><i class="fa fa-arrow-up "></i>&nbsp;&nbsp;Go PRO&nbsp;</a>
<?php }?>

<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/login/logout/" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo smarty_function_L(array('key'=>'admin.main.tpl.logout'),$_smarty_tpl);?>
"><i class="fa fa-lock "> </i>&nbsp;</a>

<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/flushCache/" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo smarty_function_L(array('key'=>'admin.system.tpl.deletecache'),$_smarty_tpl);?>
" >
    <i class="fa fa-repeat ">&nbsp;</i><?php if (config::get('cleanCacheFlag')==1) {?><span class="badge badge-notifications"><?php echo config::get('cleanCacheFlag');?>
</span><?php }?>
</a>











<?php }} ?>
