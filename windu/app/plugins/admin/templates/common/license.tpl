<div class="row-fluid">
	<div class="span12 align-center">
		<div class="pad align-center" style="margin:auto; padding:50px; width:400px; margin-top:80px; padding-bottom:0px;">
			{if is_object($licenseForm)}
				<i class="fa fa-lock fa-6x icon-yellow" style="margin-bottom: -20px;"></i>
				<h4>{L key = "admin.system.tpl.license"}</h4>
				{L key = "admin.system.tpl.addkey"}.<br><br>
				{$licenseForm->toHtml()}
			{else}<br><br><br>
				<i class="fa fa-check fa-6x icon-green"></i>
				<h4>{L key = "admin.system.tpl.gz"}</h4>
				{L key = "admin.system.tpl.activelicense"}
				{if !cache::isCached('freeLicencesNum','3600')}
					{cache::write("freeLicencesNum",license::getFreeLicences())}
				{/if}
				<br><br>
				{L key = "admin.system.tpl.licensetype"}<strong>{license::get()}</strong><br>
				{L key = "admin.system.tpl.amount"}<strong>{cache::read('freeLicencesNum')}</strong>
			{/if}
		</div>
	</div>
</div>