<table class="table table-striped tablesort">
	<thead>
	<tr>
		<th>{L key = "admin.common.files_list.ctpl.name"}</th>
		{if $extended}
			<th>{L key = "admin.common.files_list.ctpl.type"}</th>
			<th>{L key = "admin.common.files_list.ctpl.link"}</th>
			<th>{L key = "admin.common.files_list.ctpl.downloads"}</th>
			<th class="smallWidthHidden">{L key = "admin.common.files_list.ctpl.added"}</th>
			<th>{L key = "admin.common.files_list.ctpl.size"}</th>
		{/if}	
		<th></th>
	</tr>
	</thead>
  <tbody> 
  {if $showFilesLimit==''}{$showFilesLimit=11}{/if}	
  {foreach $filesDB->fetchAll(null,'updateTime DESC','*',"{$page},{$pageCount}") as $file}
	<tr {if $file->id == $REQUEST->getVariable('id')}class="active"{/if} id="file-{$file->id}">
		<td><i class="color-icons icons-box icon-margin">&nbsp;</i>{$file->name|truncate:20}</td>
		{if $extended}	
			<td><span class="badge">{$file->type}</span></td>
			<td>{$HOME}file/original/{$file->ekey}/</td>
			<td><span class="badge badge-info">{$filesLogDB->getDownloads($file->id)}</span></td>
			<td class="smallWidthHidden">{generate::showDatatime($file->createTime)}</td>
			<td>{round($file->size/(1024*1024),4)}</td>
		{/if}
		<td>
			<div class="buttons">
				<a href="{$HOME}admin/content/files/editFile/{$file->id}/?p={$page/$pageCount}"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
				<span onclick="loadDoActionDelete('{$HOME}admin/do/tools/deleteFileAjax/{$file->id}/','#file-{$file->id}',{if !usersDB::isDeveloper()}1{else}0{/if})"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
			</div>
		</td>
	</tr>
  {/foreach}   
  </tbody>
</table>
 