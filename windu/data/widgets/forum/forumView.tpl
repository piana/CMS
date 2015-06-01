<div class="forum">
	{if $data.listType=='forum'}
		{include file='forumViewForum.tpl'}
	{elseif $data.listType=='group'}
		{include file='forumViewGroup.tpl'}
	{elseif $data.listType=='topic'}
		{include file='forumViewTopic.tpl'}
	{elseif $data.listType=='addTopic'}
        {include file='forumViewAddTopic.tpl'}
	{elseif $data.listType=='addPost'}
        {include file='forumViewAddPost.tpl'}
	{elseif $data.listType=='user'}
		{include file='forumViewUser.tpl'}		
	{else}
		{include file='forumViewForums.tpl'}
	{/if}
</div>