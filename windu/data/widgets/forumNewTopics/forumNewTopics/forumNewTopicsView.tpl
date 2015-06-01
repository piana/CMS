{if !isset($params.limit)}{$params.limit = 3}{/if}

<h5>{L key="newTopics.title"}</h5>
{foreach $data.forumTopicsDB->fetchCountGroup('id', null, "createTime DESC" ,'*', $params.limit) as $newTopic}
    <a href="{$HOME}{$data.pageUrlKey}?ftype=topic&fekey={$newTopic->ekey}"> {$data.forumTopicsDB->get($newTopic->id, 'name')}</a><br>
    {$username = $data.forumPostsDB->get($data.forumPostsDB->get($newTopic->id, 'id'),'authorId')}
    {$data.usersDB->get($username, 'username')} {$dateTime = $data.forumTopicsDB->get($newTopic->id, 'createTime')}
    {generate::showDatatime($dateTime, true, true)}
{/foreach}