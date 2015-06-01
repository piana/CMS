				{if notifyDB::count()>0}
				<table class="table table-striped tablesort">
				  <tbody>
				  {foreach $notifications as $notify}
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
						<td>
							<div class="buttons" style="width:25px;">
								<a href="{$HOME}admin/do/system/closeNotify/{$notify->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
							</div>
						</td>
					</tr>
				  {/foreach}   
				  </tbody>
				</table>
				{/if}