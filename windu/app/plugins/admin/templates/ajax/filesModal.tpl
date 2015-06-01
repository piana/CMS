{include file='common/files_multiuploader.tpl' bucket=$REQUEST->getVariable('id')}

<table class="table table-striped tablesort">
	<thead>
	<tr>
		<th>{L key = "admin.filesmodal.tpl.name"}</th>
		<th>{L key = "admin.filesmodal.tpl.size"}</th>
		<th></th>
	</tr>
	</thead>
  <tbody> 
  {foreach $files as $file}
	<tr {if $file->id == $REQUEST->getVariable('id')}class="active"{/if}>
		<td><i class="color-icons icons-box icon-margin">&nbsp;</i>{$file->name}</td>
		<td>{round($file->size/1024,0)}</td>
		<td class="align-right">
			{if $REQUEST->getVariable('id')!='main'}
				<a href="#" class="label label-inverse" onclick="parent.editorInsertText('<a href={$HOME}file/original/{$file->ekey}/>{$file->name}</a>'); parent.$('#filesModal').modal('hide');">Link Statyczny</a>
				<a href="#" class="label label-info" onclick="parent.editorInsertText('<a href={$HOME}filetemp/{literal}{{fileTempController::getTempKey{/literal}({$file->ekey}){literal}}}{/literal}/>{$file->name}</a>'); parent.$('#filesModal').modal('hide');">Link Dynamiczny</a>
			{/if}	
				<a href="{$HOME}admin/do/tools/deleteFile/{$file->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
			
		</td>
	</tr>
  {/foreach}   
  </tbody>
</table>
 
