<table class="table table-striped tablesort">
	<thead>
	<tr>
		<th>{L key="admin.users.controller.login"}</th>
		<th>{L key="admin.users.ctpl.authorization"}</th>
		<th></th>
	</tr>
	</thead>
  <tbody> 
  {foreach $usersSystem as $user}
	<tr {if $user->id == $REQUEST->getVariable('id')}class="active"{/if}>
		<td><i class="color-icons {if $user->superAdministrator != 1}icons-user-black{else}icons-user-red{/if} icon-margin">&nbsp;</i>{$user->email}</td>
		<td>{if $user->superAdministrator != 1}{$userTypesArray[$user->type]}{else}SuperAdministrator{/if}</td>
		<td>
			<div class="buttons buttons-two">
				<a href="{$HOME}admin/users/admins/editUserSystem/{$user->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
				{if $loggedIn->email!=$user->email and $user->superAdministrator != 1}<a href="{$HOME}admin/do/users/deleteSystemUser/{$user->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
				{else}<span><i class="fa fa-times-circle icon-grey">&nbsp;</i></span>{/if}
			</div>
		</td>
	</tr>
  {/foreach}   
  </tbody>
</table>