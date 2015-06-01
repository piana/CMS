{if !isset($params.count)}{$params.count = config::get(tagsCount)}{/if}
{if !isset($params.cssUl)}{$params.cssUl = 'tagsList'}{/if}
{if !isset($params.cssLi)}{$params.cssLi = ''}{/if}
{if !isset($params.showCount)}{$params.showCount = true}{/if}


{assign urlKey $data.pagesDB->get($params.targetPage,'urlKey')}
{assign tags explode(',',$params.page->tags)}
{if !empty($tags)}
	<ul class="{$params.cssUl}">
	{foreach $tags as $tag}
      {if $tag!='slider'}
	  <li class="{$params.cssLi}">
	 	<a href="{$HOME}{$urlKey}/{base64_encode(generate::cleanLinkKey($tag))}">{$tag|ucfirst}</a>
	  </li>
      {/if}
	{/foreach}
	</ul>
{else}
	<div class="pad">
		{L key="content.list.show.noresults"}
	</div>		
{/if}