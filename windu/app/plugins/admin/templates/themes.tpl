<div class="tabbable">
	<div class="tab-content">
		{if $subpage=='help'}
			{include file='common/help.tpl' ekey=lang::read('admin.help.users')}
		{elseif $subpage=='themes'}
			{include file='common/themes.tpl'}
		{elseif $subpage=='widgets'}
			{include file='common/widgets.tpl'}
		{elseif $subpage=='config'}
			{include file='common/config.tpl' class='themes'}
		{/if}
	</div>
</div>

