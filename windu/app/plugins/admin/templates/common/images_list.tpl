<ul class="sortable list-bg {if cookie::readCookie(sortableOn)}sortable-cursor{/if}" {if cookie::readCookie(sortableOn)}id="sortableTreeListGallery"{/if}>
{if $parentId != null}
	{$images = $imagesDB->getByBucket($parentId)}
{/if}
{foreach $images as $img}
	<li id="image-item-id-{$img->id}" class="gallery-image-box no-nest {cycle values='odd,even'} {if $image->id == $img->id}active{/if}">
		<div>
			<img style="margin-top:-6px; margin-bottom:-4px;" src="{$HOME}image/{$img->ekey}/30/22/smart/" data-toggle="tooltip" data-placement="left" data-original-title="<img style='height:150px; width:200px;' src='{$HOME}image/{$img->ekey}/200/150/smart/'>">
			{if $small}{$img->name|truncate:10}{else}{$img->name|truncate:30}{/if}
			<div class="buttons buttons-two">
				<a href="{$HOME}admin/content/pages/editImage/{$img->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
				<span onclick="loadDoActionDelete('{$HOME}admin/do/content/deleteImageAjax/{$img->id}/{$REQUEST->getVariable('id')}/','#image-item-id-{$img->id}',{if !usersDB::isDeveloper()}1{else}0{/if})"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
			</div>
		</div>
	</li>
{/foreach}	  	
</ul>