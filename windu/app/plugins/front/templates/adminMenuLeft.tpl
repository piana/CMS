{{nocache}}
	<div id="imagesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">{{L key = "admin.menu.left.tpl.image"}}</h3>
		</div>
		<div class="modal-body">
			<iframe src="{{$HOME}}admin/ajax/images/modalUploader/{{$page->id}}/"></iframe>
		</div>
	</div>	
	<div id="widgetsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">{{L key = "admin.menu.left.tpl.widget"}}</h3>
		</div>
		<div class="modal-body">
			<iframe src="{{$HOME}}admin/ajax/widgets/choseWidget/"></iframe>
		</div>
	</div>	
	<div id="filesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">{{L key = "admin.menu.left.tpl.file"}}</h3>
		</div>
		<div class="modal-body">
			<iframe src="{{$HOME}}admin/ajax/files/modalUploader/{{$page->id}}/"></iframe>
		</div>
	</div>	
	<div id="adminMenuLeft-container" style="{{if cookie::readCookie('hideLeftMenu')==1}}display:none;{{/if}}">
		<iframe src="{{$HOME}}admin/frontEditor/show/{{$page->id}}/" style="width: 250px; height:100%; border:0px;"></iframe>
	</div>
	{{$loggedIn = usersDB::getLoggedIn('AdminUser')}}
	{{assign bg config::get("backgroundAdmin{{$loggedIn->id}}")}}
	<a href="#" title="Ukryj menu" id="toggleLeftMenuButton" onclick="toggleLeftMenu()" class="hideLeftMenuButton" style="verflow-x:hidden; background-image: url('{{$HOME}}app/plugins/admin/resources/img/{{if $bg!=null}}{{$bg}}{{else}}bgcolor2.jpg{{/if}}'); z-index:998; {{if cookie::readCookie('hideLeftMenu')=='1'}}left:0px;{{/if}}">{{if cookie::readCookie('hideLeftMenu')==1}}›{{else}}‹{{/if}}</a>
	{{if cookie::readCookie('hideLeftMenu')==1}}
		<script>
			$('body').css( "padding-left" , "0px");
		</script>
	{{/if}}
{{/nocache}}