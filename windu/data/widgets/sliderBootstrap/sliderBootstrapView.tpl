{if !isset($params.width)}{$params.width = config::get(imgBigWidth)}{/if}
{if !isset($params.height)}{$params.height = config::get(imgBigHeight)}{/if}
{if !isset($params.fit)}{$params.fit = config::get(sliderImageFit)}{/if}
{if !isset($params.filter)}{$params.filter = config::get(sliderImageFilter)}{/if}
{if !isset($params.contentLenght)}{$params.contentLenght = config::get(sliderContentLength)}{/if}
{if !isset($params.count)}{$params.count = config::get(sliderCount)}{/if}
{if !isset($params.showContent)}{$params.showContent = true}{/if}

{$dataNow = generate::sqlDatetime()}

{if $params.imagesBucket!=''}
	{assign images $data.imagesDB->getByBucket($params.imagesBucket,'position ASC','*',$params.count)}
	{assign descriptionColName 'description'}
{elseif $params.pagesBucket!=''}
	{assign images $data.pagesDB->getPagesByParentMulti($params.pagesBucket,'hasImage = 1 and status = 1','date DESC,createTime DESC','*',$params.count)}
	{assign descriptionColName 'content'}
{elseif $params.tagsBucket!=''}
	{assign images $data.pagesDB->getPagesByTag($params.tagsBucket,"hasImage = 1 and status = 1 and date <= '$dataNow'",'date DESC,createTime DESC','*',$params.count)}	
	{assign descriptionColName 'content'}	
{elseif $params.images!=''}
	{assign images $params.images}
	{assign descriptionColName 'description'}
{/if}


<div id="sliderBootstrap" class="carousel slide">
	<ol class="carousel-indicators">
	     <li data-target="#sliderBootstrap" data-slide-to="0" class="active"></li>
         {for $foo=1 to count($images)-1}
        	<li data-target="#sliderBootstrap" data-slide-to="{$foo}"></li>
         {/for}
	</ol>

	<div class="carousel-inner">
	{foreach $images as $img name=foo}
		<div class="{if $smarty.foreach.foo.first}active {/if}item">
			{if $params.pagesBucket!='' or $params.tagsBucket!=''}
				<a href="{$HOME}{$img->urlKey}">
					<img src="{$HOME}image/{pagesDB::getMainImageEkey($img->id)}/{$params.width}/{$params.height}/{$params.fit}/{$params.filter}/" title='{$img->name|strip_tags|truncate:$params.contentLenght}'>
				</a>
				{if $img->$descriptionColName != null and $params.showContent==true}
				<div class="container">
					<div class="carousel-caption">
						<h4>{$img->name}</h4>
						<p>{$img->$descriptionColName|strip_tags|truncate:$params.contentLenght}</p>
					</div>	
				</div>
				{/if}					
			{else}
				<img src="{$HOME}image/{$img->ekey}/{$params.width}/{$params.height}/{$params.fit}/{$params.filter}/" title='{$img->description|strip_tags|truncate:$params.contentLenght}'>
				{if $img->$descriptionColName != null and $params.showContent==true}
				<div class="container">
					<div class="carousel-caption">
						<h4>{$img->name}</h4>
						<p>{$img->$descriptionColName|strip_tags|truncate:$params.contentLenght}</p>
					</div>	
				</div>	
				{/if}				
			{/if}
							
		</div>	
	{/foreach}
	</div>	

	<a class="carousel-control left" href="#sliderBootstrap" data-slide="prev">‹</a>
	<a class="carousel-control right" href="#sliderBootstrap" data-slide="next">›</a>	
</div> 