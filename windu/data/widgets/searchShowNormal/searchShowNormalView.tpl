{if !isset($params.imageWidth)}{$params.imageWidth = config::get(imgSmallWidth)}{/if}
{if !isset($params.imageHeight)}{$params.imageHeight = config::get(imgSmallHeight)}{/if}
{if !isset($params.fit)}{$params.fit = config::get(imgFit)}{/if}
{if !isset($params.filter)}{$params.filter = config::get(imgFilter)}{/if}

{if !isset($params.cssUl)}{$params.cssUl = 'searchList'}{/if}
{if !isset($params.cssLi)}{$params.cssLi = ''}{/if}
{if !isset($params.length)}{$params.length = config::get(contentListLength)}{/if}

{if !isset($params.showDate)}{$params.showDate = true}{/if}
{if !isset($params.showAuthor)}{$params.showAuthor = true}{/if}
{if !isset($params.showSource)}{$params.showSource = true}{/if}
{if !isset($params.showMatchCount)}{$params.showMatchCount = true}{/if}

{assign results $data.pagesDB->fetchSearch(generate::sqlInjesctionStringSecure(urldecode($request->getVariable('id'))),array('tags','name','content'), null, null, '*', null, null, array())}
{if !empty($results)}
	<ul class="{$params.cssUl}">
	{foreach $results  as $page}
	  <li class="{$params.cssLi}">
	  	{if $page->hasImage}
	  	<a href="{$HOME}{$page->urlKey}">
	  		<img src="{$HOME}image/{pagesDB::getMainImageEkey($page->id)}/{$params.imageWidth}/{$params.imageHeight}/{$params.fit}/{$params.filter}/" class="pull-left img-margin">
	 	</a>
	 	{/if}
	 	<h4><a href="{$HOME}{$page->urlKey}">{$page->name}</a></h4>
	    {if $params.showAuthor or $params.showDate or $params.showSource or $params.showMatchCount}
		    <p class="searchShow-meta">
		    	{if $params.showMatchCount}<span class="label margin-right">{$page->searchElementsCount}</span>{/if}
		    	{if $params.showSource}<a href="{$HOME}{$data.pagesDB->get($page->parentId,'urlKey')}"><span class="label label-important margin-right">{$data.pagesDB->get($page->parentId,'name')}</span></a>{/if}
	    		{if $params.showAuthor}<span class="label margin-right">{$data.usersDB->get($page->authorId,'username')}</span>{/if}
				{if $params.showDate}{$page->date}{/if}
			</p>
		{/if} 	
	 	
	 	{$page->content|strip_tags|truncate:$params.length}
	  </li>
	{/foreach}
	</ul>
{else}
<div class="pad">
	{L key="search.show.noresults"}
</div>	
{/if}