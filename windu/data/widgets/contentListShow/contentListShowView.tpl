{if !isset($params.imageWidth)}{$params.imageWidth = config::get(imgSmallWidth)}{/if}
{if !isset($params.imageHeight)}{$params.imageHeight = config::get(imgSmallHeight)}{/if}
{if !isset($params.fit)}{$params.fit = config::get(imgFit)}{/if}
{if !isset($params.filter)}{$params.filter = config::get(imgFilter)}{/if}

{if !isset($params.count)}{$params.count = config::get(contentListCount)}{/if}
{if !isset($params.length)}{$params.length = config::get(contentListLength)}{/if}

{if !isset($params.cssUl)}{$params.cssUl = 'tagsShowList'}{/if}
{if !isset($params.cssLi)}{$params.cssLi = ''}{/if}

{if !isset($params.showDate)}{$params.showDate = true}{/if}
{if !isset($params.showAuthor)}{$params.showAuthor = true}{/if}
{if !isset($params.showSource)}{$params.showSource = true}{/if}

{if !isset($params.limit)}{$params.limit = 10}{/if}
{if !isset($params.elementtype)}{$params.elementtype = 2}{/if}

{if !isset($params.type)}
	{$sort = 'createTime ASC'}
{elseif $params.type=='lastest'}
	{$sort = 'date DESC'}
{elseif $params.type=='views'}
	{$sort = 'views DESC'}
{elseif $params.type=='position'}
	{$sort = 'position ASC'}  
{elseif $params.type=='position-group'}
	{$sort = 'parentId ASC,position ASC'}      
{elseif $params.type=='author'}
	{$sort = 'createTime DESC'}
	{$where = " AND authorId = {$params.authorId}"}	
{/if}

{$dateNow = generate::sqlDatetime()}

{if !empty($params.bucket)}
	{assign results $data.pagesDB->getAllBucketPagesSmart($params.bucket,"type={$params.elementtype} {$where} and (date is null or date <= '$dateNow')",$sort,'*',$params.limit)}
{else}
	{assign results $data.pagesDB->getAllPagesSmart("type={$params.elementtype}{$where} and (date is null or date <= '$dateNow')",$sort,'*',$params.limit)}
{/if}


{if !empty($results)}
<ul class="{$params.cssUl}">
{foreach $results as $page}
  <li class="{$params.cssLi}">
    <a href="{$HOME}{$page->urlKey}">
  	{if $page->hasImage}
  	
  		<img src="{$HOME}image/{pagesDB::getMainImageEkey($page->id)}/{$params.imageWidth}/{$params.imageHeight}/{$params.fit}/{$params.filter}/" class="pull-left img-margin">
 	
 	{/if}
 	<h4>{$page->name}</h4>
    {if $params.showAuthor or $params.showDate or $params.showSource}
	    <p class="contentLastest-meta">
	    	{if $params.showSource}<a href="{$HOME}{$data.pagesDB->get($page->parentId,'urlKey')}"><span class="label label-important margin-right">{$data.pagesDB->get($page->parentId,'name')}</span></a>{/if}
	    	{if $params.showAuthor}<span class="label label-inverse margin-right">{$data.usersDB->get($page->authorId,'username')}</span>{/if}
          {if $params.showDate}<span class="label margin-right">{$page->date}</span>{/if}
		</p>
	{/if} 	
 	{$page->content|strip_tags|truncate:$params.length}
    </a>
  </li>
{/foreach}
</ul>
{else}
<div class="pad">
	{L key="content.list.show.noresults"}
</div>	
{/if}