<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:55:17
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\frontEditor.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21669555d9d759440c9-83478031%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'faa843bcf2e3ee61540d2ea1d0b8a01859c06e47' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\frontEditor.tpl',
      1 => 1400196374,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21669555d9d759440c9-83478031',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'adminUser' => 1,
    'HOME' => 1,
    'lessVariablesList' => 1,
    'lessVariable' => 1,
    'TEMPLATE_HOME' => 1,
    'bg' => 1,
    'page' => 1,
    'key' => 1,
    'template' => 1,
    'themes' => 1,
    'theme' => 1,
    'inPnaceEditorConfigName' => 1,
    'inPnaceWidgetsConfigName' => 1,
    'inPnaceImagesConfigName' => 1,
    'enableLeftMenuConfigName' => 1,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9d76024331_60550266',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9d76024331_60550266')) {function content_555d9d76024331_60550266($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?>
<?php if (isset($_smarty_tpl->tpl_vars['adminUser'])) {$_smarty_tpl->tpl_vars['adminUser'] = clone $_smarty_tpl->tpl_vars['adminUser'];
$_smarty_tpl->tpl_vars['adminUser']->value = usersDB::getLoggedUser('AdminUser'); $_smarty_tpl->tpl_vars['adminUser']->nocache = true; $_smarty_tpl->tpl_vars['adminUser']->scope = 0;
} else $_smarty_tpl->tpl_vars['adminUser'] = new Smarty_variable(usersDB::getLoggedUser('AdminUser'), true, 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['adminUserId'])) {$_smarty_tpl->tpl_vars['adminUserId'] = clone $_smarty_tpl->tpl_vars['adminUserId'];
$_smarty_tpl->tpl_vars['adminUserId']->value = $_smarty_tpl->tpl_vars['adminUser']->value->id; $_smarty_tpl->tpl_vars['adminUserId']->nocache = true; $_smarty_tpl->tpl_vars['adminUserId']->scope = 0;
} else $_smarty_tpl->tpl_vars['adminUserId'] = new Smarty_variable($_smarty_tpl->tpl_vars['adminUser']->value->id, true, 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['inPnaceEditorConfigName'])) {$_smarty_tpl->tpl_vars['inPnaceEditorConfigName'] = clone $_smarty_tpl->tpl_vars['inPnaceEditorConfigName'];
$_smarty_tpl->tpl_vars['inPnaceEditorConfigName']->value = "inPlaceEditor".((string)$_smarty_tpl->tpl_vars['adminUserId']->value); $_smarty_tpl->tpl_vars['inPnaceEditorConfigName']->nocache = true; $_smarty_tpl->tpl_vars['inPnaceEditorConfigName']->scope = 0;
} else $_smarty_tpl->tpl_vars['inPnaceEditorConfigName'] = new Smarty_variable("inPlaceEditor".((string)$_smarty_tpl->tpl_vars['adminUserId']->value), true, 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['inPnaceWidgetsConfigName'])) {$_smarty_tpl->tpl_vars['inPnaceWidgetsConfigName'] = clone $_smarty_tpl->tpl_vars['inPnaceWidgetsConfigName'];
$_smarty_tpl->tpl_vars['inPnaceWidgetsConfigName']->value = "showInPlaceWidgetsBox".((string)$_smarty_tpl->tpl_vars['adminUserId']->value); $_smarty_tpl->tpl_vars['inPnaceWidgetsConfigName']->nocache = true; $_smarty_tpl->tpl_vars['inPnaceWidgetsConfigName']->scope = 0;
} else $_smarty_tpl->tpl_vars['inPnaceWidgetsConfigName'] = new Smarty_variable("showInPlaceWidgetsBox".((string)$_smarty_tpl->tpl_vars['adminUserId']->value), true, 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['inPnaceImagesConfigName'])) {$_smarty_tpl->tpl_vars['inPnaceImagesConfigName'] = clone $_smarty_tpl->tpl_vars['inPnaceImagesConfigName'];
$_smarty_tpl->tpl_vars['inPnaceImagesConfigName']->value = "showInPlaceImagesBox".((string)$_smarty_tpl->tpl_vars['adminUserId']->value); $_smarty_tpl->tpl_vars['inPnaceImagesConfigName']->nocache = true; $_smarty_tpl->tpl_vars['inPnaceImagesConfigName']->scope = 0;
} else $_smarty_tpl->tpl_vars['inPnaceImagesConfigName'] = new Smarty_variable("showInPlaceImagesBox".((string)$_smarty_tpl->tpl_vars['adminUserId']->value), true, 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['enableLeftMenuConfigName'])) {$_smarty_tpl->tpl_vars['enableLeftMenuConfigName'] = clone $_smarty_tpl->tpl_vars['enableLeftMenuConfigName'];
$_smarty_tpl->tpl_vars['enableLeftMenuConfigName']->value = "showLeftEditor".((string)$_smarty_tpl->tpl_vars['adminUserId']->value); $_smarty_tpl->tpl_vars['enableLeftMenuConfigName']->nocache = true; $_smarty_tpl->tpl_vars['enableLeftMenuConfigName']->scope = 0;
} else $_smarty_tpl->tpl_vars['enableLeftMenuConfigName'] = new Smarty_variable("showLeftEditor".((string)$_smarty_tpl->tpl_vars['adminUserId']->value), true, 0);?>

