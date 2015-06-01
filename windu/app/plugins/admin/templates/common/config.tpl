<div class="tab-menu-top">
	<a href="{$HOME}admin/{$class}/config/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
	<h3 class="pull-left tab-title"> {L key = "admin.menu.config"}</h3>
</div>
<div class="row-fluid">
	{if is_object($formConfig)}
	<div class="span7 box">
		{include file='common/config_list.tpl' list=$configList class=$class}
	</div>
	<div class="span5">
		<div class="box-floating">
			<div class="box">
				<h5><i class="fa fa-pencil icon-margin icon-grey"></i> {L key = "admin.users.tpl.edit"}</h5>
				{$formConfig->toHtml()}
			</div>
		</div>
	</div>
	{else}
	<div class="span12 box">
		{include file='common/config_list.tpl' list=$configList class=$class extended=1}
	</div>
	{/if}
</div>
