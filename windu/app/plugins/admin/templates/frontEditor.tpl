{{nocache}}
{{$adminUser = usersDB::getLoggedUser('AdminUser')}}
{{$adminUserId = $adminUser->id}}
{{$inPnaceEditorConfigName = "inPlaceEditor$adminUserId"}}
{{$inPnaceWidgetsConfigName = "showInPlaceWidgetsBox$adminUserId"}}
{{$inPnaceImagesConfigName = "showInPlaceImagesBox$adminUserId"}}
{{$enableLeftMenuConfigName = "showLeftEditor$adminUserId"}}

{{assign lessVariablesList less::getVariablesFromFile("$TEMPLATE_HOME/css_less/less.css")}}
{{assign bg config::get("backgroundAdmin$adminUserId")}}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="copyright" content="Copyright (c) WinduCMS">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        

		<link rel='stylesheet' href='{{$HOME}}app/resources/bootstrap/css/bootstrap.min.css'>
		<link rel='stylesheet' href='{{$HOME}}app/resources/bootstrap/css/bootstrap-colorpicker.css'>
		<link rel='stylesheet' href='{{$HOME}}app/plugins/admin/resources/css/bootstrap-extends.css'>
		<link rel="stylesheet" href="{{$HOME}}app/resources/css/font-awesome.min.css">
		<link rel='stylesheet' href='{{$HOME}}app/plugins/front/resources/css/editorFront.css'>
		
		<script type="text/javascript" src="{{$HOME}}app/resources/js/jquery.js"></script>
		<script type="text/javascript" src="{{$HOME}}app/resources/js/jquery.validate.js"></script>
		<script type="text/javascript" src="{{$HOME}}app/resources/js/jquery.cookie.js"></script>	
		<script type="text/javascript" src="{{$HOME}}app/resources/js/jquery-ui.js"></script>	
		
		<script type="text/javascript" src="{{$HOME}}app/resources/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="{{$HOME}}app/resources/bootstrap/js/bootstrap-colorpicker.js"></script>
		<script type="text/javascript" src="{{$HOME}}app/plugins/front/resources/js/frontEditor.js"></script>
					
		<script type="text/javascript">
			window.HOME = "{{$HOME}}";
			window.TEMPLATE = "{{config::get('template')}}";

			function updateLessAction(){
				parent.less.modifyVars({
					{{foreach $lessVariablesList as $lessVariable}}
						'@{{$lessVariable.name}}' : $('#{{$lessVariable.name}}').val(),	
					{{/foreach}}
				});
			}
			function saveLessVariables(){
				var finalVars = [];
				{{foreach $lessVariablesList as $lessVariable}}
				finalVars = finalVars+'@{{$lessVariable.name}}'+':'+$('#{{$lessVariable.name}}').val()+',';	
				{{/foreach}}
				var lessUrl = encodeURIComponent(encodeURIComponent('{{$TEMPLATE_HOME}}/css_less/less.css'));
				finalVars = encodeURIComponent(finalVars);
						
				$( '.menu-left-alert' ).load( '{{$HOME}}admin/mainDo/saveLessVariables/'+lessUrl+'/'+finalVars+'/', function() {
					$( ".menu-left-alert" ).slideDown("fast");
					$( ".menu-left-alert" ).delay(2000).slideUp("slow");
				});				 
			}	
			function setOpenMenu(id){	
				$.cookie('openMenu', id,{ path: '{{$smarty.const.SUBDIR}}'});
			}
			function setOpenConfigMenu(id){	
				$.cookie('openConfigMenu', id,{ path: '{{$smarty.const.SUBDIR}}'});
			}			
			$(document).ready(function(){
			    $('[data-toggle=tooltip]').tooltip({ html : true });
			    $('.tooltip-force').tooltip({ html : true });
			});	
					
		</script>	
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<title>{{L key = "admin.frontedit.tpl.frontedit"}}</title>
	</head>
	<body id="adminMenuLeft" style="verflow-x:hidden; background-color: #{{if $bg!=null}}{{$bg}}{{/if}};">
		<div class="circuleButtons">
			<a href="#" onclick="parent.location.href='{{$HOME}}admin/content/pages/edit/{{$page->id}}/'"  data-toggle="tooltip" data-placement="bottom" data-original-title="{{L key = "admin.frontedit.tpl.edit"}}"><i class="fa fa-pencil"></i></a>
			<a href="#" onclick="parent.location.href='{{$HOME}}admin/themes/themes/edit/{{themesDB::getThemeName()}}/tpl_views/tpl_views/{{$page->tpl}}/'" data-toggle="tooltip" data-placement="bottom" data-original-title="{{L key = "admin.frontedit.tpl.edittemplate"}}"><i class="fa fa-pencil-square"></i></a>
			<a href="#" onclick="parent.location.href='{{$HOME}}admin/themes/themes/edit/{{themesDB::getThemeName()}}/css/css/main.css/'"  data-toggle="tooltip" data-placement="bottom" data-original-title="{{L key = "admin.frontedit.tpl.editcss"}}"><i class="fa fa-list-alt"></i></a>
			<a href="{{$HOME}}admin/do/content/toggleHideParent/{{$page->id}}/" title="{{L key = "admin.frontedit.tpl.hide"}}" class="{{if $page->status==2}}red{{else}}green{{/if}}" data-toggle="tooltip" data-placement="bottom" data-original-title="{{L key = "admin.frontedit.tpl.set"}}"><i class=" fa fa-eye"></i></a>
			
			<a href="{{$HOME}}admin/do/flushCacheFront/" data-toggle="tooltip" data-placement="bottom" data-original-title="{{L key = "admin.frontedit.tpl.clearcache"}}" class="orange"><i class="fa fa-repeat"></i></a>
			<a href="#" onclick="parent.location.href='{{$HOME}}admin/login/logoutFront/'"  data-toggle="tooltip" data-placement="bottom" data-original-title="{{L key = "admin.frontedit.tpl.logout"}}" class="red"><i class=" fa fa-lock"></i></a>
		</div>     
	
		</div>
		<div class="accordion" id="accordion2">
		  {{if count($lessVariablesList)>0}}
		  <div class="accordion-group">
		    <div class="accordion-heading">
		      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" onclick="setOpenMenu('1');">
		        <i class="fa fa-desktop"></i> {{L key = "admin.frontedit.tpl.color"}}
		      </a>
		    </div>
		    <div id="collapseOne" class="acc ordion-body collapse {{if cookie::read('openMenu')=='1'}}in{{/if}}">
		      <div class="accordion-inner">
				{{foreach $lessVariablesList as $lessVariable}}
					{{if $lessVariable.type == 'color'}}
						<div class="input-box"><input type="text" class="editor-input" value="{{$lessVariable.value}}" id="{{$lessVariable.name}}" data-color-format="rgb" style="background-color:{{$lessVariable.value}} "> <span class="editor-input-text">{{$lessVariable.showName}}</span></div>
						<script>
							$('#{{$lessVariable.name}}').colorpicker({format: 'hex'});
							$('#{{$lessVariable.name}}').colorpicker().on('changeColor', function(){
								  $('#{{$lessVariable.name}}').css('background-color', $('#{{$lessVariable.name}}').val());
								  updateLessAction();
							});				
						</script>
						<hr style="width:250px; margin-top:5px; margin-bottom:10px;">
					{{else}}
						<div class="input-box"><input type="text" id="{{$lessVariable.name}}" value="{{$lessVariable.value}}" class="editor-input"> <span class="editor-input-text">{{$lessVariable.showName}}</span></div>
						<div id="slider-{{$lessVariable.name}}"></div>
						<script>
						  $(function() {
						    $( "#slider-{{$lessVariable.name}}" ).slider({
						    	{{if $lessVariable.type == 'bigsize'}}
							      range: "min",
							      min: 0,
							      max: 1600,
							      step: 20,
							      value: {{$lessVariable.valueNumeric}},
							      slide: function( event, ui ) {
									  $( "#{{$lessVariable.name}}" ).attr('value',ui.value + 'px');
									  updateLessAction();
							      },
							      stop: function( event, ui ) {
							    	  updateLessAction();
							      }
							    {{elseif $lessVariable.type == 'smallsize'}}  
							      range: "min",
							      min: 0,
							      max: 100,
							      value: {{$lessVariable.valueNumeric}},
							      step: 2,
							      slide: function( event, ui ) {
									  $( "#{{$lessVariable.name}}" ).attr('value',ui.value + 'px');
									  updateLessAction();
							      },
							      stop: function( event, ui ) {
							    	  updateLessAction();
							      }
							    {{elseif $lessVariable.type == 'normalsize'}}  
							      range: "min",
							      min: 0,
							      max: 800,
							      value: {{$lessVariable.valueNumeric}},
							      step: 10,
							      slide: function( event, ui ) {
									  $( "#{{$lessVariable.name}}" ).attr('value',ui.value + 'px');
									  updateLessAction();
							      },
							      stop: function( event, ui ) {
							    	  updateLessAction();
							      }								      
							    {{elseif $lessVariable.type == 'fontsize'}}  
							      range: "min",
							      min: 8,
							      max: 36,
							      value: {{$lessVariable.valueNumeric}},
							      slide: function( event, ui ) {
									  $( "#{{$lessVariable.name}}" ).attr('value',ui.value + 'px');
									  updateLessAction();
							      },
							      stop: function( event, ui ) {
							    	  updateLessAction();
							      }
							    {{/if}}
						    });
						  });
						</script>	
						<hr style="width:250px; margin-top:10px; margin-bottom:10px;">
					{{/if}}		
					
				{{foreachelse}}
					Template nie obsługuje LESS
				{{/foreach}}
				<div class="menu-left-alert">{{L key = "admin.frontedit.tpl.changessaved"}}</div>
				<a href="#" onclick="saveLessVariables();" class="btn btn-primary">{{L key = "admin.frontedit.tpl.save"}}</a>
				<a href="#" onclick="self.parent.location.reload()" class="btn">{{L key = "admin.frontedit.tpl.cancel"}}</a>
		      </div>
		    </div>
		  </div>
		  {{/if}}
		  <div class="accordion-group">
		    <div class="accordion-heading">
		      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix" onclick="setOpenMenu('6');">
		        <i class="fa fa-columns"></i>{{L key = "admin.frontedit.tpl.subtheme"}}
		      </a>
		    </div>
		    <div id="collapseSix" class="accordion-body collapse {{if cookie::read('openMenu')=='6'}}in{{/if}}">
		      <div class="accordion-inner" style="padding-top:0px; padding-bottom:0px;">
				{{foreach themesDB::getViewsArray() as $key => $template}}
					<a href="{{$HOME}}admin/mainDo/setPageTemplate/{{$key}}/{{$page->id}}/" class="{{if $key == $page->tpl}}green{{/if}} menu-themes" ><i class="fa fa-columns"> </i> {{$template}}</a>
				{{/foreach}}
				
		      </div>
		    </div>
		  </div>
		  <div class="accordion-group">
		    <div class="accordion-heading">
		      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree" onclick="setOpenMenu('3');">
		        <i class="fa fa-globe"></i> {{L key = "admin.frontedit.tpl.template"}}
		      </a>
		    </div>
		    <div id="collapseThree" class="accordion-body collapse {{if cookie::read('openMenu')=='3'}}in{{/if}}">
		      <div class="accordion-inner" style="padding-top:0px; padding-bottom:0px;">
				{{$themes = baseFile::getFilesList($smarty.const.TEMPLATES_PATH,null,true)}}
				{{foreach $themes as $theme}}
			   		<a href="{{$HOME}}admin/do/themes/setTempleteActiveReload/{{$theme->name}}/" class="{{if $theme->name == config::get(template)}}green{{/if}} menu-themes" ><i class="fa fa-th"></i> {{$theme->name}}</a>
				{{/foreach}}
				<a href="#" onclick="parent.location.href='{{$HOME}}admin/themes/themes/'" title="Dodaj template" class="menu-themes"><i class="fa fa-plus-circle"></i> {{L key = "admin.frontedit.tpl.addtemplate"}}</a>
		      </div>
		    </div>
		  </div>

		  <div class="accordion-group">
		    <div class="accordion-heading">
		      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive" onclick="setOpenMenu('5');">
		        <i class="fa fa-question-circle"></i> {{L key = "admin.frontedit.tpl.halp"}}
		      </a>
		    </div>
		    <div id="collapseFive" class="accordion-body collapse {{if cookie::read('openMenu')=='5'}}in{{/if}}">
		      <div class="accordion-inner" style="padding-top:0px; padding-bottom:0px;">
		      	<a href="#" onclick="parent.location.href='http://www.windu.org/centrum-pomocy'"  class="menu-themes"><i class="fa fa-question-circle"></i> {{L key = "admin.frontedit.tpl.helpdep"}}</a>
		      	<a href="#" onclick="parent.location.href='http://www.forum.windu.org/'"  class="menu-themes"><i class="fa fa-question-circle"></i> {{L key = "admin.frontedit.tpl.forumwind"}}</a>
		      	<a href="#" onclick="parent.location.href='http://www.devboard.pl/'"  class="menu-themes"><i class="fa fa-question-circle"></i> {{L key = "admin.frontedit.tpl.webdevport"}}</a>
		      </div>
		    </div>
		  </div>  		    
		</div>
		<div class="circuleButtons pull-down">
			<a href="{{$HOME}}admin/mainDo/toggleConfigParent/{{$inPnaceEditorConfigName}}/" data-toggle="tooltip" data-placement="top" data-original-title="{{L key = "admin.frontedit.tpl.editlvl"}}" class="{{if config::get($inPnaceEditorConfigName)==1}}green{{/if}}"><i class="fa fa-pencil-square"></i></a>
			<a href="{{$HOME}}admin/mainDo/toggleConfigParent/{{$inPnaceWidgetsConfigName}}/" data-toggle="tooltip" data-placement="top" data-original-title="{{L key = "admin.frontedit.tpl.showwdiget"}}" class="{{if config::get($inPnaceWidgetsConfigName)==1}}green{{/if}}"><i class="fa fa-bullhorn"></i></a>
			<a href="{{$HOME}}admin/mainDo/toggleConfigParent/{{$inPnaceImagesConfigName}}/" data-toggle="tooltip" data-placement="top" data-original-title="{{L key = "admin.frontedit.tpl.editimages"}}" class="{{if config::get($inPnaceImagesConfigName)==1}}green{{/if}}"><i class="fa fa-picture-o"></i></a>
			<a href="{{$HOME}}admin/mainDo/toggleConfigParent/cacheResources/" data-toggle="tooltip" data-placement="top" data-original-title="{{L key = "admin.frontedit.tpl.cacherec"}}" class="{{if config::get('cacheResources')==1}}green{{/if}}"><i class="fa fa-fighter-jet"></i></a>
			<a href="{{$HOME}}admin/mainDo/toggleConfigParent/cache/" data-toggle="tooltip" data-placement="top" data-original-title="{{L key = "admin.frontedit.tpl.cachetemps"}}" class="{{if config::get('cache')==1}}green{{/if}}"><i class="fa fa-arrow-circle-up"></i></a>
			<a href="{{$HOME}}admin/mainDo/toggleConfigParent/{{$enableLeftMenuConfigName}}/" data-toggle="tooltip" data-placement="top" data-original-title="{{L key = "admin.frontedit.tpl.disableleftmenu"}}" class="{{if config::get($enableLeftMenuConfigName)==1}}green{{/if}}"><i class="fa fa-align-justify"></i></a>
		</div>
	</body> 
</html>
{{/nocache}}