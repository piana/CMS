{include file='common/images_multiuploader.tpl'}
<div class="images-box-modal">
{foreach $images as $img}
	<div class="image-box-modal">
		<img src="{$HOME}image/{$img->ekey}/170/100/smart/" style="width: 100%;"><br>
		<a href="#" class="label" onclick="parent.editorInsertText('<img src={$HOME}image/{$img->ekey}/270/180/fit/ alt=\'{$img->name}\'>'); parent.$('#imagesModal').modal('hide');" ><i class="fa fa-picture-o  icon-margin"></i>S</a>
		<a href="#" class="label" onclick="parent.editorInsertText('<a href=\'{$HOME}image/{$img->ekey}/940/626/original/\' target=\'_blank\'><img src={$HOME}image/{$img->ekey}/270/180/fit/ alt=\'{$img->name}\'></a>'); parent.$('#imagesModal').modal('hide');"><i class="fa fa-search-plus  icon-margin"></i>S</a>

		<a href="#" class="label label-warning" onclick="parent.editorInsertText('<img src={$HOME}image/{$img->ekey}/540/360/fit/ alt=\'{$img->name}\'>'); parent.$('#imagesModal').modal('hide');"><i class="fa fa-picture-o  icon-margin"></i>M</a>
		<a href="#" class="label label-warning" onclick="parent.editorInsertText('<a href=\'{$HOME}image/{$img->ekey}/940/626/original/\' target=\'_blank\'><img src={$HOME}image/{$img->ekey}/540/360/fit/ alt=\'{$img->name}\'></a>'); parent.$('#imagesModal').modal('hide');"><i class="fa fa-search-plus  icon-margin"></i>M</a>
		
		<a href="#" class="label label-important" onclick="parent.editorInsertText('<img src={$HOME}image/{$img->ekey}/940/626/fit/ alt=\'{$img->name}\'>'); parent.$('#imagesModal').modal('hide');"><i class="fa fa-picture-o  icon-margin"></i>L</a>
		<a href="#" class="label label-important" onclick="parent.editorInsertText('<a href=\'{$HOME}image/{$img->ekey}/940/626/original/\' target=\'_blank\'><img src={$HOME}image/{$img->ekey}/940/626/fit/ alt=\'{$img->name}\'></a>'); parent.$('#imagesModal').modal('hide');"><i class="fa fa-search-plus  icon-margin"></i>L</a>
		
		<a href="#" class="label label-inverse" onclick="parent.editorInsertText('<img src={$HOME}image/{$img->ekey}/940/626/original/ alt=\'{$img->name}\'>'); parent.$('#imagesModal').modal('hide');"><i class="fa fa-picture-o  icon-margin"></i>O</a>

		<a href="{$HOME}admin/do/content/deleteImage/{$img->id}/" class="deleteImage"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
	</div>
{/foreach}				
</div>
