{include file='common/image_generator_modal.tpl' imageEkey=$image->ekey}
<div class="pad align-center">
	<img src='{$HOME}image/{$image->ekey}/200/150/fit/'><br><br>
	<a href="#modal" class="btn btn-margin-left" data-toggle="modal" data-target="#imageGeneratorModal"><i class="fa fa-picture-o icon-button"></i>{L key = "admin.images.editor.tpl.prep"}</a>
</div>