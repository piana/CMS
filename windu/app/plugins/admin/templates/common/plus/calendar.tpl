<div class="tab-menu-top">
	<a href="{$HOME}admin/content/calendar/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin"></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.calendar"}</h3>
</div>	
<div class="row-fluid">
	{if $calendarDB->fetchCount()==0 and $REQUEST->getVariable('action')!='addCalendar'}
		<div class="center-box">
			<a href="{$HOME}admin/content/calendar/addCalendar/" class="btn btn-large">
				<i class="fa fa-plus-circle fa-2x"></i>
				{L key = "admin.calendar.tpl.addcalendar"}
			</a>
		</div>	
	{else}		
		<div class="{if $REQUEST->getVariable('action')!='addCalendar' AND $REQUEST->getVariable('action')!='editCalendar' AND $REQUEST->getVariable('action')!='addCalendarEvent' AND $REQUEST->getVariable('action')!='editCalendarEvent' AND $REQUEST->getVariable('action')!='showCalendar'}span12{else}span4{/if}">
			<div class="box">
				<h5>
					<i class="fa fa-th icon-margin icon-grey"></i> {L key = "admin.calendar.tpl.calendar"}
				  	<div class="buttons">
				  		<a href="{$HOME}admin/content/calendar/addCalendar/" class="btn btn-primary btn-small">{L key = "admin.calendar.tpl.addcalendar"}</a>
				  	</div>				
				</h5>
				<table class="table table-striped">
				  <tbody>
					{foreach $calendarDB->fetchAll() as $calendar}
				    <tr {if ($calendar->id == $REQUEST->getVariable('id') and $REQUEST->getVariable('action')!='editCalendar')}class="active"
						{elseif is_numeric($REQUEST->getVariable('id'))}
							{if ($calendarDB->fetchRow("name={$REQUEST->getVariable('id')}")->calendarId == $calendar->id and $REQUEST->getVariable('action')=='editCalendar')}class="active active-silver"{/if}
						{/if}>
				      <td>
				      	<i class="color-icons icons-cheque icon-margin"> </i>
						{$calendar->name}
				      </td>
				      <td><span class="badge badge-inverse">{$calendar->id}</span></td>
				      <td class="smallWidthHidden">{literal}{{W name=calendarList id={/literal}{$calendar->id}{literal}}}{/literal}</td> 
				      <td>
					    <div class="buttons buttons-five">
					    	<a href="{$HOME}admin/content/calendar/showCalendar/{$calendar->id}/"><i class="fa fa-align-justify icon-blue">&nbsp;</i></a>
					    	<a href="{$HOME}admin/content/calendar/addCalendarEvent/{$calendar->id}/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
					    	<a href="{$HOME}admin/content/calendar/editCalendar/{$calendar->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
					    	<span href="#" onclick="loadDoAction('{$HOME}admin/do/content/toggleCalendarActivate/{$calendar->id}/','#calendarastatus-{$calendar->id}')" id='calendarastatus-{$calendar->id}'><i class="fa fa-eye {if $calendar->status == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></span>
					      	<a href="{$HOME}admin/do/content/deleteCalendar/{$calendar->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
					    </div>
				      </td>
				    </tr>
				    {foreachelse}
				    <tr>	
				    	<td>
				    		{L key="admin.tools.tpl.banners.nodata"}
				    	</td>
				    </tr>
					{/foreach}	  	
				  </tbody>
				</table>
			</div>
		</div>
		
		{if is_object($formCalendar)}
			<div class="span8">
				<div class="box">
					<h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> {L key = "admin.calendar.tpl.calendar"}</h5>
					{$formCalendar->toHtml()}
				</div>
			</div>	
		{elseif is_object($formCalendarEvent)}
			<div class="span3">
				<div class="box">
					<h5>
						<i class="icon-facetime-video icon-margin icon-grey"></i> {L key = "admin.calendar.tpl.events"}
					  	<div class="buttons">
					  		<a href="{$HOME}admin/content/calendar/addCalendarEvent/{$REQUEST->getVariable('id')}/" class="btn btn-primary btn-small">{L key = "admin.calendar.tpl.addevent"}</a>
					  	</div>						
					</h5>
					<table class="table table-striped">
					  <tbody>
					  	{if !is_numeric($calendarId)}
					  		{$calendarId = $REQUEST->getVariable('id')}
					  	{/if}
						{foreach $calendarEventsDB->fetchAll("calendarId='{$calendarId}'") as $event}
					    <tr {if $event->id == $REQUEST->getVariable('id')}class="active"{/if}>
					      <td>
					      	<i class="color-icons icons-mail-open-document-text icon-margin"> </i>
							{$event->name}
					      </td>
					      <td>
						    <div class="buttons buttons-three">
						    	<span href="#" onclick="loadDoAction('{$HOME}admin/do/content/toggleCalendarEvent/{$event->id}/','#calendarEvent-{$event->id}')" id='calendarEvent-{$event->id}'><i class="fa fa-map-marker {if $event->status == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></span>
	
						    	<a href="{$HOME}admin/content/calendar/editCalendarEvent/{$event->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
						      	<a href="{$HOME}admin/do/content/deleteCalendarEvent/{$event->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
						    </div>
					      </td>
					    </tr>
						{/foreach}	  	
					  </tbody>
					</table>
				</div>
			</div>	
			<div class="span5">
				<div class="box">
					<h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> {L key = "admin.calendar.tpl.eventsdata"}</h5>			
					{$formCalendarEvent->toHtml()}
				</div>
			</div>
		{elseif $REQUEST->getVariable('action')=='showCalendar'}
			<div class="span8">
				<div class="box">
					<h5>
						<i class="icon-facetime-video icon-margin icon-grey"></i> {L key = "admin.calendar.tpl.events"}
					  	<div class="buttons">
					  		<a href="{$HOME}admin/content/calendar/addCalendarEvent/{$calendar->id}/" class="btn btn-primary btn-small">{L key = "admin.calendar.tpl.addevent"}</a>
					  	</div>						
					</h5>
					<table class="table table-striped">
					  <tbody>
						{foreach $calendarEventsDB->fetchAll("calendarId={$REQUEST->getVariable('id')}") as $event}
					    <tr>
					      <td>
					      	<i class="color-icons icons-mail-open-document-text icon-margin"> </i>
							{$event->name}
					      </td>
					      <td>{$event->date}</td>	  
					      <td>{$event->description}</td>	    
					      <td>
						    <div class="buttons buttons-three">
						    	<span href="#" onclick="loadDoAction('{$HOME}admin/do/content/toggleCalendarEvent/{$event->id}/','#calendarEvent-{$event->id}')" id='calendarEvent-{$event->id}'><i class="fa fa-map-marker {if $event->status == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></span>
	
						    	<a href="{$HOME}admin/content/calendar/editCalendarEvent/{$event->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
						      	<a href="{$HOME}admin/do/content/deleteCalendarEvent/{$event->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
						    </div>
					      </td>
					    </tr>
						{/foreach}	  	
					  </tbody>
					</table>
				</div>
			</div>
		{/if}
	{/if}
</div>	