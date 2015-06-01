<div class="row-fluid">
	<div class="span12 align-center">
		<div class="pad align-center" style="margin:auto; padding:50px; width:330px; margin-top:100px; margin-bottom:50px;">
			<i class="fa fa-lock icon-yellow fa-6x"></i>
			<h4>{L key="admin.common.go.thismodpro"}</h4>
			{L key="admin.common.go.buylicensepro"}<br><br><br>
			<a href="{if lang::read('lang')=='PL'}{license::$buyLicensesLinkPL}{else}{license::$buyLicensesLinkEN}{/if}" class="btn btn-primary btn-large" target="blank">{L key="admin.common.go.buypro"}</a><br>
			<a href="{$HOME}admin/system/licence/" type="button" class="btn btn-link">{L key="admin.common.go.enterkey"}</a>
		</div>
	</div>
</div>
