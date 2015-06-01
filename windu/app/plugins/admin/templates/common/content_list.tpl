{$nowDatetime = generate::sqlDatetime()}
{if $creator==1}{$creatorSelect = ' and status != 2'}{/if}
{function name=treelist} 
  {foreach $data as $entry} 
    {if $entry->type>=pagesDB::TYPE_LANG_CATALOG}
    	<li id="item-id-{$entry->id}" class="{if $entry->type==pagesDB::TYPE_GALLERY or $entry->type==pagesDB::TYPE_NEWS_GROUP}no-nest{/if}">
	    	<div class="{if $entry->id == $id}active{/if}">
				 {include file='common/content_list_icon.tpl' type=$entry->type name=$entry->name}
				 {if $entry->type==pagesDB::TYPE_LANG_CATALOG or $entry->type==pagesDB::TYPE_CATALOG or $entry->type==pagesDB::TYPE_NEWS_GROUP}
				 	<a href="{$HOME}admin/do/content/showTreelist/{$entry->id}/">{$entry->name|truncate:30}</a>
				 {else}
				 	{$entry->name|truncate:30}
				 {/if}
				 <div class="buttons">
					 {if $entry->type==pagesDB::TYPE_GALLERY}
						<a href="{$HOME}admin/content/pages/gallery/{$entry->id}/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
					 {elseif $entry->type==pagesDB::TYPE_NEWS_GROUP}
						<a href="{$HOME}admin/content/pages/news/{$entry->id}/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
					 {else}					 
					 	<a href="{$HOME}admin/content/pages/add/{$entry->id}/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
					 {/if}		
					 
					 {if $entry->type==pagesDB::TYPE_URL AND $entry->lock == 0}
					 	<a href="{$HOME}admin/content/pages/editUrl/{$entry->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a> 
					 {elseif $entry->lock == 0}
					 	<a href="{$HOME}admin/content/pages/edit/{$entry->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a> 
					 {else}
					 	<span><i class="fa fa-pencil icon-grey">&nbsp;</i></span>
					 {/if} 
					{if usersDB::isDeveloper() and $creator!==1} 		 
						<a class="smallWidthHidden" href="{$HOME}admin/do/content/duplicateItem/{$entry->id}/"><i class="fa fa-random icon-green">&nbsp;</i></a>
					{/if}
					{if $creator!==1} 	
						<span href="#" onclick="loadDoAction('{$HOME}admin/do/content/toggleHide/{$entry->id}/','#hidden-{$entry->id}')" id='hidden-{$entry->id}'><i class="fa fa-eye {if $entry->status == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></span>
					{/if}
					{if usersDB::isDeveloper() and $creator!==1}
						<span class="smallWidthHidden" onclick="loadDoAction('{$HOME}admin/do/content/toggleLoggedContent/{$entry->id}/','#loggedcontent-{$entry->id}')" id='loggedcontent-{$entry->id}'><i class="fa fa-lock {if $entry->logged == 1}icon-red{else}icon-grey{/if}">&nbsp;</i></span>
						<span class="smallWidthHidden" onclick="loadDoAction('{$HOME}admin/do/content/toggleLock/{$entry->id}/','#lock-{$entry->id}')" id='lock-{$entry->id}'><i class="fa fa-pencil-square {if $entry->lock == 1}icon-red{else}icon-grey{/if}">&nbsp;</i></span>
						<span class="smallWidthHidden" onclick="loadDoAction('{$HOME}admin/do/content/toggleSearchable/{$entry->id}/','#search-{$entry->id}')" id='search-{$entry->id}'><i class="fa fa-search {if $entry->searchable == 0}icon-red{else}icon-grey{/if}">&nbsp;</i></span>
					{/if}				
					
					{if $entry->lock == 0 and $entry->id != config::get('language-admin')}
						<span onclick="loadDoActionDelete('{$HOME}admin/do/content/delete/{$entry->id}/','#item-id-{$entry->id}',{if !usersDB::isDeveloper()}1{else}0{/if})"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
					{else}<span><i class="fa fa-times-circle icon-grey">&nbsp;</i></span>{/if}
					{if usersDB::isDeveloper() and $creator!==1}<p class="badge inline-block smallWidthHidden">{$entry->id}</p>{/if}
				</div>
			</div>
			{if $entry->type==pagesDB::TYPE_NEWS_GROUP}{assign sort 'date DESC'}{else}{assign sort 'position ASC'}{/if}
			{if cookie::readCookie(showAllOn)}
				<ul style="padding-left:20px;">{treelist data=$pagesDB->getPagesByParent($entry->id,"status !=0{$creatorSelect}",$sort)}</ul>
		    {else}
				{if $pagesDB->checkParentsOpen(unserialize(cookie::readCookie('contentOpenId')),$entry)}
		    	<ul style="padding-left:20px;">{treelist data=$pagesDB->getPagesByParent($entry->id,"status !=0{$creatorSelect}",$sort)}</ul>
		    	{/if}		    	
		    {/if}

    	</li>
	{else}
		<li id="item-id-{$entry->id}" class="no-nest {if $entry->id == $id}active{/if} {if $entry->date>=$nowDatetime}silver{/if}">
			<div>
				{include file='common/content_list_icon.tpl' type=$entry->type name=$entry->name}{$entry->name|truncate:30}
				<div class="buttons">
					 {if $entry->type==pagesDB::TYPE_URL AND $entry->lock == 0}
					 	<a href="{$HOME}admin/content/pages/editUrl/{$entry->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a> 
					 {elseif $entry->lock == 0}
					 	<a href="{$HOME}admin/content/pages/edit/{$entry->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a> 
					 {else}
					 	<span><i class="fa fa-pencil icon-grey">&nbsp;</i></span>
					 {/if}
					{if usersDB::isDeveloper() and $creator!==1} 		 
						<a class="smallWidthHidden" href="{$HOME}admin/do/content/duplicateItem/{$entry->id}/"><i class="fa fa-random icon-green">&nbsp;</i></a>
					{/if}
					{if $creator!==1}					 
						<span onclick="loadDoAction('{$HOME}admin/do/content/toggleHide/{$entry->id}/','#hidden-{$entry->id}')" id='hidden-{$entry->id}'><i class="fa fa-eye {if $entry->status == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></span>
					{/if}
					{if usersDB::isDeveloper() and $creator!==1}
						<span class="smallWidthHidden" onclick="loadDoAction('{$HOME}admin/do/content/toggleLoggedContent/{$entry->id}/','#loggedcontent-{$entry->id}')" id='loggedcontent-{$entry->id}'><i class="fa fa-lock {if $entry->logged == 1}icon-red{else}icon-grey{/if}">&nbsp;</i></span>
						<span class="smallWidthHidden" onclick="loadDoAction('{$HOME}admin/do/content/toggleLock/{$entry->id}/','#lock-{$entry->id}')" id='lock-{$entry->id}'><i class="fa fa-pencil-square {if $entry->lock == 1}icon-red{else}icon-grey{/if}">&nbsp;</i></span>
						<span class="smallWidthHidden" onclick="loadDoAction('{$HOME}admin/do/content/toggleSearchable/{$entry->id}/','#search-{$entry->id}')" id='search-{$entry->id}'><i class="fa fa-search {if $entry->searchable == 0}icon-red{else}icon-grey{/if}">&nbsp;</i></span>
					{/if}					
					{if $entry->lock == 0 and $creator!==1}
						<span onclick="loadDoActionDelete('{$HOME}admin/do/content/delete/{$entry->id}/','#item-id-{$entry->id}',{if !usersDB::isDeveloper()}1{else}0{/if})"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
					{else}<span><i class="fa fa-times-circle icon-grey">&nbsp;</i></span>{/if}
					{if usersDB::isDeveloper() and $creator!==1}<p class="badge inline-block smallWidthHidden">{$entry->id}</p>{/if}
				</div>
			</div>
		</li> 
	{/if} 
  {/foreach} 
{/function}

<ul class="sortable {if cookie::readCookie(sortableOn)}sortable-cursor{/if} list-bg" {if cookie::readCookie(sortableOn)}id="sortableTreeList"{/if}>
{treelist data=$pagesDB->getPagesByParent(0,"status !=0{$creatorSelect}")}
{treelist data=$pagesDB->getPagesByParent(-1,"status !=0{$creatorSelect}")}
</ul>  