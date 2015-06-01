{if !isset($params.limit)}{$params.limit = 3}{/if}

<h5>{L key="forumHotTopics.title"}</h5>
{foreach $data.forumTopicsDB->fetchCountGroup('id',null,'postsCount DESC','*', $params.limit) as $hotTopic}
    <a href="{$HOME}{$data.pageUrlKey}?ftype=topic&fekey={$hotTopic->ekey}">{$data.forumTopicsDB->get($hotTopic->id, 'name')|wordwrap:'\n'}</a>
    {$post = $data.forumPostsDB->fetchRow("topicId", 'updateTime DESC')}<br>
    {$data.usersDB->get($post->authorId, 'username')}, {$dateTime = $post->updateTime}
    {generate::showDatatime($dateTime, true, true)}
    <hr>
{/foreach}

