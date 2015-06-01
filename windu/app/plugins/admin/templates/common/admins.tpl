<div class="tab-menu-top">
 <a href="{$HOME}admin/users/admins/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
 <h3 class="pull-left tab-title"> {L key = "admin.users.ctpl.admins"}</h3>
 <a href="{$HOME}admin/users/admins/" class="btn btn-small pull-right">{L key = "admin.users.tpl.adduser"}</a>
</div> 
<div class="row-fluid">
	<div class="span6">
		<div class="box">
			{include file='common/users_system_list.tpl'}
		</div>
	</div>
	<div class="span6">
		<div class="box-floating box">
			<h5><i class="fa fa-user icon-margin icon-grey"></i> {L key = "admin.users.tpl.adduser"}</h5>
			{$userSystem->toHtml()}
		</div>
	</div>
</div>
