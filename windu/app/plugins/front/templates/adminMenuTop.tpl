{{nocache}}
<div class="adminMenuTop-container" style="{{if cookie::readCookie(hideLeftMenu)==1}}padding-left:0px;{{/if}}">
	<div id="adminMenuTop" class="{{if cookie::readCookie(hideTopMenu)==1}}hideTopMenu{{/if}} {{if cookie::readCookie(hideLeftMenu)==1}}margin-right:0px;{{/if}}">
		<a href="#" title="Ukryj menu" id="toggleTopMenuButton" onclick="toggleTopMenu()" style="z-index:99999"><i class=" icon-arrow-left "></i></a>
		<a href="#" title="Templaty" id="showTemplatesButton" onclick="toggleTemplateMenu()" class=" {{if cookie::readCookie('showTemplatesOpen')==1}}green{{/if}}"><i class=" fa fa-arrow-down "></i></a>
			
		<a href="{{$HOME}}admin/" style="padding:0px; margin-top:-1px;"><img src="{{$HOME}}app/plugins/admin/resources/img/logo-icon-small.png" title="Windu CMS"></a>
	
		<a href="{{$HOME}}admin/content/pages/edit/{{$page->id}}/" title="Edytuj podstronę w panelu admina"><i class="fa fa-pencil "></i></a>
		<a href="{{$HOME}}admin/themes/edit/{{themesDB::getThemeName()}}/tpl_views/tpl_views/{{$page->tpl}}/" title="Edytuj template w panelu admina"><i class="fa fa-pencil-square "></i></a>
		<a href="{{$HOME}}admin/themes/edit/{{themesDB::getThemeName()}}/css/css/main.css/" title="Edytuj CSSy"><i class="fa fa-list-alt "></i></a>
		
			
		<a href="{{$HOME}}admin/tools/tools/" title="Narzędzia"><i class="fa fa-wrench "></i> Narzędzia</a>
		<a href="{{$HOME}}admin/config/" title="Ustawienia"><i class="icon-cog "></i> Ustawienia</a>
		<a href="{{$HOME}}admin/system/system/" title="System"><i class="icon-heart "></i> System</a>
		<div class="adminMenuTop-right">
			<a href="{{$HOME}}admin/mainDo/toggleConfig/inPlaceEditor/" title="Edycja z poziomu przeglądarki" class="{{if config::get('inPlaceEditor')==1}}green{{else}}silver{{/if}}"><i class="fa fa-map-marker "></i></a>
			<a href="{{$HOME}}admin/mainDo/toggleConfig/showInPlaceWidgetsBox/" title="Pokazuje umiejscowienie widgetów" class="{{if config::get('showInPlaceWidgetsBox')==1}}green{{else}}silver{{/if}}"><i class="fa fa-bullhorn "></i></a>
			
			<a href="{{$HOME}}admin/mainDo/toggleConfig/cacheResources/" title="Cache resources" class="{{if config::get('cacheResources')==1}}green{{else}}silver{{/if}}"><i class="icon-upload "></i></a>
			<a href="{{$HOME}}admin/mainDo/toggleConfig/cache/" title="Cache templates" class="{{if config::get('cache')==1}}green{{else}}silver{{/if}}"><i class="fa fa-arrow-circle-up "></i></a>
			<a href="{{$HOME}}admin/do/flushCache/" title="Czyść cache" class="orange"><i class="fa fa-repeat "></i></a>
		
			<a href="http://windu.org/centrum-pomocy"><i class="fa fa-question-circle "></i> Pomoc</a>
			<a href="http://forum.windu.org/"><i class="icon-comment "></i> Forum</a>
			<a href="{{$HOME}}admin/login/logout/"><i class="fa fa-lock "></i> Wyloguj</a>
		</div>
		<div class="adminMenuTop-templates {{if cookie::readCookie('showTemplatesOpen')==1}}showTemplatesMenu{{/if}}">
			{{$themes = baseFile::getFilesList($smarty.const.TEMPLATES_PATH,null,true)}}
			{{foreach $themes as $theme}}
		   		<a href="{{$HOME}}admin/do/themes/setTempleteActive/{{$theme->name}}/" class="{{if $theme->name == config::get(template)}}green{{/if}}"><i class="fa fa-globe "></i> {{$theme->name}}</a>
			{{/foreach}}
			<a href="{{$HOME}}admin/themes/themes/" title="Dodaj template"><i class="fa fa-plus-circle "></i></a>
		</div>
		
	</div>
	<a href="#" title="Ukryj menu" id="toggleTopMenuButton" onclick="toggleTopMenu()" class="hideTopMenuButton" style="z-index:99998;  {{if cookie::readCookie(hideLeftMenu)==1}}left:0px;{{else}}left:250px;{{/if}}"><i class=" icon-arrow-right "></i></a>
</div>
{{/nocache}}