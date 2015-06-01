{if is_numeric($params.id)}
    {$forumWhere = "id={$params.id} AND "}
{else}
    {$forumWhere = ""}
{/if}
{foreach $data.forumsDB->fetchAll("{$forumWhere}status!=0",'position ASC') as $forum}
	<table class="table table-striped">
		<thead>
			<tr>
				<th></th>
				<th><a href="{$HOME}{$data.pageUrlKey}?ftype=forum&fekey={$forum->ekey}">{$forum->name}</a></th>
				<th>{L key="widgets.forum.forums.stats"}</th>
				<th>{L key="widgets.forum.forums.lastpost"}</th>
			</tr>
		</thead>
		<tbody>	
			{foreach $data.forumGroupsDB->fetchAll("forumId = {$forum->id} and status!=0","position ASC") as $group}		
			<tr>
				<td class="forum-icon {if $data.user!=null}{if $data.forumReadedLog->getReadedGroupCountByUser($data.user->id,$group->id)<$data.forumTopicsDB->fetchCount("groupId={$group->id} and status!=0")}forum-not-readed{/if}{/if}">
					<img src="{$HOME}data/widgets/forum/img/basic2-004.png">	
				</td>
				<td>
					<p class="forum-title"><a href="{$HOME}{$data.pageUrlKey}?ftype=group&fekey={$group->ekey}">{$group->name}</a></p>
					<p class="forum-description">{$group->description|truncate:100}</p>
				</td>
				<td class="forum-stat-column">
					<div class="forum-stat">
						{L key="widgets.forum.forums.topics"}: <strong>{$group->topicsCount}</strong><br>
						{L key="widgets.forum.forums.posts"}: <strong>{$group->postsCount}</strong>
					</div>
				</td>
				<td class="forum-last-column">
					<div class="forum-stat">
						{$lastPost = $data.forumGroupsDB->getLastPost($group->id)}
                        {if $lastPost==null}
                            <a href="{$HOME}{$data.pageUrlKey}?ftype=addTopic&fekey={$group->ekey}" class="btn btn-default">{L key="widgets.forum.forums.add"}</a>
                        {else}
						    {L key="widgets.forum.forums.added"}: {generate::showDatatime($lastPost->createTime,true,true)}<br>
						    {L key="widgets.forum.forums.by"}: <a href="{$HOME}{$data.pageUrlKey}?ftype=user&fekey={$lastPost->author->ekey}">{$lastPost->author->username}</a>
                        {/if}
					</div>			
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>	
{/foreach}
