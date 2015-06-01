<div class="forum-buttons">
    <a href="{$HOME}{$data.pageUrlKey}?ftype=topic&fekey={$data.fekey}" class="btn btn-default">« {L key="widgets.forum.post.return"}</a>
</div>
{if $data.user!=null}
    {$data.formAddPost->toHtml()}
{else}
    {L key="widgets.forum.post.mustlog"}
{/if}
<div class="forum-buttons">
    <a href="{$HOME}{$data.pageUrlKey}?ftype=topic&fekey={$data.fekey}" class="btn btn-default">« {L key="widgets.forum.post.return"}</a>
</div>