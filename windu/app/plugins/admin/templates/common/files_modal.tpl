{if $REQUEST->getVariable('id')==''}{$bucket = 'main'}{else}{$bucket = $REQUEST->getVariable('id')}{/if}
<div id="filesModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">{L key = "admin.content.common.tpl.addfiles"}</h3>
	</div>
	<div class="modal-body">
		<iframe src="{$HOME}admin/ajax/files/modalUploader/{$bucket}/"></iframe>
	</div>
</div>	