<a href="#" onclick="
	$('#sidebar').toggle();
	$('#content').toggleClass('mobileHidden');
	$('.smallTopNav').toggle();"
	class="noMobileHidden slideButton" style="float:left;">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>

<a href="{$HOME}" data-toggle="tooltip" data-placement="bottom" data-original-title="{L key = 'admin.system.tpl.main'}"><i class="fa fa-globe "></i></a>
{*
<a href="{$HOME}admin/{$controllerShortName}/help/" data-toggle="tooltip" data-placement="bottom" data-original-title="{L key = 'admin.menu.help'}"><i class="fa fa-question-circle"> </i></a>
*}

{if notifyDB::count()>0 and usersDB::permissionCheck(adminSystemController)}
<a data-content='{if notifyDB::count()>0}
			<table class="table table-striped tablesort">
			  <tbody>
			  {foreach $notifications as $notify}
				<tr>
					<td>
						{if $notify->priority == notifyDB::STATUS_LIGHT}
							<span class="badge">{$notify->priority}</span>
						{elseif $notify->priority == notifyDB::STATUS_INFO}
							<span class="badge badge-info">{$notify->priority}</span>				
						{elseif $notify->priority == notifyDB::STATUS_WORNING}
							<span class="badge badge-warning">{$notify->priority}</span>
						{elseif $notify->priority == notifyDB::STATUS_DANGER}
							<span class="badge badge-important">{$notify->priority}</span>	
						{elseif $notify->priority == notifyDB::STATUS_ERROR}
							<span class="badge badge-inverse">{$notify->priority}</span>												
						{else}
							<span class="badge">{$notify->priority}</span>
						{/if}
					</td>
					<td>
						{if $notify->url!=null}
							<a href="{$HOME}{$notify->url}">{L key=$notify->content}</a>
						{else}
							{L key=$notify->content}
						{/if}
					</td>						
				</tr>
			  {/foreach}   
			  </tbody>
			</table>
			{/if}' data-toggle="popover" data-placement="bottom" href="#" data-original-title="{L key = 'admin.system.tpl.notices'} <a href='{$HOME}admin/do/system/cleanNotifications/' class='btn btn-small pull-right btn-primary'><i class='fa fa-check'></i></a>">
	<i class="fa fa-bell " ></i><span class="badge badge-notifications">{notifyDB::count()}</span>
</a>
{/if}		
{if check::update(false,false)}
  	<a href="{$HOME}admin/update/" data-toggle="tooltip" data-placement="bottom" data-original-title="{L key = 'admin.system.tpl.updatesystem'}">
		<i class="fa fa-arrow-circle-up ">&nbsp;</i><span class="badge badge-notifications">1</span>
  	</a>   
{/if}	
{$notesCount = notesDB::count()}         
<a class="tooltip-force mobileHidden" data-placement="bottom" title="{L key = "admin.main.tpl.notes"}" onclick="$('#noteModalIframe').html('<iframe src=\'{$HOME}admin/ajax/notes/showNotes/\'></iframe>');" href="#modal" data-toggle="modal" data-target="#notesModal" >
	<i class="fa fa-tasks">&nbsp;</i>{if $notesCount > 0}<span class="badge badge-notifications">{$notesCount}</span>{/if}
</a>

