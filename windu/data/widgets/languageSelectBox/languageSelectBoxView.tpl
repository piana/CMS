{if $params.class==''}{$params.class = 'language-select-box'}{/if}
{if $params.showIcons==''}{$params.showIcons = true}{/if}

<ul class="{$params.class}">	
    {foreach $data.pagesDB->getPagesByParent('0',null,'position ASC','*',null,null,true) as $lang}
    	{assign icon pagesDB::getMainImageEkey($lang->id,'icon')}
		<li>
			<a href="{$HOME}{$lang->urlKey}">
				{if !empty($icon) and $params.showIcons}
					<img src="{$HOME}image/{$icon}/100/100/original/">
				{else}
					{$lang->name}
				{/if}
			</a>
		</li>
	{/foreach}
</ul>