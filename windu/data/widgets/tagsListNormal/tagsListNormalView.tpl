{if !isset($params.count)}{$params.count = config::get(tagsCount)}{/if}
{if !isset($params.cssUl)}{$params.cssUl = 'tagsList'}{/if}
{if !isset($params.cssLi)}{$params.cssLi = ''}{/if}
{if !isset($params.showCount)}{$params.showCount = true}{/if}


{assign urlKey $data.pagesDB->get($params.targetPage,'urlKey')}
{assign tags $data.pagesDB->getAllTags(null,$params.count)}

{if !empty($tags)}
	<ul class="{$params.cssUl}">
	{foreach $tags as $tag}
	  <li class="{$params.cssLi}">
	 	{if $params.showCount}<span class="badge">{$tag.count}</span> {/if}<a href="{$HOME}{$urlKey}/{base64_encode(generate::cleanLinkKey($tag.name))}">{$tag.name|ucfirst}</a>
	  </li>
	{/foreach}
	</ul>
{else}
	<div class="pad">
		{L key="content.list.show.noresults"}
	</div>		
{/if}