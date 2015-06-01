{if !empty($data.loggedIn)}
<div class="pad">
	{L key = "userlogin.tpl.loggedas"}<br> <strong>{$data.loggedIn->email}</strong> <a href="{$HOME}do/logout/">{L key = "userlogin.tpl.logout"}</a><br>
	
	<a href="{$HOME}{$data.panelPage}">{L key = "userlogin.tpl.accsettings"}</a>
</div>	
{else}
	{$data.form->toHtml()}
{/if}

