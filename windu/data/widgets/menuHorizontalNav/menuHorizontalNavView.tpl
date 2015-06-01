{if $params.sort==''}{$params.sort='position ASC'}{/if}
{if $params.where==''}{$params.where="type != {pagesDB::TYPE_NEWS}"}{/if}
{assign activePagesId $data.pagesDB->hasActivePagesIdArray($request->getVariable(urlKey))}

{function name=menuNormalTree}
	{foreach $pages as $page}
		<li><a href="{$HOME}{$page->urlKey}" {if in_array($page->id,$activePagesId)}class="menuOpen"{/if}>{$page->name}</a></li>
	{/foreach}
{/function}

<nav class="horizontal-nav full-width">
  <ul class="{$params.class}">
  {menuNormalTree pages=$data.pagesDB->getPages($params.parent,$params.where,$params.sort,'*',null,null,true)}
  </ul>
</nav>
