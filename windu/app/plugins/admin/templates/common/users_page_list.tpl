<table class="table table-striped tablesort">
	<thead>
	<tr>
		<th>{L key="admin.users.controller.login"}</th>
		<th>{L key="admin.users.ctpl.authorization"}</th>
		<th></th>
	</tr>
	</thead>
  <tbody>
  {foreach $usersPage as $user}
	<tr {if $user->id == $REQUEST->getVariable('id')}class="active"{/if}>
		<td><i class="color-icons icons-user-yellow icon-margin">&nbsp;</i>{$user->email}</td>
		<td>{$userTypesArray[$user->type]}</td>
		<td>
			<div class="buttons buttons-three">
				<a href="{$HOME}admin/do/users/toggleUserActivate/{$user->id}/"><i class="fa fa-lock {if $user->active == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></a>
				<a href="{$HOME}admin/users/users/editUserPage/{$user->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
				<a href="{$HOME}admin/do/users/deletePageUser/{$user->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
			</div>
		</td>
	</tr>
  {/foreach}   
  </tbody>
</table>