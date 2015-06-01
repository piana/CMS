{assign page $params.page}
{if $page==''}{$page=1}{/if}
{$parent = $params.group}
{$now = generate::sqlDatetime()}
{$elementsCount = $data.pagesDB->fetchCount("parentId=$parent and status=1 and date<='$now'")}

{if !isset($params.pageLimit)}{$params.pageLimit = 8}{/if}
{assign pageLimit $params.pageLimit}
{assign pages $elementsCount/$params.count}
{assign pages $pages|@ceil}

{if $pages>1}
<div class="pagination pagination-centered">
	<ul>
		<li><a href="{router::selfLink()}?p=0">first</a></li>
		<li {if $page==0}class="disabled"{/if}><a href="{if $page!=0}{router::selfLink()}?p={$page-1}{else}#{/if}">«</a></li>
		{if $pages>$pageLimit}
			{$pagesStop=$page+$pageLimit/2}
			{$pagesStart=$page-$pageLimit/2}
			{if $pagesStart < 1}
				{$pagesStart=0}
				{$pagesStop=$pageLimit}
			{/if}
			{if $pagesStop >= $pages}
				{$pagesStart=$pages-$pageLimit-1}
				{$pagesStop=$pages-1}
			{/if}			
		{else}
			{$pagesStart=0}
			{$pagesStop=$pages}
		{/if}

		{for $pageNum=$pagesStart to $pagesStop-1}
			<li {if $pageNum==$page}class="active"{/if}><a href="{router::selfLink()}?p={$pageNum}">{$pageNum}</a></li>
		{/for}
		<li {if $page==$pages-1}class="disabled"{/if}><a href="{if $page!=$pages-1}{router::selfLink()}?p={$page+1}{else}#{/if}">»</a></li>
		<li><a href="{router::selfLink()}?p={$pages-1}">last</a></li>
	</ul>
</div>
{/if}


