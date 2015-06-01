{if $params.class==''}{$params.class = 'language-select-box'}{/if}
{if $params.showIcons==''}{$params.showIcons = true}{/if}
<div class="btn-group">
	{assign icon pagesDB::getMainImageEkey($smarty.const.LANG,'icon')}  
  	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><img src="{$HOME}image/{$icon}/100/100/original/">  <span class="caret"></span>
  	</button>
<ul class="dropdown-menu languagedropdown" role="menu">
    {foreach $data.pagesDB->getPagesByParent('0',null,'position ASC','*',null,null,true) as $lang}
    	{assign icon pagesDB::getMainImageEkey($lang->id,'icon')}
		<li>
			<a href="{$HOME}{$lang->urlKey}">
				{if !empty($icon) and $params.showIcons}
					<img src="{$HOME}image/{$icon}/100/100/original/">
				{/if}
				{$lang->name}
			</a>
		</li>
	{/foreach}
</ul>
</div>