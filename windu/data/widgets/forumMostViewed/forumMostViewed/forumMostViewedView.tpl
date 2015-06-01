{if !isset($params.limit)}{$params.limit = 3}{/if}

<h5>{L key="mostViewed.title"}</h5>
            {foreach $data.forumTopicsDB->fetchCountGroup('id',null,'views DESC','*', $params.limit) as $post}
                        <a href="{$HOME}{$data.pageUrlKey}?ftype=topic&fekey={$post->ekey}">{$data.forumTopicsDB->get($post->id, 'name')|wordwrap:'\n'}</a><br>
                        {$username = $data.forumPostsDB->get($data.forumPostsDB->get($post->id, 'id'),'authorId')}
                        {$data.users->get($username, 'username')}
                        {$dateTime = $data.forumTopicsDB->get($post->id, 'createTime')}
                        {$data.forumPostsDB->get($data.forumTopicsDB->get($post->id, 'id'), 'content')}<br>
                        {generate::showDatatime($dateTime, true, true)}
                        {$data.forumTopicsDB->get($post->id, 'views')}
                        <hr>
            {/foreach}
