<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:18:34
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2719555da2eaddf6d3-68833766%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7ddb16378b4860970f36e78eb99a01b393e4cc9d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\index.tpl',
      1 => 1399899090,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2719555da2eaddf6d3-68833766',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
    'logDB' => 0,
    'log' => 0,
    'systemStatusDB' => 0,
    'stats' => 0,
    'stat' => 0,
    'SITE_PATH' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da2eb154870_26402962',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da2eb154870_26402962')) {function content_555da2eb154870_26402962($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
if (!is_callable('smarty_modifier_truncate')) include 'C:\\xampp\\htdocs\\windu/app/plugins/html/smarty/plugins\\modifier.truncate.php';
?><div class="tabbable">
	  <div class="tab-content">
		    <div class="row-fluid menu mobileHidden margin-bottom">
		    <?php if (usersDB::permissionCheck('adminContentController')) {?>
		      <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/" class="span2 box box-hover-animate" data-toggle="tooltip" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.index.tpl.deleteedit"),$_smarty_tpl);?>
" data-placement="bottom">
				<i class="fa fa-file-text fa-3x icon-orange"></i>
				<h4><?php echo smarty_function_L(array('key'=>"admin.menu.content"),$_smarty_tpl);?>
</h4>
		      </a>
		      <?php }?>
              <?php if (usersDB::permissionCheck('adminConfigController')) {?>
              <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/forum/forums/" class="span2 box box-hover-animate" data-toggle="tooltip" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.index.tpl.forum"),$_smarty_tpl);?>
" data-placement="bottom">
                <i class="fa fa-comments  fa-3x icon-yellow"></i>
                <h4><?php echo smarty_function_L(array('key'=>"admin.menu.forum"),$_smarty_tpl);?>
</h4>
              </a>
              <?php }?> 		      
		      <?php if (usersDB::permissionCheck('adminUsersController')) {?>
		      <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/users/moderator/" class="span2 box box-hover-animate" data-toggle="tooltip" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.index.tpl.addusers"),$_smarty_tpl);?>
" data-placement="bottom">
                <i class="fa fa-users fa-3x icon-green"></i>
                <h4><?php echo smarty_function_L(array('key'=>"admin.menu.users"),$_smarty_tpl);?>
</h4>
			  </a>	
			  <?php }?>
		      <?php if (usersDB::permissionCheck('adminThemesController')) {?>
			  <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/" class="span2 box box-hover-animate" data-toggle="tooltip" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.index.tpl.themes"),$_smarty_tpl);?>
" data-placement="bottom">
                <i class="fa fa-desktop fa-3x icon-blue"></i>
                <h4><?php echo smarty_function_L(array('key'=>"admin.menu.themes"),$_smarty_tpl);?>
</h4>
			  </a>
			  <?php }?>
			  <?php if (usersDB::permissionCheck('adminBackupController')) {?>
			  <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/tools/" class="span2 box box-hover-animate" data-toggle="tooltip" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.index.tpl.tools"),$_smarty_tpl);?>
" data-placement="bottom">
                <i class="fa fa-wrench fa-3x icon-dark"></i>
                <h4><?php echo smarty_function_L(array('key'=>"admin.menu.tools"),$_smarty_tpl);?>
</h4>
			  </a>
			  <?php }?>

			  <?php if (usersDB::permissionCheck('adminSystemController')) {?>
			  <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/system/"  class="span2 box box-hover-animate" data-toggle="tooltip" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.index.tpl.system"),$_smarty_tpl);?>
" data-placement="bottom">
                <i class="fa fa-tachometer fa-3x icon-purple"></i>
                <h4><?php echo smarty_function_L(array('key'=>"admin.menu.system"),$_smarty_tpl);?>