<div class="searchAdminPanel mobileHidden">
	<script src='{$HOME}app/plugins/html/resources/select2/select2.min.js' type='text/javascript'></script>
	<script type='text/javascript'>
	{literal}
		$(document).ready(function() {
			$("#searchAdminPanel").select2({placeholder: "Wpisz szukane hasło"});
			$("#searchAdminPanel").on("change", function(e) { window.location = e.val; });
		});
	{/literal}	
	</script>
    {/nocache}
	<select id="searchAdminPanel">
		<option value=""></option>

		{* Treści *}
		<option value="{$HOME}admin/content/pages/">{L key = 'admin.system.rightbuttons.tpl.content'}</option>
		<option value="{$HOME}admin/content/pages/">{L key = 'admin.system.rightbuttons.tpl.pageedit'}</option>
		<option value="{$HOME}admin/content/pages/">{L key = 'admin.system.rightbuttons.tpl.contedit'}</option>
		<option value="{$HOME}admin/content/pages/">{L key = 'admin.system.rightbuttons.tpl.orderchange'}</option>
		<option value="{$HOME}admin/content/pages/">{L key = 'admin.system.rightbuttons.tpl.addnews'}</option>
		<option value="{$HOME}admin/content/pages/">{L key = 'admin.system.rightbuttons.tpl.addcontent'}</option>
		<option value="{$HOME}admin/content/pages/">{L key = 'admin.system.rightbuttons.tpl.addpage'}</option>
		<option value="{$HOME}admin/content/pages/">{L key = 'admin.system.rightbuttons.tpl.addphoto'}</option>
		<option value="{$HOME}admin/content/pages/">{L key = 'admin.system.rightbuttons.tpl.addfile'}</option>
		<option value="{$HOME}admin/content/pages/">{L key = 'admin.system.rightbuttons.tpl.gallery'}</option>
		<option value="{$HOME}admin/content/pages/">{L key = 'admin.system.rightbuttons.tpl.editmenu'}</option>

		{* Pliki *}
		<option value="{$HOME}admin/content/files/">{L key = 'admin.system.rightbuttons.tpl.filelist'}</option>
		<option value="{$HOME}admin/content/files/">{L key = 'admin.system.rightbuttons.tpl.fielsadded'}</option>

		{* Zdjęcia *}
		<option value="{$HOME}admin/content/images/">{L key = 'admin.system.rightbuttons.tpl.photolist'}</option>
		<option value="{$HOME}admin/content/images/">{L key = 'admin.system.rightbuttons.tpl.photosadded'}</option>

		{* Banery, Sondy, Kalendarz *}
		<option value="{$HOME}admin/content/banners/">{L key = 'admin.system.rightbuttons.tpl.banners'}</option>
		<option value="{$HOME}admin/content/polls/">{L key = 'admin.system.rightbuttons.tpl.polls'}</option>
		<option value="{$HOME}admin/content/calendar/">{L key = 'admin.system.rightbuttons.tpl.calendar'}</option>

		{* Języki *}
		<option value="{$HOME}admin/content/lang/">{L key = 'admin.system.rightbuttons.tpl.langs'}</option>
		<option value="{$HOME}admin/content/lang/">{L key = 'admin.system.rightbuttons.tpl.tanslations'}</option>
		<option value="{$HOME}admin/content/lang/">{L key = 'admin.system.rightbuttons.tpl.addeditlang'}</option>

		{* Kosz *}
		<option value="{$HOME}admin/content/trash/">{L key = 'admin.system.rightbuttons.tpl.bin'}</option>
		<option value="{$HOME}admin/content/trash/">{L key = 'admin.system.rightbuttons.tpl.deletedelements'}</option>

		{* Autozapis *}
		<option value="{$HOME}admin/content/autosave/">{L key = 'admin.system.rightbuttons.tpl.autosave'}</option>

		{* Użytkownicy przegląd *}
		<option value="{$HOME}admin/users/moderator/">{L key = 'admin.system.rightbuttons.tpl.users'}</option>
		<option value="{$HOME}admin/users/moderator/">{L key = 'admin.system.rightbuttons.tpl.usersview'}</option>
		<option value="{$HOME}admin/users/moderator/">{L key = 'admin.system.rightbuttons.tpl.commentview'}</option>
		<option value="{$HOME}admin/users/moderator/">{L key = 'admin.system.rightbuttons.tpl.comments'}</option>
		<option value="{$HOME}admin/users/moderator/">{L key = 'admin.system.rightbuttons.tpl.contentadded'}</option>

		{* Administratorzy *}
		<option value="{$HOME}admin/users/admins/">{L key = 'admin.system.rightbuttons.tpl.admins'}</option>
		<option value="{$HOME}admin/users/admins/">{L key = 'admin.system.rightbuttons.tpl.addingadmin'}</option>

		{* Użytkownicy strony *}
		<option value="{$HOME}admin/users/users/">{L key = 'admin.system.rightbuttons.tpl.editrights'}</option>
		<option value="{$HOME}admin/users/users/">{L key = 'admin.system.rightbuttons.tpl.siteusers'}</option>
		<option value="{$HOME}admin/users/users/">{L key = 'admin.system.rightbuttons.tpl.addingusers'}</option>
		<option value="{$HOME}admin/users/users/">{L key = 'admin.system.rightbuttons.tpl.siteusers'}</option>
		<option value="{$HOME}admin/users/users/">{L key = 'admin.system.rightbuttons.tpl.editusers'}</option>

		{* Uprawnienia *}
		<option value="{$HOME}admin/users/authorization/">{L key = 'admin.system.rightbuttons.tpl.permits'}</option>
		<option value="{$HOME}admin/users/authorization/">{L key = 'admin.system.rightbuttons.tpl.edituserpermits'}</option>

		{* Szablony graficzne *}
		<option value="{$HOME}admin/themes/themes/">{L key = 'admin.system.rightbuttons.tpl.graphtemps'}</option>
		<option value="{$HOME}admin/themes/themes/">{L key = 'admin.system.rightbuttons.tpl.sitegraphics'}</option>
		<option value="{$HOME}admin/themes/themes/">{L key = 'admin.system.rightbuttons.tpl.templates'}</option>
		<option value="{$HOME}admin/themes/themes/">{L key = 'admin.system.rightbuttons.tpl.sitegraphics'}</option>
		<option value="{$HOME}admin/themes/themes/">{L key = 'admin.system.rightbuttons.tpl.graphtempinst'}</option>
		<option value="{$HOME}admin/themes/themes/">{L key = 'admin.system.rightbuttons.tpl.editsitesgraph'}</option>
		<option value="{$HOME}admin/themes/themes/">{L key = 'admin.system.rightbuttons.tpl.logotypechange'}</option>
		<option value="{$HOME}admin/themes/themes/">{L key = 'admin.system.rightbuttons.tpl.logotype'}</option>
		<option value="{$HOME}admin/themes/themes/">{L key = 'admin.system.rightbuttons.tpl.addanalitcode'}</option>

		{* Widgety *}
		<option value="{$HOME}admin/themes/widgets/">{L key = 'admin.system.rightbuttons.tpl.widgets'}</option>
		<option value="{$HOME}admin/themes/widgets/">{L key = 'admin.system.rightbuttons.tpl.widupdate'}</option>
		<option value="{$HOME}admin/themes/widgets/">{L key = 'admin.system.rightbuttons.tpl.widgets'}</option>
		<option value="{$HOME}admin/themes/widgets/">{L key = 'admin.system.rightbuttons.tpl.addonsinstall'}</option>

		{* Narzędzia *}
		<option value="{$HOME}admin/tools/tools/">{L key = 'admin.system.rightbuttons.tpl.tools'}</option>
		<option value="{$HOME}admin/tools/tools/">{L key = 'admin.system.rightbuttons.tpl.protools'}</option>

		{* Monitoring *}
		<option value="{$HOME}admin/tools/monitoring/">{L key = 'admin.system.rightbuttons.tpl.monitoring'}</option>
		<option value="{$HOME}admin/tools/monitoring/">{L key = 'admin.system.rightbuttons.tpl.systemstats'}</option>

		{* RSS *}
		<option value="{$HOME}admin/tools/rss/">{L key = 'admin.system.rightbuttons.tpl.rss'}</option>
		<option value="{$HOME}admin/tools/rss/">{L key = 'admin.system.rightbuttons.tpl.rsschan'}</option>

		{* Seo *}
		<option value="{$HOME}admin/tools/seo/">{L key = 'admin.system.rightbuttons.tpl.seo'}</option>
		<option value="{$HOME}admin/tools/seo/">{L key = 'admin.system.rightbuttons.tpl.errorredirect'}</option>

		{* Mailing *}
		<option value="{$HOME}admin/tools/mailing/">{L key = 'admin.system.rightbuttons.tpl.mailing'}</option>
		<option value="{$HOME}admin/tools/mailing/">{L key = 'admin.system.rightbuttons.tpl.massmail'}</option>

		{* Kontakty *}
		<option value="{$HOME}admin/tools/contacts/">{L key = 'admin.system.rightbuttons.tpl.contacts'}</option>
		<option value="{$HOME}admin/tools/contacts/">{L key = 'admin.system.rightbuttons.tpl.contactbase'}</option>

		{* DB *}
		<option value="{$HOME}admin/tools/database/">{L key = 'admin.system.rightbuttons.tpl.database'}</option>
		<option value="{$HOME}admin/tools/database/">{L key = 'admin.system.rightbuttons.tpl.tabellist'}</option>
		<option value="{$HOME}admin/tools/database/">{L key = 'admin.system.rightbuttons.tpl.viewdata'}</option>

		{* Konfiguracja *}
		<option value="{$HOME}admin/tools/config/">{L key = 'admin.system.rightbuttons.tpl.config'}</option>
		<option value="{$HOME}admin/tools/config/">{L key = 'admin.system.rightbuttons.tpl.gensettings'}</option>
		<option value="{$HOME}admin/tools/config/">{L key = 'admin.system.rightbuttons.tpl.generalconfig'}</option>

		<option value="{$HOME}admin/tools/config/">{L key = 'admin.system.rightbuttons.tpl.configcont'}</option>
		<option value="{$HOME}admin/tools/config/">{L key = 'admin.system.rightbuttons.tpl.settingscont'}</option>
		<option value="{$HOME}admin/tools/config/">{L key = 'admin.system.rightbuttons.tpl.configusers'}</option>
		<option value="{$HOME}admin/tools/config/">{L key = 'admin.system.rightbuttons.tpl.userpermits'}</option>
		<option value="{$HOME}admin/tools/config/">{L key = 'admin.system.rightbuttons.tpl.graphconfig'}</option>
		<option value="{$HOME}admin/tools/config/">{L key = 'admin.system.rightbuttons.tpl.graphsetting'}</option>
		<option value="{$HOME}admin/tools/config/">{L key = 'admin.system.rightbuttons.tpl.toolsconfig'}</option>
		<option value="{$HOME}admin/tools/config/">{L key = 'admin.system.rightbuttons.tpl.toolssetting'}</option>
		<option value="{$HOME}admin/tools/config/">{L key = 'admin.system.rightbuttons.tpl.systemconfig'}</option>
		<option value="{$HOME}admin/tools/config/">{L key = 'admin.system.rightbuttons.tpl.systemsettings'}</option>

		{* System *}
		<option value="{$HOME}admin/system/stats/">{L key = 'admin.system.rightbuttons.tpl.system'}</option>
		<option value="{$HOME}admin/system/stats/">{L key = 'admin.system.rightbuttons.tpl.stats'}</option>
		<option value="{$HOME}admin/system/stats/">{L key = 'admin.system.rightbuttons.tpl.visits'}</option>
		<option value="{$HOME}admin/system/stats/">{L key = 'admin.system.rightbuttons.tpl.entries'}</option>

		<option value="{$HOME}admin/system/notifications/">{L key = 'admin.system.rightbuttons.tpl.notice'}</option>
		<option value="{$HOME}admin/system/backup/">{L key = 'admin.system.rightbuttons.tpl.backup'}</option>
		<option value="{$HOME}admin/system/backup/">{L key = 'admin.system.rightbuttons.tpl.backupcopy'}</option>
		<option value="{$HOME}admin/system/backup/">{L key = 'admin.system.rightbuttons.tpl.systemcopy'}</option>

		<option value="{$HOME}admin/system/log/">{L key = 'admin.system.rightbuttons.tpl.systemlogs'}</option>
		<option value="{$HOME}admin/system/log/">{L key = 'admin.system.rightbuttons.tpl.404errors'}</option>
		<option value="{$HOME}admin/system/log/">{L key = 'admin.system.rightbuttons.tpl.systemerrors'}</option>
		<option value="{$HOME}admin/system/log/">{L key = 'admin.system.rightbuttons.tpl.logins'}</option>
		<option value="{$HOME}admin/system/log/">{L key = 'admin.system.rightbuttons.tpl.updates'}</option>

		<option value="{$HOME}admin/system/cron/">{L key = 'admin.system.rightbuttons.tpl.cron'}</option>
		<option value="{$HOME}admin/system/cron/">{L key = 'admin.system.rightbuttons.tpl.systemtasks'}</option>

		<option value="{$HOME}admin/system/firewall/">{L key = 'admin.system.rightbuttons.tpl.firewall'}</option>
		<option value="{$HOME}admin/system/firewall/">{L key = 'admin.system.rightbuttons.tpl.systemfirewall'}</option>

		<option value="{$HOME}admin/system/requestlog/showLogs/">{L key = 'admin.system.rightbuttons.tpl.reqlog'}</option>
		<option value="{$HOME}admin/system/requestlog/showLogs/">{L key = 'admin.system.rightbuttons.tpl.references'}</option>

		<option value="{$HOME}admin/system/licence/">{L key = 'admin.system.rightbuttons.tpl.license'}</option>
		<option value="{$HOME}admin/system/licence/">{L key = 'admin.system.rightbuttons.tpl.windupro'}</option>
		<option value="{$HOME}admin/system/licence/">{L key = 'admin.system.rightbuttons.tpl.winduplus'}</option>
		<option value="{$HOME}admin/system/licence/">{L key = 'admin.system.rightbuttons.tpl.keyactivation'}</option>
	</select>
    {nocache}
