{if notifyDB::count()>0}
<table class="table table-striped tablesort">
<thead>
	<tr>
		<th>{L key = "admin.notify_list.tpl.type"}</th>
		<th>{L key = "admin.notify_list.tpl.notification"}</th>
		{if $simple==null}<th>{L key = "admin.notify_list.tpl.dateofading"}</th>{/if}
		<th></th>
	</tr>
</thead>
  <tbody>
  {foreach $notifications as $notify}
	<tr>
		<td class="align-right">
			{if $notify->priority == notifyDB::STATUS_LIGHT}
				<span class="badge">info</span>
			{elseif $notify->priority == notifyDB::STATUS_INFO}
				<span class="badge badge-info">info</span>
			{elseif $notify->priority == notifyDB::STATUS_WORNING}
				<span class="badge badge-warning">warning</span>
			{elseif $notify->priority == notifyDB::STATUS_DANGER}
				<span class="badge badge-important">danger</span>
			{elseif $notify->priority == notifyDB::STATUS_ERROR}
				<span class="badge badge-inverse">error</span>
			{else}
				<span class="badge">{$notify->priority}</span>
			{/if}
		</td>
		<td>
			{if $notify->url!=null}
				<a href="{$HOME}{$notify->url}">{L key=$notify->content}</a>
			{else}
				{L key=$notify->content}
			{/if}
		</td>
		{if $simple==null}<td>{generate::showDatatime($notify->insertTime)}</td>{/if}
		<td>
			<div class="buttons" style="width:22px;">
				<a href="{$HOME}admin/do/system/closeNotify/{$notify->id}/"><i class="fa fa-check-circle icon-blue">&nbsp;</i></a>
			</div>
		</td>
	</tr>
  {/foreach}   
  </tbody>
</table>
{else}
	<div class="pad">
		{L key="admin.system.tpl.noelements"}
	</div>
{/if}