</h4>
			  </a>
			  <?php }?>	      
		    </div>
	    	<div class="row-fluid">
			  	<div class="span4">
				  	<?php if (usersDB::permissionCheck('adminSystemController')&&notifyDB::count()>0) {?>
				  		<div class="box margin-bottom">
				  			<?php echo $_smarty_tpl->getSubTemplate ('common/notify_list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('simple'=>true), 0);?>

				  		</div>
				  	<?php }?>	
				  	<div class="box">
				  		<h5><?php echo smarty_function_L(array('key'=>"admin.system.tpl.lastlogs"),$_smarty_tpl);?>

					  		<div class="buttons">
					  			<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/log/" class="btn btn-small"><?php echo smarty_function_L(array('key'=>"admin.system.tpl.log"),$_smarty_tpl);?>
</a>
					  		</div>
				  		</h5>
						<table class="table table-striped">
						  <tbody>
						  <?php  $_smarty_tpl->tpl_vars['log'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['log']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['logDB']->value->fetchCountGroup('data',"bucket!=30 and bucket!=31 and bucket!=32 and bucket!=33","createTime DESC",'*',7); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['log']->key => $_smarty_tpl->tpl_vars['log']->value) {
$_smarty_tpl->tpl_vars['log']->_loop = true;
?>
							<tr>
								<td class="align-right">
									<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/log/showLogs/<?php echo $_smarty_tpl->tpl_vars['log']->value->bucket;?>
/">
										<?php if ($_smarty_tpl->tpl_vars['log']->value->bucket==logDB::BUCKET_UPDATE) {?>
											<span class="badge badge-info">update</span>
										<?php } elseif ($_smarty_tpl->tpl_vars['log']->value->bucket==logDB::BUCKET_404) {?>
											<span class="badge badge-warning">warning</span>
										<?php } elseif ($_smarty_tpl->tpl_vars['log']->value->bucket==logDB::BUCKET_ERROR) {?>
											<span class="badge badge-important">error</span>
										<?php } elseif ($_smarty_tpl->tpl_vars['log']->value->bucket==logDB::BUCKET_LOGIN_ERROR) {?>
											<span class="badge badge-inverse">login error</span>
										<?php } else { ?>
											<span class="badge">info</span>
										<?php }?>
									</a>									
								</td>
								<td><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['log']->value->data,30);?>
</td>
								<td style="width:40px;"><?php echo generate::showDatatime($_smarty_tpl->tpl_vars['log']->value->createTime,true,true);?>
</td>
							</tr>
						  <?php } ?>   
						  </tbody>
						</table>				  	
				 	</div>
			 	</div>
				<div class="span4">
					<?php echo $_smarty_tpl->getSubTemplate ('common/goProBanner.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					<div class="box">
						<h5>
                            <i class="fa fa-signal icon-margin icon-grey"></i> <?php echo smarty_function_L(array('key'=>"admin.common.statistics.tpl.visits"),$_smarty_tpl);?>

					  		<div class="buttons">
					  			<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/stats/" class="btn btn-small"><?php echo smarty_function_L(array('key'=>"admin.system.tpl.stats"),$_smarty_tpl);?>
</a>
					  		</div>						
						</h5>
						<?php if ($_smarty_tpl->tpl_vars['systemStatusDB']->value->fetchCount()!=0) {?>
						  	
							    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
							    <script type="text/javascript">
							      google.load("visualization", "1", {packages:["corechart"]});
							      $(document).ready(function() {
								      window.dataStatIndex = google.visualization.arrayToDataTable([
											
											['Date', 'Views'],
											<?php if (isset($_smarty_tpl->tpl_vars['stats'])) {$_smarty_tpl->tpl_vars['stats'] = clone $_smarty_tpl->tpl_vars['stats'];
$_smarty_tpl->tpl_vars['stats']->value = $_smarty_tpl->tpl_vars['systemStatusDB']->value->fetchAll(null,'id DESC','*',30); $_smarty_tpl->tpl_vars['stats']->nocache = null; $_smarty_tpl->tpl_vars['stats']->scope = 0;
} else $_smarty_tpl->tpl_vars['stats'] = new Smarty_variable($_smarty_tpl->tpl_vars['systemStatusDB']->value->fetchAll(null,'id DESC','*',30), null, 0);?>
											<?php  $_smarty_tpl->tpl_vars['stat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['stat']->_loop = false;
 $_from = array_reverse($_smarty_tpl->tpl_vars['stats']->value); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['stat']->key => $_smarty_tpl->tpl_vars['stat']->value) {
$_smarty_tpl->tpl_vars['stat']->_loop = true;
?>
											['<?php echo $_smarty_tpl->tpl_vars['stat']->value->date;?>
', <?php echo intval($_smarty_tpl->tpl_vars['stat']->value->pageViewsUniqueCookiesIP);?>
],
											<?php } ?>
											
								        ]);
								      drawLineChartMedium('chartLineStatIndex',window.dataStatIndex);
								  }); 
							    </script>
							 		
		 					 <div id="chartLineStatIndex" style="width: 99.9%; height: 200px;"></div>
		 				<?php } else { ?>
							<div class="alert alert-info">
							  <?php echo smarty_function_L(array('key'=>"admin.nodata"),$_smarty_tpl);?>

							</div>		 					
		 				<?php }?>
		 			</div>
		 			<?php if (license::hasPro()||cookie::get('closeGoProBanner')==1) {?>
		 			<div class="box margin-top margin-bottom">	
				  		<h5>
							<i class="fa fa-upload icon-margin icon-grey"></i> <?php echo smarty_function_L(array('key'=>"admin.system.tpl.memory"),$_smarty_tpl);?>

						  	<div class="buttons">
								<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/system/" class="btn btn-small"><?php echo smarty_function_L(array('key'=>"admin.system.tpl.system"),$_smarty_tpl);?>
</a>					  		
						  	</div>						
						</h5>
						<h2 class="align-center" style="margin-top:40px;"><?php echo cache::read(((string)$_smarty_tpl->tpl_vars['SITE_PATH']->value));?>
MB</h2>
						
					  	
						    <script type="text/javascript">
						      google.load("visualization", "1", {packages:["corechart"]});
						      $(document).ready(function() {
							      window.dataSize = google.visualization.arrayToDataTable([
									  
									  ['Date', 'Size'],
									  <?php  $_smarty_tpl->tpl_vars['stat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['stat']->_loop = false;
 $_from = array_reverse($_smarty_tpl->tpl_vars['systemStatusDB']->value->fetchAll(null,'id DESC','*','30')); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['stat']->key => $_smarty_tpl->tpl_vars['stat']->value) {
$_smarty_tpl->tpl_vars['stat']->_loop = true;
?>
									  ['<?php echo $_smarty_tpl->tpl_vars['stat']->value->date;?>
', <?php echo $_smarty_tpl->tpl_vars['stat']->value->size;?>
],
									  <?php } ?>
							     	  
							        ]);
							      drawLineChartSmall('chartLineSize',window.dataSize);
							  }); 
						    </script>
						 		
						 <div id="chartLineSize" style="width: 99.9%; height:120px;"></div>
					</div>	
					<?php }?>
			</div>			 	
			<div class="span4 box pad align-center mobileHidden" style="height:516px;">
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/pl_PL/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>			
				<div class="fb-like-box"  data-href="http://www.facebook.com/<?php echo smarty_function_L(array('key'=>"facebook.page.key"),$_smarty_tpl);?>
" data-width="100%" data-height="460px" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="true" data-show-border="false"></div>	
			</div>
		</div>			  
	  </div>
</div>
<?php }} ?>
