<div class="tabbable">
	<div class="tab-content">
		{if $subpage=='help'}
			{include file='common/help.tpl' ekey=lang::read('admin.help.forum')}
		{elseif $subpage=='forums' or count($forums)==0}
			{include file='common/forums.tpl'}
		{elseif $subpage=='posts'}
			{include file='common/forumPosts.tpl'}
		{elseif $subpage=='stats'}
			{include file='common/forumStats.tpl'}
		{elseif $subpage=='config'}
			{include file='common/config.tpl' class='forum'}
		{/if}

	</div>
</div>
