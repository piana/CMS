<center>
	<a href="{$HOME}admin/" class="mobileHidden logo"><img src="{$HOME}app/plugins/admin/resources/img/logo-icon{license::get()}.png" ></a>
</center>
<a href="#" onclick="
	$( '#sidebar').toggle();
	$('#content').toggleClass('mobileHidden');
	$( '.smallTopNav').toggle();"
	class="noMobileHidden slideButton" style="display:block;">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>
<ul class="menu accordion" id="leftMenu">
	{if usersDB::permissionCheck(adminContentController) and usertypesDB::havePanelPermission('mainContent')}
	<li class="accordion-group {if $REQUEST->controllerName()=='adminContentController'}active{/if}">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuContent">
	        <i class="fa fa-file-text "> </i> <span class="menu-description">{L key = "admin.menu.content"}</span>
	      </a>
	    </div>	
	    <div id="leftMenuContent" class="accordion-body collapse {if $REQUEST->controllerName()=='adminContentController' and config::get("smallSidebar{$loggedUser->id}")!=1}in{/if}">
      		<div class="accordion-inner">
				<ul>
				    {if usertypesDB::havePanelPermission('pages')}{if usertypesDB::havePanelPermission('pages')}<li {if $subpage=='pages'}class="active"{/if}><a href="{$HOME}admin/content/pages/"><i class="color-icons icons-clipboard-list icon-margin"> </i><span class="menu-description">{L key = "admin.content.tpl.pages"}</span></a></li>{/if}{/if}
				   	{if usertypesDB::havePanelPermission('files')}<li {if $subpage=='files'}class="active"{/if}><a href="{$HOME}admin/content/files/"><i class="color-icons icons-blue-folder-horizontal icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.file"}</span></a></li>{/if}	
				   	{if usertypesDB::havePanelPermission('images')}<li {if $subpage=='images'}class="active"{/if}><a href="{$HOME}admin/content/images/"><i class="color-icons icons-inbox-slide icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.images"}</span></a></li>{/if}
					{if usertypesDB::havePanelPermission('banners')}<li {if $subpage=='banners'}class="active"{/if}><a href="{$HOME}admin/content/banners/"><i class="color-icons icons-caution-board icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.banners"}{if !license::hasPro()}<span class="small-pro">Pro</span>{/if}</a></li>{/if}
					{if usertypesDB::havePanelPermission('polls')}<li {if $subpage=='polls'}class="active"{/if}><a href="{$HOME}admin/content/polls/"><i class="color-icons icons-document-task icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.polls"}{if !license::hasPro()}<span class="small-pro">Pro</span>{/if}</a></li>{/if}
					{if usertypesDB::havePanelPermission('calendar')}<li {if $subpage=='calendar'}class="active"{/if}><a href="{$HOME}admin/content/calendar/"><i class="color-icons icons-calendar-list icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.calendar"}{if !license::hasPro()}<span class="small-pro">Pro</span>{/if}</a></li>{/if}
				  		   		
				    {if !usersDB::isNoob()}{if usertypesDB::havePanelPermission('lang')}<li {if $subpage=='lang'}class="active"{/if}><a href="{$HOME}admin/content/lang/"><i class="color-icons icons-direction icon-margin"> </i><span class="menu-description">{L key = "admin.content.common.tpl.languages"}</span></a></li>{/if}{/if}
				    {if usertypesDB::havePanelPermission('trash')}<li {if $subpage=='trash'}class="active"{/if}><a href="{$HOME}admin/content/trash/"><i class="color-icons icons-popcorn icon-margin"> </i><span class="menu-description">{L key = "admin.content.tpl.trash"}</span></a></li>{/if}
				    {if usertypesDB::havePanelPermission('autosave')}<li {if $subpage=='autosave'}class="active"{/if}><a href="{$HOME}admin/content/autosave/"><i class="color-icons icons-disk-black icon-margin"> </i><span class="menu-description">{L key = "admin.content.tpl.autosave"}</span></a></li>{/if}
			
				    {if !usersDB::isNoob()}{if usertypesDB::havePanelPermission('configContent')}<li {if $subpage=='config' and $REQUEST->controllerName()=='adminContentController'}class="active"{/if}><a href="{$HOME}admin/content/config/"><i class="color-icons icons-gear icon-margin"> </i><span class="menu-description">{L key='admin.menu.config'}</span></a></li>{/if}{/if}
				</ul>	
			</div>
		</div>			
	</li>
	{/if}
	{if usersDB::permissionCheck(adminUsersController) and usertypesDB::havePanelPermission('mainForum')}
	<li class="accordion-group {if $REQUEST->controllerName()=='adminForumController'}active{/if}">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuForum">
	        <i class="fa fa-comments "> </i> <span class="menu-description">{L key = "admin.menu.forum"}</span>
	      </a>
	    </div>	
	    <div id="leftMenuForum" class="accordion-body collapse {if $REQUEST->controllerName()=='adminForumController' and config::get("smallSidebar{$loggedUser->id}")!=1}in{/if}">
      		<div class="accordion-inner">	
				<ul>
				    {if usertypesDB::havePanelPermission('forums')}<li {if $subpage=='forums'}class="active"{/if}><a href="{$HOME}admin/forum/forums/"><i class="color-icons icons-application-list icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.forum.tpl.forums"}</span></a></li>{/if}
				    {if usertypesDB::havePanelPermission('posts')}<li {if $subpage=='posts'}class="active"{/if}><a href="{$HOME}admin/forum/posts/"><i class="color-icons icons-balloon-white-left icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.forum.tpl.posts"}</span></a></li>{/if}
					{if usertypesDB::havePanelPermission('stats')}<li {if $subpage=='stats'}class="active"{/if}><a href="{$HOME}admin/forum/stats/"><i class="color-icons icons-chart-up icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.forum.tpl.stats"}</span></a></li>{/if}
					
				    {if !usersDB::isNoob()}{if usertypesDB::havePanelPermission('configForum')}<li {if $subpage=='config' and $REQUEST->controllerName()=='adminForumController'}class="active"{/if}><a href="{$HOME}admin/forum/config/"><i class="color-icons icons-gear icon-margin"> </i><span class="menu-description">{L key='admin.menu.config'}</span></a></li>{/if}{/if}
			  	</ul>	
			</div>
		</div>				  		
	</li>
	{/if}	
	{if usersDB::permissionCheck(adminUsersController) and usertypesDB::havePanelPermission('mainUsers')}
	<li class="accordion-group {if $REQUEST->controllerName()=='adminUsersController'}active{/if}">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuUsers">
	        <i class="fa fa-users "> </i> <span class="menu-description">{L key = "admin.menu.users"}</span>
	      </a>
	    </div>	
	    <div id="leftMenuUsers" class="accordion-body collapse {if $REQUEST->controllerName()=='adminUsersController' and config::get("smallSidebar{$loggedUser->id}")!=1}in{/if}">
      		<div class="accordion-inner">	
				<ul>
				    {if usertypesDB::havePanelPermission('moderator')}<li {if $subpage=='moderator'}class="active"{/if}><a href="{$HOME}admin/users/moderator/"><i class="color-icons icons-balloon-white-left icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.moderator"}</span></a></li>{/if}
				    {if !usersDB::isNoob()}{if usertypesDB::havePanelPermission('admins')}<li {if $subpage=='admins'}class="active"{/if}><a href="{$HOME}admin/users/admins/"><i class="color-icons icons-user-black icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.users.ctpl.admins"}</span></a></li>{/if}{/if}
				    {if usertypesDB::havePanelPermission('users')}<li {if $subpage=='users'}class="active"{/if}><a href="{$HOME}admin/users/users/"><i class="color-icons icons-user-yellow icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.users.ctpl.users"}</span></a></li>{/if}
				    {if !usersDB::isNoob()}{if usertypesDB::havePanelPermission('authorization')}<li {if $subpage=='authorization'}class="active"{/if}><a href="{$HOME}admin/users/authorization/"><i class="color-icons icons-wallet icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.users.ctpl.authorization"}{if !license::hasPro()}<span class="small-pro">Pro</span>{/if}</a></li>{/if}{/if}
                    {if !usersDB::isNoob()}{if usertypesDB::havePanelPermission('history')}<li {if $subpage=='history'}class="active"{/if}><a href="{$HOME}admin/users/history/"><i class="color-icons icons-clipboard-invoice icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.users.ctpl.history"}{if !license::hasPro()}<span class="small-pro">Pro</span>{/if}</a></li>{/if}{/if}

                    {if !usersDB::isNoob()}{if usertypesDB::havePanelPermission('configUsers')}<li {if $subpage=='config' and $REQUEST->controllerName()=='adminUsersController'}class="active"{/if}><a href="{$HOME}admin/users/config/"><i class="color-icons icons-gear icon-margin"> </i><span class="menu-description">{L key='admin.menu.config'}</span></a></li>{/if}{/if}
				</ul>  
			</div>
		</div>						
	</li>
	{/if}
	{if usersDB::permissionCheck(adminThemesController) and usertypesDB::havePanelPermission('mainThemes')}
	<li class="accordion-group {if $REQUEST->controllerName()=='adminThemesController'}active{/if}">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuThemes">
	        <i class="fa fa-desktop "> </i> <span class="menu-description">{L key = "admin.menu.themes"}</span>
	      </a>
	    </div>	
	    <div id="leftMenuThemes" class="accordion-body collapse {if $REQUEST->controllerName()=='adminThemesController' and config::get("smallSidebar{$loggedUser->id}")!=1}in{/if}">
      		<div class="accordion-inner">	
				<ul>
				    {if usertypesDB::havePanelPermission('themes')}<li {if $subpage=='themes'}class="active"{/if}><a href="{$HOME}admin/themes/themes/"><i class="color-icons icons-resource-monitor icon-margin"> </i><span class="menu-description">{L key = "admin.themes.tpl.graphictemplates"}</span></a></li>{/if}
				    {if !usersDB::isNoob()}{if usertypesDB::havePanelPermission('widgets')}<li {if $subpage=='widgets'}class="active"{/if}><a href="{$HOME}admin/themes/widgets/"><i class="color-icons icons-resource-monitor-protector icon-margin"> </i><span class="menu-description">{L key = "admin.themes.tpl.widgets"}</span></a></li>{/if}{/if}
				    
				    {if !usersDB::isNoob()}{if usertypesDB::havePanelPermission('configThemes')}<li {if $subpage=='config' and $REQUEST->controllerName()=='adminThemesController'}class="active"{/if}><a href="{$HOME}admin/themes/config/"><i class="color-icons icons-gear icon-margin"> </i><span class="menu-description">{L key='admin.menu.config'}</span></a></li>{/if}{/if}
				</ul>	
			</div>
		</div>			
	</li>
	{/if}
	{if usersDB::permissionCheck(adminToolsController) and usertypesDB::havePanelPermission('mainTools')}
	<li class="accordion-group {if $REQUEST->controllerName()=='adminToolsController'}active{/if}">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuTools">
	        <i class="fa fa-wrench "> </i> <span class="menu-description">{L key = "admin.menu.tools"}</span>
	      </a>
	    </div>	
	    <div id="leftMenuTools" class="accordion-body collapse {if $REQUEST->controllerName()=='adminToolsController' and config::get("smallSidebar{$loggedUser->id}")!=1}in{/if}">
      		<div class="accordion-inner">		
				<ul>
				  	{if usertypesDB::havePanelPermission('tools')}<li {if $subpage=='tools'}class="active"{/if}><a href="{$HOME}admin/tools/tools/"><i class="color-icons icons-wooden-box icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.tools"}</span></a></li>{/if}
				  	{if usertypesDB::havePanelPermission('monitoring')}<li {if $subpage=='monitoring'}class="active"{/if}><a href="{$HOME}admin/tools/monitoring/"><i class="color-icons icons-application-monitor icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.monitoring"}{if !license::hasPro()}<span class="small-pro">Pro</span>{/if}</a></li>{/if}
					{if usertypesDB::havePanelPermission('rss')}<li {if $subpage=='rss'}class="active"{/if}><a href="{$HOME}admin/tools/rss/"><i class="color-icons icons-printer icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.rss"}{if !license::hasPro()}<span class="small-pro">Pro</span>{/if}</a></li>{/if}
				  	{if usertypesDB::havePanelPermission('seo')}<li {if $subpage=='seo'}class="active"{/if}><a href="{$HOME}admin/tools/seo/"><i class="color-icons icons-globe icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.seo"}{if !license::hasPro()}<span class="small-pro">Pro</span>{/if}</a></li>{/if}
					{if usertypesDB::havePanelPermission('mailing')}<li {if $subpage=='mailing'}class="active"{/if}><a href="{$HOME}admin/tools/mailing/"><i class="color-icons icons-mail--arrow icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.mailing"}{if !license::hasPro('pro')}<span class="small-pro">Pro</span>{/if}</a></li>{/if}	
					{if usertypesDB::havePanelPermission('contacts')}<li {if $subpage=='contacts'}class="active"{/if}><a href="{$HOME}admin/tools/contacts/"><i class="color-icons icons-inbox-document-text icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.contact"}{if !license::hasPro('pro')}<span class="small-pro">Pro</span>{/if}</a></li>{/if}
			 	 	{if !usersDB::isNoob()}
			 	 		{if usertypesDB::havePanelPermission('database')}<li {if $subpage=='database'}class="active"{/if}><a href="{$HOME}admin/tools/database/"><i class="color-icons icons-databases icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.database"}{if !license::hasPro('pro')}<span class="small-pro">Pro</span>{/if}</a></li>{/if}
			 	  	{/if}
			 	 	
				    {if !usersDB::isNoob()}{if usertypesDB::havePanelPermission('configTools')}<li {if $subpage=='config' and $REQUEST->controllerName()=='adminToolsController'}class="active"{/if}><a href="{$HOME}admin/tools/config/"><i class="color-icons icons-gear icon-margin"> </i><span class="menu-description">{L key='admin.menu.config'}</span></a></li>{/if}{/if}
			 	</ul>	
			</div>
		</div>	 		
	</li>
	{/if}
	{if usersDB::permissionCheck(adminConfigController) and !usersDB::isNoob() and usertypesDB::havePanelPermission('mainConfig')}
	<li class="accordion-group {if $REQUEST->controllerName()=='adminConfigController'}active{/if}">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuConfig">
	        <i class="fa fa-cogs "> </i> <span class="menu-description">{L key = "admin.menu.config"}</span>
	      </a>
	    </div>	
	    <div id="leftMenuConfig" class="accordion-body collapse {if $REQUEST->controllerName()=='adminConfigController' and config::get("smallSidebar{$loggedUser->id}")!=1}in{/if}">
      		<div class="accordion-inner">
				<ul>
					{$buckets = $configDB->fetchGroup('bucket','bucket!=99','name ASC')}
				    {foreach $buckets as $key => $bucket}
				    <li {if $subpage==$key}class="active"{/if}><a href="{$HOME}admin/config/{$key}/"><i class="color-icons icons-gear icon-margin">&nbsp;</i><span class="menu-description">{L key = $configDB->bucketNames[$key]}</a></li>
				    {/foreach}
				</ul>	
			</div>
		</div>			
	</li>
	{/if}
	{$menuExtList = pluginManager::loadAdminMenuItems() and usertypesDB::havePanelPermission('mainCustomPanels')}
	{if is_array($menuExtList)}
		{foreach $menuExtList as $menuItem}
			<li {if $REQUEST->controllerName()==$menuItem['controllerName']}class="active"{/if}>
				<a href="{$HOME}{$menuItem['adminUrl']}">
					<i class="fa fa-clipboard "> </i> <span class="menu-description">{$menuItem['title']}</span>
				</a>
			</li>
		{/foreach}	
	{/if}		
	{if usersDB::permissionCheck(adminSystemController) and usertypesDB::havePanelPermission('mainSystem')}
	<li class="accordion-group {if $REQUEST->controllerName()=='adminSystemController'}active{/if}">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#leftMenuSystem">
	        <i class="fa fa-tachometer "> </i> <span class="menu-description">{L key = "admin.menu.system"}</span>
	      </a>
	    </div>	
	    <div id="leftMenuSystem" class="accordion-body collapse {if $REQUEST->controllerName()=='adminSystemController' and config::get("smallSidebar{$loggedUser->id}")!=1}in{/if}">
      		<div class="accordion-inner">
				<ul>
				  	{if usertypesDB::havePanelPermission('system')}<li {if $subpage=='system'}class="active"{/if}><a href="{$HOME}admin/system/system/"><i class="color-icons icons-system-monitor icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.system.tpl.system"}</span></a></li>{/if}
				  	{if usertypesDB::havePanelPermission('stats')}<li {if $subpage=='stats'}class="active"{/if}><a href="{$HOME}admin/system/stats/"><i class="color-icons icons-chart-up icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.stats"}</span></a></li>{/if}
				  	{if usertypesDB::havePanelPermission('notifications')}<li {if $subpage=='notifications'}class="active"{/if}><a href="{$HOME}admin/system/notifications/"><i class="color-icons icons icons-caution-board icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.system.tpl.notifications"}</span></a></li>{/if}
					{if usertypesDB::havePanelPermission('backup')}<li {if $subpage=='backup'}class="active"{/if}><a href="{$HOME}admin/system/backup/"><i class="color-icons icons-wooden-box-label icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.backup"}{if !license::hasPro()}<span class="small-pro">Pro</span>{/if}</a></li>{/if}	
				     	
					{if !usersDB::isNoob()}
						{if usertypesDB::havePanelPermission('log')}<li {if $subpage=='log'}class="active"{/if}><a href="{$HOME}admin/system/log/"><i class="color-icons icons-rocket icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.system.tpl.log"}{if !license::hasPro()}<span class="small-pro">Pro</span>{/if}</a></li>{/if}
				  		{if usertypesDB::havePanelPermission('cron')}<li {if $subpage=='cron'}class="active"{/if}><a href="{$HOME}admin/system/cron/"><i class="color-icons icons-clipboard-invoice icon-margin">&nbsp;</i><span class="menu-description">Cron{if !license::hasPro('pro')}<span class="small-pro">Pro</span>{/if}</a></span></li>{/if}
			 	 		{if usertypesDB::havePanelPermission('firewall')}<li {if $subpage=='firewall'}class="active"{/if}><a href="{$HOME}admin/system/firewall/"><i class="color-icons icons-network-ethernet icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.firewall"}{if !license::hasPro('pro')}<span class="small-pro">Pro</span>{/if}</a></li>{/if}
			 	 		{if usertypesDB::havePanelPermission('requestlog')}<li {if $subpage=='requestlog'}class="active"{/if}><a href="{$HOME}admin/system/requestlog/showLogs/"><i class="color-icons icons-system-monitor-network icon-margin icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.tools.tpl.requestlog"}{if !license::hasPro('pro')}<span class="small-pro">Pro</span>{/if}</a></li>{/if}
					{/if}	 
					{if usertypesDB::havePanelPermission('licence')}<li {if $subpage=='licence'}class="active"{/if}><a href="{$HOME}admin/system/licence/"><i class="color-icons icons-money icon-margin">&nbsp;</i><span class="menu-description">{L key = "admin.system.tpl.license"}</span></a></li>{/if}
			 	 	   
				    {if !usersDB::isNoob()}{if usertypesDB::havePanelPermission('configSystem')}<li {if $subpage=='config' and $REQUEST->controllerName()=='adminSystemController'}class="active"{/if}><a href="{$HOME}admin/system/config/"><i class="color-icons icons-gear icon-margin"> </i><span class="menu-description">{L key='admin.menu.config'}</span></a></li>{/if}{/if}
				</ul>
			</div>
		</div>				
	</li>
	{/if}
</ul>