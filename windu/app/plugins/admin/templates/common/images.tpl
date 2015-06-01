<div class="tab-menu-top">
	<a href="{$HOME}admin/content/images/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.images"}</h3>
	
	<a href="{$HOME}admin/content/images/addWatermark/" class="btn btn-small btn-info">{L key = "admin.common.images.tpl.addwatermark"}</a>
	<span class="line-vertical"></span>	
    <a href="{$HOME}admin/do/content/cleanImagesThumbs/" class="btn btn-small btn-warning">{L key = "admin.common.images.tpl.clear"}</a>
	<a href="{$HOME}admin/do/content/cleanImagesDatabase/" class="btn btn-danger btn-small">{L key = "admin.common.conservation.tpl.cleandatabase"}</a>	
	<span class="line-vertical"></span>	
	{if config::get("month_delete_thumbs")!=0}
		<a href="{$HOME}admin/do/tools/toggleCronConfig/month_delete_thumbs/" class="btn btn-success btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.conservation.tpl.thumbnailclear"}</a>
	{else}
		<a href="{$HOME}admin/do/tools/toggleCronConfig/month_delete_thumbs/" class="btn btn-danger btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.conservation.tpl.thumbnailclear"}</a>
	{/if}	
</div>	
<div class="row-fluid">
  {if isset($formAddWatermark)}
  	<div class="span6">
  		<div class="box">
			<img src="{$HOME}image/{$imagePatternWatermark->ekey}/1000/800/fit/">
  		</div>	
  	</div>	
  	<div class="span6">
  		<div class="box">
   			{if file_exists($watermarkImg)}
  				<div class="align-center"><img src="{$watermarkImgUrl}?"></div>
  			{/if} 			
  			{$formAddWatermark->toHtml()}
  		</div> 
  	</div>	
  {else}	
  	  {if !isset($formEditImage)} 
	  <div class="span2 mobileHidden">
		<div class="box pad margin-bottom align-center">
			{L key = "admin.common.images.tpl.numberimg"}
			<h2>{$imagesDB->fetchCount()}</h2>
		</div>	
		<div class="box pad margin-bottom align-center">
			{L key = "admin.common.images.tpl.gennumber"}
			<h2>{image::getThumbsCount()}</h2>
		</div>	
	  </div>
	  {/if}
	  
		{$pageCount = 20}
		{$page = $pageCount*$REQUEST->getVariable('p')}
		{$elementCount = $imagesDB->fetchCount()}

	  <div class="{if isset($formEditImage)}span5{else}span10{/if}">
	  	{include file='common/paginator.tpl' elementsCount=$elementCount count=$pageCount}	 
	  	<div class="box">
			<h5><i class="fa fa-picture-o icon-margin icon-grey">&nbsp;</i> {L key = "admin.common.images.tpl.photolist"}</h5>
			{if isset($formEditImage)}
				{include file='common/images_all_list.tpl'}
			{else}
				{include file='common/images_all_list.tpl' extended=1}
			{/if}
		</div>
		{include file='common/paginator.tpl' elementsCount=$elementCount count=$pageCount}	 
	  </div>
	  {if isset($formEditImage)}
	  	<div class="span7">
		  		<div class="box box-floating">
		  			<h5><i class="fa fa-pencil icon-margin icon-grey">&nbsp;</i> {L key = "admin.common.images.tpl.editimage"}</h5>
		  			<center class="pad"><img src='{$HOME}image/{$image->ekey}/500/200/fit/'></center>
		  			{$formEditImage->toHtml()}
		  		</div>
	  	</div>
	  {/if}
  {/if}
</div>	 
     	