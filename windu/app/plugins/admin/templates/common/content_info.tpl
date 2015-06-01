{$waitingPages = $pagesDB->fetchAll("date>'{$now}'",'date ASC','*')}
{$editedPages = $pagesDB->fetchAll(null,'updateTime DESC','*',16)}
<div class="row-fluid mobileHidden">
	<div class="span{if count($waitingPages)>0}6{else}12{/if}">
		<div class="box">
			<h5><i class="fa fa-clock-o icon-margin icon-grey">&nbsp;</i>{L key="admin.content_info.controller.lastedited"}</h5>
			<table class="table table-striped">
			  <tbody>
			  {foreach $editedPages as $page}
				<tr>
					<td>{include file='common/content_list_icon.tpl' type=$page->type  name=$page->name}{$page->name|truncate:25}</td>
					<td class="smallWidthHidden">{generate::showDatatime($page->updateTime)}</td>
					<td>
						<div class="buttons">
							<a href="{$HOME}admin/do/content/goEdit/{$page->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
						</div>
					</td>
				</tr>
			  {/foreach}   
			  </tbody>
			</table>
		</div>		
	</div>	
	{if count($waitingPages)>0}
		<div class="span6">
			<div class="box">
				<h5><i class="fa fa-calendar icon-margin icon-grey">&nbsp;</i>{L key="admin.content_info.controller.awaiting"}</h5>
				<table class="table table-striped">
				  <tbody>
				  {foreach $waitingPages as $page}
					<tr>
						<td>{include file='common/content_list_icon.tpl' type=$page->type id=$page->id}{$page->name|truncate:25}</td>
						<td class="smallWidthHidden">{generate::showDatatime($page->date)}</td>
						<td>
							<div class="buttons">
								<a href="{$HOME}admin/do/content/goEdit/{$page->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
							</div>
						</td>
					</tr>
				  {foreachelse}
				  	<tr><td>{L key = "admin.lang.tpl.nodata"}</td></tr>	
				  {/foreach}   
				  </tbody>
				</table>
			</div>  	
		</div>
	{/if}
</div>
