{if $params.showTitle==''}{$params.showTitle = true}{/if}

{if $data.events!=null}
	{if $params.showTitle}<h4>{$data.calendar->name}</h4>{/if}
	<table class="table table-striped">
	  <thead>
	    <tr>
	      <th>Data</th>
	      <th>Nazwa</th>
	      <th>Opis</th>
	    </tr>
	  </thead>
	  <tbody>
		{foreach array_reverse($data.events) as $event}
		  <tr>
		      <td>{$event->date}</td>	  	
		      <td>{$event->name}</td>
		      <td>{$event->description}</td>
		  </tr>	
		{/foreach}    
	  </tbody>
	</table>
{/if}

