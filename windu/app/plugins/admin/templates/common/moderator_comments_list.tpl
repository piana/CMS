{assign comments $commentsDB->fetchAll('','createTime DESC')}
{if count($comments)>0}
	<table class="table table-striped tablesort">
		<thead>
		<tr>
			<th>{L key = "admin.moderator.comments.tpl.inactivecom"}</th>
			<th>{L key = "admin.moderator.comments.tpl.status"}</th>
			<th>{L key = "admin.moderator.comments.tpl.user"}</th>
			<th>{L key = "admin.moderator.comments.tpl.bucket"}</th>
			<th>{L key = "admin.moderator.comments.tpl.created"}</th>
			<th>{L key = "admin.moderator.comments.tpl.ip"}</th>
			<th></th>
		</tr>
		</thead>
	  <tbody> 
	  {foreach $comments as $element}
		<tr>
			<td>
				<span data-toggle="tooltip" data-original-title="{$element->content|strip_tags}" data-placement="right">
					<i class="color-icons icons-balloon-white-left icon-margin">&nbsp;</i>{$element->content|escape:'html'|truncate:50}
				</span>
			</td>
			<td>{$element->status}</td>
			<td>{$element->email}</td>
			{$page = $pagesDB->fetchRow("id='{$element->bucket}'")}
			<td><a href="{$HOME}{$page->urlKey}" target="blank">{$page->name}</a></td>
			<td>{generate::showDatatime($element->createTime)}</td>
			<td>{$element->createIP}</td>
			<td>
				<div class="buttons width50 buttons-two">
					<a href="{$HOME}admin/do/users/toggleCommentsStatus/{$element->id}/"><i class="fa fa-eye {if $element->status == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></a>
					<a href="{$HOME}admin/do/users/deleteComment/{$element->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
				</div>
			</td>
		</tr>
	  {/foreach}   
	  </tbody>
	</table>
{else}
    <div class="pad">{L key = "admin.moderator.userlist.tpl.noresults"}</div>
{/if}