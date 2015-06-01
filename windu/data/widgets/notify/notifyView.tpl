{if $data.notifyMessageNegative!=''}
	<div class="alert alert-error">
		<button type="button" class="close" data-dismiss="alert">×</button>
		{L key=$data.notifyMessageNegative}
	</div>
{elseif $data.notifyMessagePositive!=''}
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		{L key=$data.notifyMessagePositive}
	</div>
{/if}
