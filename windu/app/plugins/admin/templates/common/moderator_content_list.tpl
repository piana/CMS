{assign users $usersDB->getByBucket(1,null,'createTime DESC')}
{if count($users)>0}
	<table class="table table-striped tablesort">
		<thead>
		<tr>
			<th>{L key = "admin.moderator.userlist.tpl.username"}</th>
			<th>{L key = "admin.moderator.userlist.tpl.status"}</th>
			<th>{L key = "admin.moderator.userlist.tpl.ipadress"}</th>
			<th>{L key = "admin.moderator.userlist.tpl.creationdate"}</th>
			<th>{L key = "admin.moderator.userlist.tpl.name"}</th>		
			<th>{L key = "admin.moderator.userlist.tpl.surname"}</th>
			<th>{L key = "admin.moderator.userlist.tpl.comments"}</th>
			<th>{L key = "admin.moderator.userlist.tpl.gades"}</th>					
		</tr>
		</thead>
	  <tbody> 
	  {foreach $users as $user}
		<tr>
			<td><i class="color-icons icons-user-thief icon-margin">&nbsp;</i> {$user->email}</td>
			<td>{$user->status}</td>
			<td>{$user->createIP}</td>
			<td>{generate::showDatatime($user->createTime)}</td>
			<td>{$user->name}</td>
			<td>{$user->surname}</td>
			<td>{$usersDB->getCommentsCount($user->id)}</td>
			<td>{$usersDB->getRatesCount($user->id)}</td>
			<td>
				<div class="buttons buttons-two">
					<a href="{$HOME}admin/do/users/toggleUserActivate/{$user->id}/"><i class="fa fa-lock {if $user->active == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></a>
					<a href="{$HOME}admin/do/users/deletePageUser/{$user->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
				</div>
			</td>
		</tr>
	  {/foreach}   
	  </tbody>
	</table>
{else}
    <div class="pad">{L key = "admin.moderator.userlist.tpl.noresults"}</div>
{/if}