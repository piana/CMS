<table class="table table-striped tablesort">
<thead>
	<tr>
		<th>{L key = "admin.common.log_list.tpl.type"}</th>
		<th>{L key = "admin.common.log_list.tpl.info"}</th>
		{if $groupBy=='id'}<th>{L key = "admin.moderator.users.active.tpl.ipadress"}</th>{/if}		
		<th class="smallWidthHidden">{L key = "admin.common.log_list.tpl.date"}</th>
		<th>{L key = "admin.common.log_list.tpl.quant"}</th>
	</tr>
</thead>
  <tbody>
  {assign "cname" 'COUNT(data)'}

  {foreach $logDB->fetchCountGroup($groupBy,$whereDate) as $log}
	<tr>
		<td>
			<a href="{$HOME}admin/system/log/showLogs/{$log->bucket}/">
				{if $log->bucket == logDB::BUCKET_UPDATE}
					<span class="badge badge-info">{$log->bucket}</span>				
				{elseif $log->bucket == logDB::BUCKET_404}
					<span class="badge badge-warning">{$log->bucket}</span>
				{elseif $log->bucket == logDB::BUCKET_ERROR}
					<span class="badge badge-important">{$log->bucket}</span>	
				{elseif $log->bucket == logDB::BUCKET_LOGIN_ERROR}
					<span class="badge badge-inverse">{$log->bucket}</span>												
				{else}
					<span class="badge">{$log->bucket}</span>
				{/if}
			</a>
		</td>
		
		<td>
			<a href="{$HOME}admin/system/log/showLogsByError/{$log->id}/" data-toggle="tooltip" data-placement="left" data-original-title="{$log->data|escape:'html'|truncate:500}">{$log->data|strip_tags|truncate:70}</a>
		</td>
		{if $groupBy=='id'}<td>{$log->createIp}</td>{/if}
		<td class="smallWidthHidden" style="width:120px;">{generate::showDatatime($log->createTime)}</td>
		<td class="align-center">{$log->$cname}</td>
	</tr>
  {/foreach}   
  </tbody>
</table>
