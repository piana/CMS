{if $params.sort==''}{$params.sort='position ASC'}{/if}
{if $params.where==''}{$params.where="type != {pagesDB::TYPE_NEWS}"}{/if}
{assign activePagesId $data.pagesDB->hasActivePagesIdArray($request->getVariable(urlKey))}

{function name=menuIconsDroppy}
	{foreach $pages as $page}
		{assign mainImage $data.imagesDB->getFirstByBucket("icon-{$page->id}")}
		{if $data.pagesDB->hasChild($page->id)}
			<li>
				<a href="{if strlen($page->content)>3}{$HOME}{$page->urlKey}{else}#{/if}"  class="{if in_array($page->id,$activePagesId)}menuOpen{/if} {$page->menuCssClass}">
					{if $mainImage->ekey!=null}<p class="menuIconsDroppy-img"><img src='{$HOME}image/{$mainImage->ekey}/200/130/original/'></p>{/if}
					<p class="menuIconsDroppy-name">{$page->name}</p>
				</a>
				<ul>
				{menuIconsDroppy pages=$data.pagesDB->getPagesByParent($page->id,$params.where,$params.sort,'*',null,null,true)}
				</ul>
			</li>
		{else}
			<li>
				<a href="{$HOME}{$page->urlKey}"  class="{if in_array($page->id,$activePagesId)}menuOpen{/if} {$page->menuCssClass}">
					{if $mainImage->ekey!=null}
						<p class="menuIconsDroppy-img">
							<img src='{$HOME}image/{$mainImage->ekey}/200/130/original/'>
						</p>
					{/if}
					<p class="menuIconsDroppy-name">{$page->name}</p>
				</a>
			</li>
		{/if}
	{/foreach}
{/function}

<ul id="iconsDroppy">
{menuIconsDroppy pages=$data.pagesDB->getPages($params.parent,$params.where,$params.sort,'*',null,null,true)}
</ul>