<?php if (isset($_smarty_tpl->tpl_vars['lessVariablesList'])) {$_smarty_tpl->tpl_vars['lessVariablesList'] = clone $_smarty_tpl->tpl_vars['lessVariablesList'];
$_smarty_tpl->tpl_vars['lessVariablesList']->value = less::getVariablesFromFile(((string)$_smarty_tpl->tpl_vars['TEMPLATE_HOME']->value)."/css_less/less.css"); $_smarty_tpl->tpl_vars['lessVariablesList']->nocache = true; $_smarty_tpl->tpl_vars['lessVariablesList']->scope = 0;
} else $_smarty_tpl->tpl_vars['lessVariablesList'] = new Smarty_variable(less::getVariablesFromFile(((string)$_smarty_tpl->tpl_vars['TEMPLATE_HOME']->value)."/css_less/less.css"), true, 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['bg'])) {$_smarty_tpl->tpl_vars['bg'] = clone $_smarty_tpl->tpl_vars['bg'];
$_smarty_tpl->tpl_vars['bg']->value = config::get("backgroundAdmin".((string)$_smarty_tpl->tpl_vars['adminUserId']->value)); $_smarty_tpl->tpl_vars['bg']->nocache = true; $_smarty_tpl->tpl_vars['bg']->scope = 0;
} else $_smarty_tpl->tpl_vars['bg'] = new Smarty_variable(config::get("backgroundAdmin".((string)$_smarty_tpl->tpl_vars['adminUserId']->value)), true, 0);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="copyright" content="Copyright (c) WinduCMS">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        

		<link rel='stylesheet' href='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/bootstrap/css/bootstrap.min.css'>
		<link rel='stylesheet' href='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/bootstrap/css/bootstrap-colorpicker.css'>
		<link rel='stylesheet' href='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/admin/resources/css/bootstrap-extends.css'>
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/css/font-awesome.min.css">
		<link rel='stylesheet' href='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/front/resources/css/editorFront.css'>
		
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/js/jquery.cookie.js"></script>	
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/js/jquery-ui.js"></script>	
		
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/resources/bootstrap/js/bootstrap-colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/front/resources/js/frontEditor.js"></script>
					
		<script type="text/javascript">
			window.HOME = "<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
";
			window.TEMPLATE = "<?php echo config::get('template');?>
