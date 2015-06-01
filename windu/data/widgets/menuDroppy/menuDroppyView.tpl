{if $params.droppyId==''}{$params.droppyId='droppyOne'}{/if}
{if $params.sort==''}{$params.sort='position ASC'}{/if}
{if $params.where==''}{$params.where="type != {pagesDB::TYPE_NEWS}"}{/if}
{assign activePagesId $data.pagesDB->hasActivePagesIdArray($request->getVariable(urlKey))}

{function name=menuDroppyTree}
	{foreach $pages as $page}
		{if $data.pagesDB->hasChild($page->id,$params.where)}
			<li>
				<a href="{if strlen($page->content)>3 or $params.hasContent!=true}{$HOME}{$page->urlKey}{else}#{/if}"  class="{if in_array($page->id,$activePagesId)}menuOpen{/if} {$page->menuCssClass}">{$page->name}</a>
				<ul>
				{menuDroppyTree pages=$data.pagesDB->getPagesByParent($page->id,$params.where,$params.sort,'*',$params.limit,null,true)}
				</ul>
			</li>
		{else}
			<li><a href="{$HOME}{$page->urlKey}"  class="{if in_array($page->id,$activePagesId)}menuOpen{/if} {$page->menuCssClass}">{$page->name}</a></li>
		{/if}
	{/foreach}
{/function}

<ul id="droppy" class="{$params.droppyId}">
{menuDroppyTree pages=$data.pagesDB->getPages($params.parent,$params.where,$params.sort,'*',$params.limit,null,true)}
</ul>
<script>
    {literal}
    $(document).ready(function(){
        $(function() {
            $('.{/literal}{$params.droppyId}{literal}').droppy({speed: 100});
        });
    });
    {/literal}
</script>
