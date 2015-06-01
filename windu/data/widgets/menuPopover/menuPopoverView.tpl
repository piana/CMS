{if $params.sort==''}{$params.sort='position ASC'}{/if}
{if $params.where==''}{$params.where="type != {pagesDB::TYPE_NEWS}"}{/if}
{assign activePagesId $data.pagesDB->hasActivePagesIdArray($request->getVariable(urlKey))}

{function name=menuPopoverTree}
	{foreach $pages as $page}
			<li class="menuPopover">
				{if $page->description!=null}
				<div class="menuPopover-popover">
					<h1>{$page->description}</h1>
				</div>
				{/if}
				<a href="{$HOME}{$page->urlKey}" {if in_array($page->id,$activePagesId)}class="menuOpen"{/if}>{$page->title|truncate:30:"":false}</a>
			</li>
	{/foreach}
{/function}

<ul class="{$params.class} menuPopover">
{menuPopoverTree pages=$data.pagesDB->getPages($params.parent,$params.where,$params.sort,'*',null,null,true)}
</ul>
