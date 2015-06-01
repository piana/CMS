<div class="tabbable">
	<div class="tab-content">
		{if $subpage=='help'}
			{include file='common/help.tpl' ekey=lang::read('admin.help.users')}
		{elseif $subpage=='admins'}
			{include file='common/admins.tpl'}
		{elseif $subpage=='users'}
			{include file='common/users.tpl'}
		{elseif $subpage=='authorization'}
			{include file='common/pro/authorization.tpl'}
		{elseif $subpage=='config'}
			{include file='common/config.tpl' class='users'}
		{elseif $subpage=='history'}
			{include file='common/pro/history.tpl'}
        {elseif $subpage=='moderator'}
            {include file='common/moderator.tpl'}
		{/if}
	</div>
</div>