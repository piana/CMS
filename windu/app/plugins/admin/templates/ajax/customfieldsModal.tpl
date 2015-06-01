<table class="table table-striped" style="margin-top:-1px; border-bottom: 1px solid #dddddd;">
	<tbody>
	{foreach $pagesDB->getCustomFieldsArray() as $key=>$val}
	{$counter = $counter+1}
		<tr>
			<td><span class="silver margin-right-small">{$counter}</span> {$key}</td>
			<td><span class="badge badge-inverse">{$val}</span></td>
			<td class='gray'>{literal}{{$page->{/literal}cf_{$key}_{$val}{literal}}}{/literal}</td>
			<td class="align-right"><a href="{$HOME}admin/ajax/customfields/deleteField/cf_{$key}_{$val}/"><i class="fa fa-times-circle icon-red" style="margin-right:6px;">&nbsp;</i></a></td>
		</tr>		
	{/foreach}		
	</tbody>
</table>  
<div class="notes-form margin-top">	
	{$form->toHtml()}
</div>
