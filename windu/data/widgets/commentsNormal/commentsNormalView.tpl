<h3>{L key="comments.normal.addcomments"}</h3>
<div class="box box-comments-form">
	{if empty($data.user) and config::get('commentsLoggedUser')}
		<div class="pad" style="padding-top:0px;">
			{L key="comments.normal.mustlogin"}
		</div>
	{else}
		{$data.form->toHtml()}
	{/if}
</div>

{if $data.commentsDB->fetchCount("bucket={$data.bucket} and status = 1")>0}
	<h3>{L key="comments.normal.comments"}</h3>
	{foreach $data.commentsDB->getByBucket($data.bucket,"status = 1") as $comment}
	<div class="box box-comments">
		{$comment->content}
		<div class="box-comments-footer">
			{$comment->name}<span class="date">{$comment->createTime}</span>
		</div>
	</div>
	{/foreach}
{/if}