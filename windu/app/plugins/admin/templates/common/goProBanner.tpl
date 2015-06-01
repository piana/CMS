{if !license::hasPro() and cookie::get('closeGoProBanner')!=1}
	<div class="goProBaner margin-bottom mobileHidden">
		<h1>{L key="admin.templates.common.goprobanner.buypro"}</h1>
		<h4>{L key="admin.templates.common.goprobanner.gain"}</h4><br>
		<a href="{if lang::read('lang')=='PL'}{license::$buyLicensesLinkPL}{else}{license::$buyLicensesLinkEN}{/if}" class="btn btn-inverse btn-large">{L key="admin.templates.common.goprobanner.gopro"}</a>
		<a href="{$HOME}admin/do/closeGoProBanner/" class="closeBanner"><i class="fa fa-times-circle"></i></a>
	</div>
{/if}
