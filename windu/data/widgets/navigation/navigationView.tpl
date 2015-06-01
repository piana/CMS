<ul class="breadcrumb">
  {$page = $data.page}
  {if $page->parentId!=0}
  	<li><a href="{$HOME}">Home</a> <span class="divider">/</span></li>
	{while  $page->parentId > 0}
		{$page = $data.pagesDB->fetchRow("id = {$page->parentId}")}
	  	{$allPages[] = $page}
	{/while}
	  
	{$pom = asort($allPages)}
	
	{foreach $allPages as $page}
	 	{if $page->status == 1 and $page->parentId != 0}
  <li><a href="{$HOME}{$page->urlKey}">{$page->name|truncate:40}</a> <span class="divider">/</span></li>
	  	{/if}
	{/foreach}
	<li class="active">{$data.page->name|truncate:40}</li>
  {else}
  	<li><a href="{$HOME}">Home</a></li> 
  {/if}
</ul>