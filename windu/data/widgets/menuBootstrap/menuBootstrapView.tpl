{if $params.sort==''}{$params.sort='position ASC'}{/if}
{if $params.where==''}{$params.where="type != {pagesDB::TYPE_NEWS}"}{/if}
{assign activePagesId $data.pagesDB->hasActivePagesIdArray($request->getVariable(urlKey))}

{function name=menuDroppyTree}
	{foreach $pages as $page}
		{if $data.pagesDB->hasChild($page->id)}
			<li class="dropdown {if in_array($page->id,$activePagesId)}active{/if}">
				<a href="{if strlen($page->content)>3 or $params.hasContent!=true}{$HOME}{$page->urlKey}{else}#{/if}" data-toggle="dropdown" class="dropdown-toggle {$page->menuCssClass}" ><b class="caret"></b> {$page->name}</a>
				<ul class="dropdown-menu">
				{menuDroppyTree pages=$data.pagesDB->getPagesByParent($page->id,$params.where,$params.sort,'*',$params.limit,null,true)}
				</ul>
			</li>
		{else}
			<li class="{if in_array($page->id,$activePagesId)}active{/if}">
				<a href="{$HOME}{$page->urlKey}"  class="{$page->menuCssClass}">{$page->name}</a>
			</li>
		{/if}
	{/foreach}
{/function}

<ul class="nav">
{menuDroppyTree pages=$data.pagesDB->getPages($params.parent,$params.where,$params.sort,'*',$params.limit,null,true)}
</ul>
