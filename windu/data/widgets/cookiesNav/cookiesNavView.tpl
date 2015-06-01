{if cookie::get('cookies_accepted')!='yes'}
	<script type="text/javascript" src="{{$HOME}}data/widgets/cookiesNav/js/main.js"></script>
	<div class="cookiesNavMessage">
		{L key="cookies.nav.message"} <a href="{$params.url}">{L key="cookies.nav.privacypolitics"}</a> <a href="#" class="btn btn-primary" onclick="CloseCookiesWindow();">{L key="cookies.nav.accept"}</a>
	</div>
{/if}	