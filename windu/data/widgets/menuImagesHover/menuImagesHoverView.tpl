{if $params.sort==''}{$params.sort='position ASC'}{/if}
{if $params.where==''}{$params.where="type != {pagesDB::TYPE_NEWS}"}{/if}
{assign activePagesId $data.pagesDB->hasActivePagesIdArray($request->getVariable(urlKey))}

{foreach $data.pagesDB->getPages($params.parent,$params.where,$params.sort,'*',null,null,true) as $page}
<div style="display:inline-block; width:25%; height:300px; padding:0px; margin:-2px!important;">
	<a href="{$HOME}{$page->urlKey}"  class="{if in_array($page->id,$activePagesId)}menuOpen{/if} {$page->menuCssClass}">
	  <div class="imghoverlist" style="background-image:url('{$HOME}image/{pagesDB::getMainImageEkey($page->id)}/500/300/smart/original/');">
	  	<h2>{$page->name}</h2>
	  </div>
	  
	  <div class="imghoverlisthover" style="background-image:url('{$HOME}image/{pagesDB::getMainImageEkey($page->id)}/500/300/smart/bw/');" onmouseover="$(this).css('opacity', '0');" onmouseout="$(this).css('opacity', '1');"></div>
	</a>
</div>
{/foreach}