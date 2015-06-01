	<div class="loginbox">
		<img src="{$HOME}app/plugins/admin/resources/img/logo-login.png">
		
		<div class="loginbox-white">
		<h4>{$title}</h4>
			{if is_object($form)}
				<div class="progress progress-striped" style="margin-left:35px; margin-right:35px;">
				  <div class="bar" style="width: {$load}%;"></div>
				</div>				
				{$form->toHtml()}
			{elseif $finish == true}	
				<div class="progress progress-striped" style="margin-left:35px; margin-right:35px;">
				  <div class="bar" style="width: {$load}%;"></div>
				</div>
				<p class="accept-terms" style="padding:20px;">{L key = "admin.install.controller.creator"}</p>
				<div class="btn-group" style="margin-bottom:30px;">
					<a href="{$HOME}admin/creator/" class="btn btn-primary btn-large">{L key = "admin.install.tpl.creator"}</a>
					<a href="{$HOME}admin/check/" class="btn btn-large">{L key = "admin.install.tpl.adminpanel"}</a>
				</div>	
			{elseif $REQUEST->getVariable('action')=='selectDatabaseType'}
				<div class="progress progress-striped" style="margin-left:35px; margin-right:35px;">
				  <div class="bar" style="width: {$load}%;"></div>
				</div>	
				<p class="accept-terms" style="padding:20px;">{L key = "admin.install.controller.dbinfo"}</p>			
				<div class="btn-group" style="margin-bottom:30px;">
					{if extension_loaded('pdo_sqlite')}<a href="{$HOME}admin/install/setupSQLite/" class="btn btn-primary btn-large">SQLite</a>{/if}
					{if extension_loaded('pdo_mysql')}<a href="{$HOME}admin/install/setupMySQL/" class="btn btn-large">MySQL</a>{/if}
				</div>
			{elseif $REQUEST->getVariable('action')=='setupMySQL'}
				<div class="progress progress-striped" style="margin-left:35px; margin-right:35px;">
				  <div class="bar" style="width: {$load}%;"></div>
				</div>	
				{$form->toHtml()}
			{elseif $REQUEST->getVariable('action')=='startInstallation'}
				<a href="{$HOME}admin/install/selectDatabaseType/" class="btn btn-primary btn-large">{L key = "admin.install.tpl.begininstall"}</a>
				<p class="accept-terms">{L key = "admin.install.tpl.clickaccept"} {L key = "admin.install.tpl.termslink"}</p>
			{else}
				<ul class="selecLang">	
				    {foreach $pagesDB->getPagesByParent('0',null,'position ASC','*',null,null,true) as $lang}
				    	{assign icon pagesDB::getMainImageEkey($lang->id,'icon')}
						<li>
							<a href="{$HOME}admin/install/setLanguage/{$lang->id}/">
								{if !empty($icon)}
									<img src="{$HOME}image/{$icon}/100/100/original/"> {$lang->name}
								{else}
									{$lang->name}
								{/if}
							</a>
						</li>
					{/foreach}
				</ul>
			{/if}	
		</div>
		<p class="text-shadow">Windu 3.1 rev. {config::get(revision)}</p>
	</div>
	
