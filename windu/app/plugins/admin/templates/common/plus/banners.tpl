<div class="tab-menu-top">
	<a href="{$HOME}admin/content/banners/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	 <h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.banners"}</h3>
</div>	
<div class="row-fluid">
	<div class="{if $REQUEST->getVariable('action')!='editBannerArea' AND $REQUEST->getVariable('action')!='editBanner' AND $REQUEST->getVariable('action')!='addBannersArea' AND $REQUEST->getVariable('action')!='showBanners' AND $REQUEST->getVariable('action')!='addBanner'}span12{else}span4{/if}">
		{if $bannersareasDB->fetchCount()==0 and $REQUEST->getVariable('action')!='addBannersArea'}
			<div class="center-box">
				<a href="{$HOME}admin/content/banners/addBannersArea/" class="btn btn-large">
					<i class="fa fa-plus-circle fa-2x"></i>
					{L key="admin.tools.tpl.addarea"}
				</a>
			</div>	
		{else}
			<div class="box">
				<h5>
					<i class="fa fa-th icon-margin icon-grey"></i> {L key="admin.tools.tpl.banners.area"}
				  	<div class="buttons">
				  		<a href="{$HOME}admin/content/banners/addBannersArea/" class="btn btn-primary btn-small">{L key="admin.tools.tpl.banners.addarea"}</a>
				  	</div>				
				</h5>
				<table class="table table-striped">
				  <tbody>
					{foreach $bannersareasDB->fetchAll() as $bannerArea}
				    <tr {if ($bannerArea->id == $REQUEST->getVariable('id') and $REQUEST->getVariable('action')!='editBanner')}class="active"
						{elseif is_numeric($REQUEST->getVariable('id'))}
							{if ($bannersDB->fetchRow("name={$REQUEST->getVariable('id')}")->areaId == $bannerArea->id and $REQUEST->getVariable('action')=='editBanner')}class="active active-silver"{/if}
						{/if}>
				      <td>
				      	<i class="color-icons icons-cheque icon-margin"> </i>
						{$bannerArea->name}
				      </td>
				      <td>{$bannerArea->width} x {$bannerArea->height}</td>		
				      <td><span class="badge badge-inverse">{$bannerArea->id}</span></td> 
				      {if $REQUEST->getVariable('action')==''}<td>{literal}{{W name=banner area={/literal}{$bannerArea->id}{literal}}}{/literal}</td>{/if}     
				      <td>
					    <div class="buttons buttons-five">
					    	<a href="{$HOME}admin/content/banners/showBanners/{$bannerArea->id}/"><i class="fa fa-align-justify icon-blue">&nbsp;</i></a>
					    	<a href="{$HOME}admin/content/banners/addBanner/{$bannerArea->id}/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
					    	<a href="{$HOME}admin/content/banners/editBannerArea/{$bannerArea->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
					    	<span href="#" onclick="loadDoAction('{$HOME}admin/do/content/toggleBannersActivate/{$bannerArea->id}/','#bannerareastatus-{$bannerArea->id}')" id='bannerareastatus-{$bannerArea->id}'><i class="fa fa-eye {if $bannerArea->status == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></span>
					      	<a href="{$HOME}admin/do/content/deleteBannerArea/{$bannerArea->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
					    	
					    </div>
				      </td>
				    </tr>
				    {foreachelse}
				    <tr>	
				    	<td>
				    		{L key="admin.tools.tpl.banners.nodata"}
				    	</td>
				    </tr>
					{/foreach}	  	
				  </tbody>
				</table>
			</div>
		{/if}
	</div>
	
	{if is_object($bannerAreaForm)}
		<div class="span8">
			<div class="box">
				<h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> {L key="admin.tools.tpl.banners.addarea"}</h5>
				{$bannerAreaForm->toHtml()}
			</div>
		</div>	
	{elseif is_object($bannerForm)}
		<div class="span3">
			<div class="box">
				<h5>
					<i class="icon-facetime-video icon-margin icon-grey"></i> {L key="admin.tools.tpl.banners"}
				  	<div class="buttons">
				  		<a href="{$HOME}admin/content/banners/addBanner/{$REQUEST->getVariable('id')}/" class="btn btn-primary btn-small">{L key="admin.tools.tpl.banners.addbanner"}</a>
				  	</div>						
				</h5>
				<table class="table table-striped">
				  <tbody>
				  	{assign 'idbannerlist' $bannersDB->fetchRow("id='{$REQUEST->getVariable('id')}'")->areaId}
				  	{if $idbannerlist!=null}
				  		{$banners =  $bannersDB->fetchAll("areaId='{$idbannerlist}'")}
				  	{else}
				  		{$banners = $bannersDB->fetchAll("areaId={$REQUEST->getVariable('id')}")}
				  	{/if}

					{foreach $banners as $banner}
				    <tr {if $banner->id == $REQUEST->getVariable('id')}class="active"{/if}>
				      <td>
				      	<i class="color-icons icons-mail-open-document-text icon-margin"> </i>
						{$banner->name}
				      </td>
				      <td>
					    <div class="buttons buttons-four">
					    	<span href="#" onclick="loadDoAction('{$HOME}admin/do/content/toggleBannerActivate/{$banner->id}/','#bannerstatus-{$banner->id}')" id='bannerstatus-{$banner->id}'><i class="fa fa-eye {if $banner->status == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></span>
				      		<span href="#" onclick="loadDoAction('{$HOME}admin/do/content/toggleBannerCookie/{$banner->id}/','#bannercookie-{$banner->id}')" id='bannercookie-{$banner->id}'><i class="fa fa-map-marker {if $banner->cookieCheck == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></span>

					    	<a href="{$HOME}admin/content/banners/editBanner/{$banner->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
					      	<a href="{$HOME}admin/do/content/deleteBanner/{$banner->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
					    </div>
				      </td>
				    </tr>
					{/foreach}	  	
				  </tbody>
				</table>
			</div>
		</div>	
		<div class="span5">
			<div class="box">
				<h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> {L key="admin.tools.tpl.banners.addbanner"}</h5>			
				{$bannerForm->toHtml()}
			</div>
		</div>
	{else}
		{if $REQUEST->getVariable('action')=='showBanners'}		
		<div class="span8">
			<div class="box">
				<h5>
					<i class="icon-facetime-video icon-margin icon-grey"></i> {L key="admin.tools.tpl.banners"}
				  	<div class="buttons">
				  		<a href="{$HOME}admin/content/banners/addBanner/{$REQUEST->getVariable('id')}/" class="btn btn-primary btn-small">{L key="admin.tools.tpl.banners.addbanner"}</a>
				  	</div>						
				</h5>
				<table class="table table-striped">
				  <tbody>
					{foreach $bannersDB->fetchAll("areaId={$REQUEST->getVariable('id')}") as $banner}
				    <tr>
				      <td>
				      	<i class="color-icons icons-mail-open-document-text icon-margin"> </i>
						{$banner->name}
				      </td>
				      <td>{$banner->views}</td>	
				      <td>{$banner->clicks}</td>
				      <td>{$banner->viewsLimit}</td>
				      <td>{$banner->clicksLimit}</td>
				      <td>{$banner->link}</td>			      
				      <td>
					    <div class="buttons buttons-four">
					    	<span href="#" onclick="loadDoAction('{$HOME}admin/do/content/toggleBannerActivate/{$banner->id}/','#bannerstatus-{$banner->id}')" id='bannerstatus-{$banner->id}'><i class="fa fa-eye {if $banner->status == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></span>
				      		<span href="#" onclick="loadDoAction('{$HOME}admin/do/content/toggleBannerCookie/{$banner->id}/','#bannercookie-{$banner->id}')" id='bannercookie-{$banner->id}'><i class="fa fa-map-marker {if $banner->cookieCheck == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></span>
					    
					    	<a href="{$HOME}admin/content/banners/editBanner/{$banner->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
					      	<a href="{$HOME}admin/do/content/deleteBanner/{$banner->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
					    </div>
				      </td>
				    </tr>
					{/foreach}	  	
				  </tbody>
				</table>
			</div>
		</div>
		{elseif $REQUEST->getVariable('action')=='editBanner'}
			<div class="span3">
				<div class="box">
					<h5>
						<i class="icon-facetime-video icon-margin icon-grey"></i> {L key="admin.tools.tpl.banners"}
					  	<div class="buttons">
					  		<a href="{$HOME}admin/content/banners/addBanner/{$REQUEST->getVariable('id')}/" class="btn btn-primary btn-small">{L key="admin.tools.tpl.banners.addbanner"}</a>
					  	</div>						
					</h5>
					<table class="table table-striped">
					  <tbody>
					  	{assign 'idbannerlist' $bannersDB->fetchRow("id={$REQUEST->getVariable('id')}")->areaId}
	
						{foreach $bannersDB->fetchAll("areaId={$idbannerlist}") as $banner}
					    <tr {if $banner->id == $REQUEST->getVariable('id')}class="active"{/if}>
					      <td>
					      	<i class="color-icons icons-mail-open-document-text icon-margin"> </i>
							{$banner->name}
					      </td>
					      <td>
						    <div class="buttons buttons-four">
					    	<span href="#" onclick="loadDoAction('{$HOME}admin/do/content/toggleBannerActivate/{$banner->id}/','#bannerstatus-{$banner->id}')" id='bannerstatus-{$banner->id}'><i class="fa fa-eye {if $banner->status == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></span>
				      		<span href="#" onclick="loadDoAction('{$HOME}admin/do/content/toggleBannerCookie/{$banner->id}/','#bannercookie-{$banner->id}')" id='bannercookie-{$banner->id}'><i class="fa fa-map-marker {if $banner->cookieCheck == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></span>						    
						    
						    	<a href="{$HOME}admin/content/banners/editBanner/{$banner->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
						      	<a href="{$HOME}admin/do/content/deleteBanner/{$banner->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
						    </div>
					      </td>
					    </tr>
						{/foreach}	  	
					  </tbody>
					</table>
				</div>
			</div>
			<div class="span5">
				<div class="box">
					<h5><i class="icon-facetime-video icon-margin icon-grey"></i>{L key="admin.tools.tpl.banners"}</h5>
					{$banner = $bannersDB->fetchRow("id={$REQUEST->getVariable('id')}")}
					{$bannerArea = $bannersareasDB->fetchRow("id={$banner->areaId}")}
					{$file = $filesDB->fetchRow("ekey='{$banner->fileEkey}'")}
					<div class="pad">
						<h4 class="align-center">{literal}{{W name=banner area=1}}{/literal}</h4>
						{if $file->type=='swf'}
							<object width="100%">
							    <param name="movie" value="{$HOME}data/files/{$file->path}/{$file->fileName}">
							    <embed src="{$HOME}data/files/{$file->path}/{$file->fileName}">
							    </embed>
							</object>
						{else}
							<img src="{$HOME}data/files/{$file->path}/{$file->fileName}">
						{/if}
					</div>
					{$bannerForm->toHtml()}
				</div>
			</div>			
		{/if}
	{/if}
</div>