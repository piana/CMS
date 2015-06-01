{$group = $data.forumGroupsDB->fetchRow("ekey = '{$data.fekey}' and status!=0")}
{$parentForumEkey = $data.forumsDB->get($group->forumId,'ekey')}
<div class="forum-buttons">
	<a href="{$HOME}{$data.pageUrlKey}?ftype=forum&fekey={$parentForumEkey}" class="btn btn-default">« {L key="widgets.forum.post.return"}</a>
	<div class="pull-right">
		<a href="{$HOME}do/setAllForumTopicReaded/{$group->ekey}/" class="btn btn-default">{L key="widgets.forum.group.markas"}</a>
		<a href="{$HOME}{$data.pageUrlKey}?ftype=addTopic&fekey={$group->ekey}" class="btn btn-primary">{L key="widgets.forum.group.addnewtopic"}</a>
	</div>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th></th>
			<th>{$group->name}</th>
			<th>{L key="widgets.forum.forums.stats"}</th>
			<th>{L key="widgets.forum.forums.lastpost"}</th>
		</tr>
	</thead>
	<tbody>
		{foreach $data.forumTopicsDB->fetchAll("groupId = '{$group->id}' and status!=0","updateTime DESC") as $topic}		
		<tr>
			<td class="forum-icon {if $data.user!=null}{if !in_array($topic->id,$data.readedArray)}forum-not-readed{/if}{/if}">
				<img src="{$HOME}data/widgets/forum/img/basic2-004.png">	
			</td>					
			<td>
				<p class="forum-title"><a href="{$HOME}{$data.pageUrlKey}?ftype=topic&fekey={$topic->ekey}">{$topic->name}</a></p>
				<p class="forum-description">{generate::showDatatime($topic->updateTime)}</p>			
			</td>
			<td class="forum-stat-column">
				<div class="forum-stat">
					{L key="widgets.forum.forums.posts"}: <strong>{$topic->postsCount}</strong><br>
					{L key="widgets.forum.group.views"}: <strong>{$topic->views}</strong>
				</div>
			</td>
			<td class="forum-last-column">
				<div class="forum-stat">
					{$lastPost = $data.forumTopicsDB->getLastPost($topic->id)}

                    {L key="widgets.forum.forums.added"}: {generate::showDatatime($lastPost->createTime,true,true)}<br>
                    {L key="widgets.forum.forums.by"}: <a href="{$HOME}{$data.pageUrlKey}?ftype=user&fekey={$lastPost->author->ekey}">{$lastPost->author->username}</a>
				</div>			
			</td>
		</tr>
		{/foreach}
	</tbody>
</table>
<div class="forum-buttons">
    <a href="{$HOME}{$data.pageUrlKey}?ftype=forum&fekey={$parentForumEkey}" class="btn btn-default">« {L key="widgets.forum.post.return"}</a>
    <div class="pull-right">
        <a href="{$HOME}do/setAllForumTopicReaded/{$group->ekey}/" class="btn btn-default">{L key="widgets.forum.group.markas"}</a>
        <a href="{$HOME}{$data.pageUrlKey}?ftype=addTopic&fekey={$group->ekey}" class="btn btn-primary">{L key="widgets.forum.group.addnewtopic"}</a>
    </div>
</div>
