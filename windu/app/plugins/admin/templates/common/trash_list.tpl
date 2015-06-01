<table class="table table-striped">
  <tbody>
  {foreach $pagesDB->fetchAll("status=0",'updateTime ASC','*') as $page}
	<tr onmouseover="putContentInToDiv('#trashPreview','{$page->content|escape:'url'}')" id="trash-{$page->id}">
		<td>{include file='common/content_list_icon.tpl' type=$page->type name=$page->name}{$page->name|truncate:20}</td>
		<td class="smallWidthHidden">{generate::showDatatime($page->updateTime)}</td>
		<td>
			<div class="buttons">
				<a href="{$HOME}admin/do/trash/restore/{$page->id}/"><i class="fa fa-upload icon-blue">&nbsp;</i></a>
				<span onclick="loadDoActionDelete('{$HOME}admin/do/trash/delete/{$page->id}/','#trash-{$page->id}',{if !usersDB::isDeveloper()}1{else}0{/if})"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
			</div>
		</td>
	</tr>
  {/foreach}   
  </tbody>
</table>