</div>


<a data-content='<ul class="paneltype-menu">
                      <li><a href="{$HOME}admin/mainDo/setPanelMode/0/"><i class="fa fa-leaf icon-green"></i> {L key = 'admin.system.rightbuttons.tpl.simplified'}</a></li>
                      <li><a href="{$HOME}admin/mainDo/setPanelMode/1/"><i class="fa fa-plane"></i> {L key = 'admin.system.rightbuttons.tpl.basic'}</a></li>
                      <li><a href="{$HOME}admin/mainDo/setPanelMode/2/"><i class="fa fa-bolt icon-red"></i> {L key = 'admin.system.rightbuttons.tpl.advanced'}</a></li>
                </ul>' data-toggle="popover" data-placement="bottom" href="#" data-original-title="Tryb panelu" class="{if usersDB::isDeveloper()} user-dropdown-danger{elseif usersDB::isNoob()} user-dropdown-green{else} user-dropdown-blue{/if}  {if is_array($pins)}top-menu-margin-right{/if} smallMobileHidden">
	{if usersDB::isNoob()}
		<i class="fa fa-leaf icon-margin"></i> {L key = 'admin.system.rightbuttons.tpl.simplifiedmod'}
	{elseif usersDB::isDeveloper()}
		<i class="fa fa-bolt icon-margin"></i> {L key = 'admin.system.rightbuttons.tpl.advmod'}
	{else}
		<i class="fa fa-plane icon-margin"></i> {L key = 'admin.system.rightbuttons.tpl.basicmod'}
	{/if}
</a>
{if !license::hasPro()}
	<a href="{if lang::read('lang')=='PL'}{license::$buyLicensesLinkPL}{else}{license::$buyLicensesLinkEN}{/if}" target="blank" data-toggle="tooltip" data-placement="bottom" data-original-title="{L key = 'admin.main.tpl.buypro'}" class="goPro mobileHidden smallWidthHidden"><i class="fa fa-arrow-up "></i>&nbsp;&nbsp;Go PRO&nbsp;</a>
{/if}

<a href="{$HOME}admin/login/logout/" data-toggle="tooltip" data-placement="bottom" data-original-title="{L key = 'admin.main.tpl.logout'}"><i class="fa fa-lock "> </i>&nbsp;</a>

<a href="{$HOME}admin/do/flushCache/" data-toggle="tooltip" data-placement="bottom" data-original-title="{L key = 'admin.system.tpl.deletecache'}" >
    <i class="fa fa-repeat ">&nbsp;</i>{if config::get('cleanCacheFlag')==1}<span class="badge badge-notifications">{config::get('cleanCacheFlag')}</span>{/if}
</a>











