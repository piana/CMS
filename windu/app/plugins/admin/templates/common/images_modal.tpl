<div id="imagesModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">{L key = "admin.content.common.tpl.addimages"}</h3>
	</div>
	<div class="modal-body">
		<iframe src="{$HOME}admin/ajax/images/modalUploader/{$REQUEST->getVariable('id')}/" style="height: 100%"></iframe>
	</div>
</div>	