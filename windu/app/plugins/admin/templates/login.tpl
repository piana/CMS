	<div class="loginbox">
		<img src="{$HOME}app/plugins/admin/resources/img/logo-login{license::get()}.png">
		<div class="loginbox-white">
		{include file='common/alert.tpl'}	
		{$form->toHtml()}
		</div>
		<p class="text-shadow">Windu 3.1 rev. {config::get(revision)}</p>
	</div>
