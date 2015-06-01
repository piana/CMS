{if license::hasPro()}
	<div class="tab-menu-top">
		<a href="{$HOME}admin/users/authorization/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
		<h3 class="pull-left tab-title"> {L key = "admin.users.ctpl.authorization"}</h3>
		<a href="{$HOME}admin/users/authorization/" class="btn btn-small pull-right">{L key = "admin.users.tpl.addtypeofauthpanels"}</a>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="box">
				{include file='common/users_types_list.tpl'}
			</div>
		</div>
		<div class="span6">
			<div class="box-floating box">
				{if is_object($userTypePanels)}
				<h5><i class="fa fa-user icon-margin icon-grey"></i> {L key = "admin.users.tpl.addtypeofauthpanels"}</h5>
				<div class="multiCheckbox">
					{$userTypePanels->toHtml()}
				</div>
				{else}
				<h5><i class="fa fa-user icon-margin icon-grey"></i> {L key = "admin.users.tpl.addtypeofauthpanels"}</h5>
				{$userType->toHtml()}
				{/if}
			</div>
		</div>
	</div>
{else}
	{include file='common/goPro.tpl'}
{/if} 