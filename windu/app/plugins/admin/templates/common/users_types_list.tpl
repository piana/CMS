<table class="table table-striped tablesort">
	<thead>
	<tr>
		<th>{L key = "admin.users.common.tpl.typesofauth"}</th>
		<th>{L key="admin.users.common.tpl.extension"}</th>
		<th class="smallWidthHidden">{L key="admin.users.common.tpl.regexp"}</th>
		<th></th>
	</tr>
	</thead>
  <tbody>
  {foreach $userTypes as $userType}
	<tr {if $userType->id == $REQUEST->getVariable('id')}class="active"{/if}>
		<td><i class="color-icons icons-safe--arrow"> </i> {$userType->name}</td>
		<td>{$userTypesArray[$userType->extends]}</td>
		<td class="smallWidthHidden">{$userType->regexp|truncate:20}</td>
		<td>
			<div class="buttons buttons-three">
				<a href="{$HOME}admin/users/authorization/editUserType/{$userType->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
				<a href="{$HOME}admin/users/authorization/editUserTypePanels/{$userType->id}/"><i class="fa fa-pencil-square icon-orange">&nbsp;</i></a>
				<a href="{$HOME}admin/do/users/deleteUserType/{$userType->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
			</div>
		</td>		
	</tr>
  {/foreach}   
  </tbody>
</table>