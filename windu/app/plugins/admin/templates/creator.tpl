<div class="creatorbox">
	<img src="{$HOME}app/plugins/admin/resources/img/logo-login.png" style="margin-top:60px;">
	<div class="loginbox-white" style="padding-bottom:20px;">
		{include file='common/alert.tpl'}
		<h4>
			{$title}<br><br>
			<div class="progress progress-striped {if $load==100}progress-success{/if}" style="margin-left:20%; margin-right:20%;">
				<div class="bar" style="width: {$load}%;"></div>
			</div>
		</h4>
		{if $REQUEST->getVariable('action')=='selectTemplate'}
	  		{foreach $themesFromAddonsServer as $theme}
  				<div class="addonsBox imgMedium {if strpos($theme.tags,$REQUEST->getVariable('id')) != 'false'}hidden{/if}">
	  				<a  href="{$HOME}admin/do/themes/addThemeFromAddonsServerCreator/{$theme.fileEkey}/{$theme.name}/">
	  					{if $theme.imageUrlMedium!='0' or $theme.imageUrlMedium!=''}
	  						<img src="{$theme.imageUrlMedium}">
						{else}
	  						<img src="{$smarty.const.ADDONS_SERVER}image/{$theme.imageEkey}/300/300/smart/original/90/">
	  					{/if}
		  				<div class="buttons">
		  					<span class="badge badge-inverse">{str_replace(array('_','-'),array(' ',' '),$theme.name)}</span>
		  				</div>
	  				</a>
  				</div>
	  		{/foreach}	
	  	{elseif $REQUEST->getVariable('action')=='editImages'}
	  		<div class="row-fluid">
	  			<div class="span12">
	  				<div class="pad">
						{$imagesForm->toHtml()}
					</div>
				</div>
			</div>
			<hr>
			<a href="{$HOME}admin/creator/finish/" class="btn btn-primary btn-large">{L key="creator.tpl.next"}</a>
	  	{elseif $REQUEST->getVariable('action')=='addPages'}
	  		<div class="row-fluid">
	  			<div class="span6">	 
	  				<div class="pad"> 	
	  					{include file='common/content_list.tpl' creator=1}
	  				</div>	
	  			</div>
	  			<div class="span6">	
	  				<div class="pad">
	  				
	  				</div>
	  			</div>
	  		</div>	
	  		<hr>	
	  		<a href="{$HOME}admin/creator/finish/" class="btn btn-primary btn-large">{L key="creator.tpl.next"}</a>
		{elseif $REQUEST->getVariable('action')=='finish'}
  			<a href="{$HOME}admin/check/?back={base64_encode('/')}" class="typeBox">
  				<i class="fa fa-globe fa-5x"></i><br>
  				<div class="buttons">
			  		<span class="badge badge-inverse">{L key="creator.tpl.viewweb"}</span>
			  		<div class="pad">{L key="creator.tpl.viewedit"}</div>
			  	</div>	
  			</a>	
   			<a href="{$HOME}admin/check/?back={base64_encode('/admin/content/pages/')}" class="typeBox">
  				<i class="fa fa-clipboard fa-5x"></i><br>
  				<div class="buttons">
			  		<span class="badge badge-inverse">{L key="creator.tpl.editpage"}</span>
			  		<div class="pad">{L key="creator.tpl.editadminpanel"}</div>
			  	</div>	
  			</a>
   			<a href="{$HOME}admin/check/?back={base64_encode("/admin/themes/themes/edit/{config::get('template')}/tpl_views/tpl_views/main_page.tpl/")}" class="typeBox">
  				<i class="fa fa-desktop fa-5x"></i><br>
  				<div class="buttons">
			  		<span class="badge badge-inverse">{L key="creator.tpl.edittempl"}</span>
			  		<div class="pad">{L key="creator.tpl.editcode"}</div>
			  	</div>	
  			</a> 			 	
   			<a href="{$HOME}admin/check/?back={base64_encode('/admin/system/system/')}" class="typeBox">
  				<i class="fa fa-tachometer fa-5x"></i><br>
  				<div class="buttons">
			  		<span class="badge badge-inverse">{L key="creator.tpl.sys"}</span>
			  		<div class="pad">{L key="creator.tpl.thisplace"}</div>
			  	</div>	
  			</a>   					  	
	  	{elseif $REQUEST->getVariable('action')==''}
  			<a href="{$HOME}admin/creator/selectTemplate/web/" class="typeBox">
  				<i class="fa fa-clipboard fa-5x"></i><br>
  				<div class="buttons">
			  		<span class="badge badge-inverse">{L key="creator.tpl.webst"}</span>
			  		<div class="pad">{L key="creator.tpl.simplepage"}</div>
			  	</div>	
  			</a>
  			<a href="{$HOME}admin/creator/selectTemplate/blog/" class="typeBox">
  				<i class="fa fa-calendar-o fa-5x"></i><br>
  				<div class="buttons">
			  		<span class="badge badge-inverse">{L key="creator.tpl.blog"}</span>
			  		<div class="pad">{L key="creator.tpl.blogsite"}</div>
			  	</div>
  			</a>	
  			<a href="{$HOME}admin/creator/selectTemplate/portal/" class="typeBox">
  				<i class="fa fa-sitemap fa-5x"></i><br>
  				<div class="buttons">
			  		<span class="badge badge-inverse">{L key="creator.tpl.portal"}</span>
			  		<div class="pad">{L key="creator.tpl.advsite"}</div>
			  	</div>
  			</a>	
  			<a href="{$HOME}admin/creator/selectTemplate/forum/" class="typeBox">
  				<i class="fa fa-comments fa-5x"></i><br>
  				<div class="buttons">
			  		<span class="badge badge-inverse">{L key="creator.tpl.forum"}</span>
			  		<div class="pad">{L key="creator.tpl.website"}</div>
			  	</div>
  			</a>  			
	  	{/if}	
	</div>
	<p class="text-shadow">Windu 3.1 rev. {config::get(revision)}</p>
</div>

