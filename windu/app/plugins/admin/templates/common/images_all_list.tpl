<table class="table table-striped tablesort">
	<thead>
	<tr>
		<th>{L key = "admin.images_all_list.tpl.name"}</th>
		{if $extended}
			<th>{L key = "admin.images_all_list.tpl.type"}</th>
			<th>{L key = "admin.images_all_list.tpl.basket"}</th>
		{/if}
		<th>{L key = "admin.images_all_list.tpl.link"}</th>
		{if $extended}
			<th class="smallWidthHidden">{L key = "admin.images_all_list.tpl.created"}</th>
		{/if}
		<th>MB</th>
		{if $extended}
			<th>W</th>
			<th>H</th>
		{/if}
		<th></th>
	</tr>
	</thead>
  <tbody> 
  {if $showImagesLimit==''}{$showImagesLimit=11}{/if}	
  {foreach $imagesDB->fetchAll(null,'updateTime DESC','*',"{$page},{$pageCount}") as $img}
	<tr {if $img->id == $REQUEST->getVariable('id')}class="active"{/if}>
		<td>
			<img style="margin-top:-6px; margin-bottom:-4px;" src="{$HOME}image/{$img->ekey}/30/22/smart/"  data-toggle="tooltip" data-placement="left" data-original-title="<img style='height:150px; width:200px;' src='{$HOME}image/{$img->ekey}/200/150/smart/'>">
			{$img->name|truncate:20}
		</td>
		{if $extended}
			<td><span class="badge">{$img->type}</span></td>
			<td>{$img->bucket}</td>
		{/if}
		<td><a href="{$HOME}image/{$img->ekey}/{$img->width}/{$img->height}/original/" target="blank">{$img->ekey}</a></td>
		{if $extended}<td class="smallWidthHidden">{generate::showDatatime($img->createTime)}</td>{/if}
		<td>{round($img->size/(1024*1024),4)}</td>
		{if $extended}
			<td>{$img->width}</td>
			<td>{$img->height}</td>
		{/if}
		<td>
			<div class="buttons">
				<a href="{$HOME}admin/content/images/editImageAll/{$img->id}/?={$page}"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
			</div>
		</td>		
	</tr>
  {/foreach}  
  </tbody>
</table>

  
 