<table class="table table-striped tablesort">
<thead>
	<tr>
		<th>{L key = "admin.config.tpl.constant"}</th>
		<th>{L key="admin.config.controller.value"}</th>
		<th>{L key="admin.config.controller.description"}</th>
		<th></th>
	</tr>
</thead>
<tbody>
  {foreach $list as $variable}
	<tr {if $variable->id == $REQUEST->getVariable('id')}class="active"{/if}>
		<td><i class="color-icons icons-pill icon-margin">&nbsp;</i>{$variable->name}</td>
		<td><span class="badge badge-inverse">{$variable->value}</span></td>
		<td>{if $extended!=1}{L key="config.short.description.{$variable->name}"}{else}{L key="config.long.description.{$variable->name}"}{/if}</td>
		<td>
			<div class="buttons buttons-two">
				<a href="{$HOME}admin/{$class}/config/editConfig/{$variable->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
				{if $extended!=1}
				<a href="#" data-toggle="tooltip" data-placement="right" data-original-title="{L key=$variable->description}">	
					<i class="fa fa-question-circle icon-grey">&nbsp;</i>
				</a>
				{/if}
			</div>
		</td>
	</tr>
  {/foreach}   
  </tbody>
</table>