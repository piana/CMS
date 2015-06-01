{if notifyDB::count(true)>0}
<table class="table table-striped tablesort" style="opacity:0.40;filter: alpha(opacity=40); -moz-opacity: 0.4;">
<thead>
	<tr>
		<th></th>
		<th>{L key = "admin.notify_closed.tpl.notificationinactive"}</th>
		<th>{L key = "admin.notify_closed.tpl.dateofadding"}</th>
		<th></th>
	</tr>
</thead>
<tbody>
  {foreach $notificationsClosed as $notify}
	<tr>
		<td>
			{if $notify->priority == notifyDB::STATUS_LIGHT}
				<span class="badge">{$notify->priority}</span>
			{elseif $notify->priority == notifyDB::STATUS_INFO}
				<span class="badge badge-info">{$notify->priority}</span>				
			{elseif $notify->priority == notifyDB::STATUS_WORNING}
				<span class="badge badge-warning">{$notify->priority}</span>
			{elseif $notify->priority == notifyDB::STATUS_DANGER}
				<span class="badge badge-important">{$notify->priority}</span>	
			{elseif $notify->priority == notifyDB::STATUS_ERROR}
				<span class="badge badge-inverse">{$notify->priority}</span>												
			{else}
				<span class="badge">{$notify->priority}</span>
			{/if}
		</td>
		<td>
			{L key=$notify->content}
		</td>
		<td>{generate::showDatatime($notify->insertTime)}</td>
		<td>
			<div class="buttons">
				<a href="{$HOME}admin/do/system/deleteNotify/{$notify->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
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