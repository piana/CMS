{if $REQUEST->getVariable('mp')!=null}
<div class="alert-top alert-popup alert-popup-green">
	<strong><i class="icon-ok "></i>&nbsp;&nbsp;{L key = $REQUEST->getVariable('mp')}</strong>
</div>
{elseif $REQUEST->getVariable('mn')!=null}
<div class="alert-top alert-popup alert-popup-red">
	<strong><i class="fa fa-times-circle "></i>&nbsp;&nbsp;{L key = $REQUEST->getVariable('mn')}</strong>
</div>
{elseif $REQUEST->getVariable('mi')!=null}
<div class="alert-top alert-popup alert-popup-blue">
	<strong><i class="fa fa-info-circle "></i>&nbsp;&nbsp;{L key = $REQUEST->getVariable('mi')}</strong>
</div>
{/if}
<div class="alert-top alert-popup alert-popup-green" style="display:none;">
	<strong><i class="icon-ok "></i>&nbsp;&nbsp;{L key = 'admin.message.success'}</strong>
</div>
<div class="alert-top-autosave alert-popup alert-popup-green" style="display:none;">
	<strong><i class="icon-ok "></i>&nbsp;&nbsp;{L key = 'admin.message.success.autosave'}</strong>
</div>


