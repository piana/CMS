{if $params.sort==''}{$params.sort='position ASC'}{/if}
{if $params.where==''}{$params.where="type != {pagesDB::TYPE_NEWS}"}{/if}
{assign activePagesId $data.pagesDB->hasActivePagesIdArray($request->getVariable(urlKey))}

{function name=menuNormalTree}
	{foreach $pages as $page}
    	{if $params.hasContent!=true or $page->content|count_characters>3}
          {if $data.pagesDB->hasChild($page->parentId)}
              <li>
                  <a href="{$HOME}{$page->urlKey}" class="{if in_array($page->id,$activePagesId)}menuOpen{/if} {$page->menuCssClass}">{$page->name}</a>
                  <ul>
                  {if ($params.closed != true and in_array($page->id,$activePagesId)) or ($params.open == true)}
                      {menuNormalTree pages=$data.pagesDB->getPagesByParent($page->id,$params.where,$params.sort,'*',$params.limit,null,true)}
                  {/if}
                  </ul>
              </li>
          {else}
              <li><a href="{$HOME}{$page->urlKey}" {if in_array($page->id,$activePagesId)}class="menuOpen"{/if}>{$page->name}</a></li>
          {/if}
        {else}
        	<li>{$page->name}</li>
        {/if} 
	{/foreach}
{/function}

<ul class="{$params.class}">
{menuNormalTree pages=$data.pagesDB->getPages($params.parent,$params.where,$params.sort,'*',$params.limit,null,true)}
</ul>
