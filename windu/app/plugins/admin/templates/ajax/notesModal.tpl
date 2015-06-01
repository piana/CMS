<div class="notes-form">	
	{$form->toHtml()}
</div>
<table class="table table-striped">
	<tbody>
	{foreach $notes as $note}
		{$counter = $counter+1}
		<tr>
			<td><span class="silver margin-right-small">{$counter}</span> <a href="{$HOME}admin/ajax/notes/edit/{$note->id}/">{$note->content|truncate:30}</a></td>
			<td>{generate::showDatatime($note->updateTime)}</td>
			<td class="align-right"><a href="{$HOME}admin/ajax/notes/deleteNote/{$note->id}/"><i class="fa fa-check-circle icon-blue" style="margin-right:6px;">&nbsp;</i></a></td>
		</tr>		
	{/foreach}		
	</tbody>
</table>  
