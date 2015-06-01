<div class="forum-buttons">
    <a href="{$HOME}{$data.pageUrlKey}?ftype=group&fekey={$data.fekey}" class="btn btn-default">« {L key="widgets.forum.post.return"}</a>
</div>
{if $data.user!=null}
    {$data.formAddTopic->toHtml()}
{else}
    {L key="widgets.forum.post.mustlog"}
{/if}
<div class="forum-buttons">
    <a href="{$HOME}{$data.pageUrlKey}?ftype=group&fekey={$data.fekey}" class="btn btn-default">« {L key="widgets.forum.post.return"}</a>
</div>