";

			function updateLessAction(){
				parent.less.modifyVars({
					<?php  $_smarty_tpl->tpl_vars['lessVariable'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lessVariable']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lessVariablesList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lessVariable']->key => $_smarty_tpl->tpl_vars['lessVariable']->value) {
$_smarty_tpl->tpl_vars['lessVariable']->_loop = true;
?>
						'@<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
' : $('#<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
').val(),	
					<?php } ?>
				});
			}
			function saveLessVariables(){
				var finalVars = [];
				<?php  $_smarty_tpl->tpl_vars['lessVariable'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lessVariable']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lessVariablesList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lessVariable']->key => $_smarty_tpl->tpl_vars['lessVariable']->value) {
$_smarty_tpl->tpl_vars['lessVariable']->_loop = true;
?>
				finalVars = finalVars+'@<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
'+':'+$('#<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
').val()+',';	
				<?php } ?>
				var lessUrl = encodeURIComponent(encodeURIComponent('<?php echo $_smarty_tpl->tpl_vars['TEMPLATE_HOME']->value;?>
/css_less/less.css'));
				finalVars = encodeURIComponent(finalVars);
						
				$( '.menu-left-alert' ).load( '<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/saveLessVariables/'+lessUrl+'/'+finalVars+'/', function() {
					$( ".menu-left-alert" ).slideDown("fast");
					$( ".menu-left-alert" ).delay(2000).slideUp("slow");
				});				 
			}	
			function setOpenMenu(id){	
				$.cookie('openMenu', id,{ path: '<?php echo @constant('SUBDIR');?>
'});
			}
			function setOpenConfigMenu(id){	
				$.cookie('openConfigMenu', id,{ path: '<?php echo @constant('SUBDIR');?>
'});
			}			
			$(document).ready(function(){
			    $('[data-toggle=tooltip]').tooltip({ html : true });
			    $('.tooltip-force').tooltip({ html : true });
			});	
					
		</script>	
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<title><?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.frontedit"),$_smarty_tpl);?>
</title>
	</head>
	<body id="adminMenuLeft" style="verflow-x:hidden; background-color: #<?php if ($_smarty_tpl->tpl_vars['bg']->value!=null) {?><?php echo $_smarty_tpl->tpl_vars['bg']->value;?>
<?php }?>;">
		<div class="circuleButtons">
			<a href="#" onclick="parent.location.href='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/pages/edit/<?php echo $_smarty_tpl->tpl_vars['page']->value->id;?>
/'"  data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.edit"),$_smarty_tpl);?>
"><i class="fa fa-pencil"></i></a>
			<a href="#" onclick="parent.location.href='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/edit/<?php echo themesDB::getThemeName();?>
/tpl_views/tpl_views/<?php echo $_smarty_tpl->tpl_vars['page']->value->tpl;?>
/'" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.edittemplate"),$_smarty_tpl);?>
"><i class="fa fa-pencil-square"></i></a>
			<a href="#" onclick="parent.location.href='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/edit/<?php echo themesDB::getThemeName();?>
/css/css/main.css/'"  data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.editcss"),$_smarty_tpl);?>
"><i class="fa fa-list-alt"></i></a>
			<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/toggleHideParent/<?php echo $_smarty_tpl->tpl_vars['page']->value->id;?>
/" title="<?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.hide"),$_smarty_tpl);?>
" class="<?php if ($_smarty_tpl->tpl_vars['page']->value->status==2) {?>red<?php } else { ?>green<?php }?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.set"),$_smarty_tpl);?>
"><i class=" fa fa-eye"></i></a>
			
			<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/flushCacheFront/" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.clearcache"),$_smarty_tpl);?>
" class="orange"><i class="fa fa-repeat"></i></a>
			<a href="#" onclick="parent.location.href='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/login/logoutFront/'"  data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.logout"),$_smarty_tpl);?>
" class="red"><i class=" fa fa-lock"></i></a>
		</div>     
	
		</div>
		<div class="accordion" id="accordion2">
		  <?php if (count($_smarty_tpl->tpl_vars['lessVariablesList']->value)>0) {?>
		  <div class="accordion-group">
		    <div class="accordion-heading">
		      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" onclick="setOpenMenu('1');">
		        <i class="fa fa-desktop"></i> <?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.color"),$_smarty_tpl);?>

		      </a>
		    </div>
		    <div id="collapseOne" class="acc ordion-body collapse <?php if (cookie::read('openMenu')=='1') {?>in<?php }?>">
		      <div class="accordion-inner">
				<?php  $_smarty_tpl->tpl_vars['lessVariable'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lessVariable']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lessVariablesList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lessVariable']->key => $_smarty_tpl->tpl_vars['lessVariable']->value) {
$_smarty_tpl->tpl_vars['lessVariable']->_loop = true;
?>
					<?php if ($_smarty_tpl->tpl_vars['lessVariable']->value['type']=='color') {?>
						<div class="input-box"><input type="text" class="editor-input" value="<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['value'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
" data-color-format="rgb" style="background-color:<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['value'];?>
 "> <span class="editor-input-text"><?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['showName'];?>
</span></div>
						<script>
							$('#<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
').colorpicker({format: 'hex'});
							$('#<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
').colorpicker().on('changeColor', function(){
								  $('#<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
').css('background-color', $('#<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
').val());
								  updateLessAction();
							});				
						</script>
						<hr style="width:250px; margin-top:5px; margin-bottom:10px;">
					<?php } else { ?>
						<div class="input-box"><input type="text" id="<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['value'];?>
" class="editor-input"> <span class="editor-input-text"><?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['showName'];?>
</span></div>
						<div id="slider-<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
"></div>
						<script>
						  $(function() {
						    $( "#slider-<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
" ).slider({
						    	<?php if ($_smarty_tpl->tpl_vars['lessVariable']->value['type']=='bigsize') {?>
							      range: "min",
							      min: 0,
							      max: 1600,
							      step: 20,
							      value: <?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['valueNumeric'];?>
,
							      slide: function( event, ui ) {
									  $( "#<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
" ).attr('value',ui.value + 'px');
									  updateLessAction();
							      },
							      stop: function( event, ui ) {
							    	  updateLessAction();
							      }
							    <?php } elseif ($_smarty_tpl->tpl_vars['lessVariable']->value['type']=='smallsize') {?>  
							      range: "min",
							      min: 0,
							      max: 100,
							      value: <?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['valueNumeric'];?>
,
							      step: 2,
							      slide: function( event, ui ) {
									  $( "#<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
" ).attr('value',ui.value + 'px');
									  updateLessAction();
							      },
							      stop: function( event, ui ) {
							    	  updateLessAction();
							      }
							    <?php } elseif ($_smarty_tpl->tpl_vars['lessVariable']->value['type']=='normalsize') {?>  
							      range: "min",
							      min: 0,
							      max: 800,
							      value: <?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['valueNumeric'];?>
,
							      step: 10,
							      slide: function( event, ui ) {
									  $( "#<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
" ).attr('value',ui.value + 'px');
									  updateLessAction();
							      },
							      stop: function( event, ui ) {
							    	  updateLessAction();
							      }								      
							    <?php } elseif ($_smarty_tpl->tpl_vars['lessVariable']->value['type']=='fontsize') {?>  
							      range: "min",
							      min: 8,
							      max: 36,
							      value: <?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['valueNumeric'];?>
,
							      slide: function( event, ui ) {
									  $( "#<?php echo $_smarty_tpl->tpl_vars['lessVariable']->value['name'];?>
" ).attr('value',ui.value + 'px');
									  updateLessAction();
							      },
							      stop: function( event, ui ) {
							    	  updateLessAction();
							      }
							    <?php }?>
						    });
						  });
						</script>	
						<hr style="width:250px; margin-top:10px; margin-bottom:10px;">
					<?php }?>		
					
				<?php }
if (!$_smarty_tpl->tpl_vars['lessVariable']->_loop) {
?>
					Template nie obsługuje LESS
				<?php } ?>
				<div class="menu-left-alert"><?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.changessaved"),$_smarty_tpl);?>
</div>
				<a href="#" onclick="saveLessVariables();" class="btn btn-primary"><?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.save"),$_smarty_tpl);?>
</a>
				<a href="#" onclick="self.parent.location.reload()" class="btn"><?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.cancel"),$_smarty_tpl);?>
</a>
		      </div>
		    </div>
		  </div>
		  <?php }?>
		  <div class="accordion-group">
		    <div class="accordion-heading">
		      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix" onclick="setOpenMenu('6');">
		        <i class="fa fa-columns"></i><?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.subtheme"),$_smarty_tpl);?>

		      </a>
		    </div>
		    <div id="collapseSix" class="accordion-body collapse <?php if (cookie::read('openMenu')=='6') {?>in<?php }?>">
		      <div class="accordion-inner" style="padding-top:0px; padding-bottom:0px;">
				<?php  $_smarty_tpl->tpl_vars['template'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['template']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = themesDB::getViewsArray(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['template']->key => $_smarty_tpl->tpl_vars['template']->value) {
$_smarty_tpl->tpl_vars['template']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['template']->key;
?>
					<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/setPageTemplate/<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['page']->value->id;?>
/" class="<?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['page']->value->tpl) {?>green<?php }?> menu-themes" ><i class="fa fa-columns"> </i> <?php echo $_smarty_tpl->tpl_vars['template']->value;?>
</a>
				<?php } ?>
				
		      </div>
		    </div>
		  </div>
		  <div class="accordion-group">
		    <div class="accordion-heading">
		      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree" onclick="setOpenMenu('3');">
		        <i class="fa fa-globe"></i> <?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.template"),$_smarty_tpl);?>

		      </a>
		    </div>
		    <div id="collapseThree" class="accordion-body collapse <?php if (cookie::read('openMenu')=='3') {?>in<?php }?>">
		      <div class="accordion-inner" style="padding-top:0px; padding-bottom:0px;">
				<?php if (isset($_smarty_tpl->tpl_vars['themes'])) {$_smarty_tpl->tpl_vars['themes'] = clone $_smarty_tpl->tpl_vars['themes'];
$_smarty_tpl->tpl_vars['themes']->value = baseFile::getFilesList(@constant('TEMPLATES_PATH'),null,true); $_smarty_tpl->tpl_vars['themes']->nocache = true; $_smarty_tpl->tpl_vars['themes']->scope = 0;
} else $_smarty_tpl->tpl_vars['themes'] = new Smarty_variable(baseFile::getFilesList(@constant('TEMPLATES_PATH'),null,true), true, 0);?>
				<?php  $_smarty_tpl->tpl_vars['theme'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['theme']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['themes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->key => $_smarty_tpl->tpl_vars['theme']->value) {
$_smarty_tpl->tpl_vars['theme']->_loop = true;
?>
			   		<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/themes/setTempleteActiveReload/<?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
/" class="<?php if ($_smarty_tpl->tpl_vars['theme']->value->name==config::get('template')) {?>green<?php }?> menu-themes" ><i class="fa fa-th"></i> <?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
</a>
				<?php } ?>
				<a href="#" onclick="parent.location.href='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/themes/themes/'" title="Dodaj template" class="menu-themes"><i class="fa fa-plus-circle"></i> <?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.addtemplate"),$_smarty_tpl);?>
</a>
		      </div>
		    </div>
		  </div>

		  <div class="accordion-group">
		    <div class="accordion-heading">
		      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive" onclick="setOpenMenu('5');">
		        <i class="fa fa-question-circle"></i> <?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.halp"),$_smarty_tpl);?>

		      </a>
		    </div>
		    <div id="collapseFive" class="accordion-body collapse <?php if (cookie::read('openMenu')=='5') {?>in<?php }?>">
		      <div class="accordion-inner" style="padding-top:0px; padding-bottom:0px;">
		      	<a href="#" onclick="parent.location.href='http://www.windu.org/centrum-pomocy'"  class="menu-themes"><i class="fa fa-question-circle"></i> <?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.helpdep"),$_smarty_tpl);?>
</a>
		      	<a href="#" onclick="parent.location.href='http://www.forum.windu.org/'"  class="menu-themes"><i class="fa fa-question-circle"></i> <?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.forumwind"),$_smarty_tpl);?>
</a>
		      	<a href="#" onclick="parent.location.href='http://www.devboard.pl/'"  class="menu-themes"><i class="fa fa-question-circle"></i> <?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.webdevport"),$_smarty_tpl);?>
</a>
		      </div>
		    </div>
		  </div>  		    
		</div>
		<div class="circuleButtons pull-down">
			<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/toggleConfigParent/<?php echo $_smarty_tpl->tpl_vars['inPnaceEditorConfigName']->value;?>
/" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.editlvl"),$_smarty_tpl);?>
" class="<?php if (config::get($_smarty_tpl->tpl_vars['inPnaceEditorConfigName']->value)==1) {?>green<?php }?>"><i class="fa fa-pencil-square"></i></a>
			<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/toggleConfigParent/<?php echo $_smarty_tpl->tpl_vars['inPnaceWidgetsConfigName']->value;?>
/" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.showwdiget"),$_smarty_tpl);?>
" class="<?php if (config::get($_smarty_tpl->tpl_vars['inPnaceWidgetsConfigName']->value)==1) {?>green<?php }?>"><i class="fa fa-bullhorn"></i></a>
			<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/toggleConfigParent/<?php echo $_smarty_tpl->tpl_vars['inPnaceImagesConfigName']->value;?>
/" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.editimages"),$_smarty_tpl);?>
" class="<?php if (config::get($_smarty_tpl->tpl_vars['inPnaceImagesConfigName']->value)==1) {?>green<?php }?>"><i class="fa fa-picture-o"></i></a>
			<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/toggleConfigParent/cacheResources/" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.cacherec"),$_smarty_tpl);?>
" class="<?php if (config::get('cacheResources')==1) {?>green<?php }?>"><i class="fa fa-fighter-jet"></i></a>
			<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/toggleConfigParent/cache/" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.cachetemps"),$_smarty_tpl);?>
" class="<?php if (config::get('cache')==1) {?>green<?php }?>"><i class="fa fa-arrow-circle-up"></i></a>
			<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/toggleConfigParent/<?php echo $_smarty_tpl->tpl_vars['enableLeftMenuConfigName']->value;?>
/" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo smarty_function_L(array('key'=>"admin.frontedit.tpl.disableleftmenu"),$_smarty_tpl);?>
" class="<?php if (config::get($_smarty_tpl->tpl_vars['enableLeftMenuConfigName']->value)==1) {?>green<?php }?>"><i class="fa fa-align-justify"></i></a>
		</div>
	</body> 
</html>
<?php }} ?>
