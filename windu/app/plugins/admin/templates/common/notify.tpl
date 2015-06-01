<div class="tab-menu-top">
	<a href="{$HOME}admin/system/notifications/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	 <h3 class="pull-left tab-title"> {L key = "admin.main.tpl.notivications"}</h3>
	<a href="{$HOME}admin/do/system/cleanNotifications/" class="btn btn-small">{L key = "admin.common.conservation.tpl.systemcleaning"}</a>
	<a href="{$HOME}admin/do/system/cleanAllNotifications/" class="btn btn-small btn-warning">{L key = "admin.common.conservation.tpl.clearallnotifications"}</a>
</div>	
<div class="row-fluid">
	<div class="span2 mobileHidden">
		<div class="box pad margin-bottom align-center">
			{L key = "admin.system.tpl.notifications"}
			<h2>{count($notifications)}</h2>
		</div>
	</div>
	<div class="span10">
		<div class="box">{include file='common/notify_list.tpl'}</div>
		<div class="box margin-top">{include file='common/notify_closed_list.tpl'}</div>
	</div>
</div>
