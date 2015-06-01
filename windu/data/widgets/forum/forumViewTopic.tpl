{$topic = $data.forumTopicsDB->fetchRow("ekey = '{$data.fekey}' and status!=0")}
{$parentGroupEkey = $data.forumGroupsDB->get($topic->groupId,'ekey')}
<div class="forum-buttons">
    <a href="{$HOME}{$data.pageUrlKey}?ftype=group&fekey={$parentGroupEkey}" class="btn btn-default">« {L key="widgets.forum.viewtopic.backto"}</a>
    <div class="pull-right">
        <a href="{$HOME}{$data.pageUrlKey}?ftype=addPost&fekey={$topic->ekey}" class="btn btn-primary">{L key="widgets.forum.viewtopic.answer"}</a>
    </div>
</div>
<table class="table table-striped">
	<tbody>	
		{foreach $data.forumPostsDB->getPosts($topic->id) as $post}
		<tr>
			<td>
				{if $post->author!=null}
					{$post->author->username}<br>
				{else}
					{L key="widgets.forum.viewtopic.userdeleted"}
				{/if}

                {L key="widgets.forum.viewtopic.addedby"}: {generate::showDatatime($post->createTime,true,true)}<br>
			</td>
			<td>{$post->content}</td>
		</tr>
		{/foreach}
	</tbody>
</table>
<div class="forum-buttons">
    <a href="{$HOME}{$data.pageUrlKey}?ftype=group&fekey={$parentGroupEkey}" class="btn btn-default">« {L key="widgets.forum.viewtopic.backto"}</a>
    <div class="pull-right">
        <a href="{$HOME}{$data.pageUrlKey}?ftype=addPost&fekey={$topic->ekey}" class="btn btn-primary">{L key="widgets.forum.viewtopic.answer"}</a>
    </div>
</div>

