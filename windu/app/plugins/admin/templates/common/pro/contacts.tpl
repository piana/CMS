<div class="tab-menu-top">
	<a href="{$HOME}admin/tools/contacts/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.contact"}</h3>
	{$formContactSearch->toHtml()}
	<a href="{$HOME}admin/tools/contacts/addMailingContactGroup/" class="btn btn-primary btn-small">{L key = "form.button.title.add"}</a>
	<a href="{$HOME}admin/tools/contacts/importContactGroup/" class="btn btn-info btn-small">{L key = "form.button.title.import"}</a>
	<a href="{$HOME}admin/tools/contacts/mergeContactGroup/" class="btn btn-inverse btn-small">{L key = "form.button.title.merge"}</a>	
</div>	
<div class="row-fluid">
	<div class="span4">
		<div class="box">
			<h5>
				<i class=" fa fa-user icon-margin icon-grey">&nbsp;</i>{L key = "admin.tools.mailing.controller.contacts"}
			  	<div class="buttons buttons-three">
			  		<a href="{$HOME}admin/tools/contacts/addMailingContactGroup/" class="btn btn-primary btn-small">{L key = "form.button.title.add"}</a>
			  		<a href="{$HOME}admin/tools/contacts/importContactGroup/" class="btn btn-info btn-small">{L key = "form.button.title.import"}</a>
			  		<a href="{$HOME}admin/tools/contacts/mergeContactGroup/" class="btn btn-inverse btn-small">{L key = "form.button.title.merge"}</a>
			  	</div>						
			</h5>
			<table class="table table-striped">
			  <tbody>
				{foreach $contactsGroups as $contactGroup}
			    <tr {if "editMailingContactGroup{$contactGroup->id}" == "{$REQUEST->getVariable('action')}{$REQUEST->getVariable('id')}"}class="active"{/if}>
			      <td>
			      	<i class="color-icons icons-mail-open-document-text icon-margin"> </i>
					{$contactGroup->name}
			      </td>
			      <td>
				    <div class="buttons buttons-six" style="width:148px;">
				    	<a href="{$HOME}admin/tools/contacts/showContacts/{$contactGroup->id}/"><i class="fa fa-align-justify icon-blue">&nbsp;</i></a>
				    	<a href="{$HOME}admin/tools/contacts/exportToCSVContacts/{$contactGroup->id}/"><i class="fa fa-download icon-green">&nbsp;</i></a>
				    	<a href="{$HOME}admin/tools/contacts/addContact/{$contactGroup->id}/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
				    	<a href="{$HOME}admin/tools/contacts/addMailingMassContact/{$contactGroup->id}/"><i class="fa fa-plus-circle icon-black">&nbsp;</i></a>
				    	<a href="{$HOME}admin/tools/contacts/editMailingContactGroup/{$contactGroup->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
				      	<a href="{$HOME}admin/do/mailing/deleteContactGroup/{$contactGroup->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
				    </div>
			      </td>
			    </tr>
			
				{/foreach}	  	
			  </tbody>
			</table>
		</div>		

	</div>
	<div class="span8">
		{if is_object($formContact)}
		<div class="box">
			{$formContact->toHtml()}
		</div>
        {elseif is_object($formMailing)}
        <div class="box">
            {$formMailing->toHtml()}
        </div>			
		{elseif is_array($emails)}
		<div class="box">
			<table class="table table-striped tablesort">
				<thead>
				<tr>
					<th>{L key="admin.system.controller.name"}</th>
				    <th>{L key="admin.tools.tpl.email"}</th>	
				    <th>{L key="admin.tools.controller.telephone"}</th>	
				    <th>{L key="admin.tools.controller.adress"}</th>		
				    <th>{L key="admin.tools.controller.city"}</th>	
				    <th>{L key="admin.tools.controller.code"}</th>	
				    <th>{L key="admin.tools.controller.other"}</th>	
					<th></th>
				</tr>
				</thead>
			  <tbody>
				{foreach $emails as $email}
			    <tr>
			      <td><i class="color-icons icons-mail-air icon-margin"> </i> {$email->name}</td>	
			      <td>{$email->email}</td>	
			      <td>{$email->telephone}</td>	
			      <td>{$email->adress}</td>		
			      <td>{$email->city}</td>	
			      <td>{$email->code}</td>	
			      <td>{$email->other}</td>		      
			      <td>
				    <div class="buttons buttons-two" style="width:48px;">
				   		<a href="{$HOME}admin/tools/contacts/editContact/{$email->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
				      	<a href="{$HOME}admin/do/mailing/deleteEmail/{$email->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
				    </div>
			      </td>
			    </tr>
				{/foreach}	 				 	
			  </tbody>
			</table>	
		</div>
		{else}
			<div class="row-fluid">				
			  <div class="span12 box margin-bottom">
				<h5><i class="fa fa-info-circle icon-margin icon-grey">&nbsp;</i>{L key="admin.tools.controller.statsnew"}</h5>
				
			  	{literal}
				    <script type="text/javascript">
				      google.load("visualization", "1", {packages:["corechart"]});
				      $(document).ready(function() {
				    	  window.dataContacts = google.visualization.arrayToDataTable([
					          {/literal}
					          ['Date', 'Contacts'],
					          {$lastContacts = 0}
					          {foreach array_reverse($systemStatusDB->fetchAll(null, 'id DESC', '*', 30)) as $stat}
					          ['{$stat->date}', {$stat->contacts-$lastContacts}],
					          {$lastContacts = $stat->contacts}
					          {/foreach}
					     	  {literal}
					        ]);
					      drawLineChartMedium('chartLineContacts',window.dataContacts);
					  }); 
				    </script>
				 {/literal}		
				 <div id="chartLineContacts" style="width: 99.9%; height:200px;"></div> 				
				
			  </div>	
			</div>  		 
  			<div class="row-fluid mobileHidden">	 				
				<div class="span3">
				  <div class="box pad margin-bottom align-center">
			   	 	{L key = "admin.tools.tpl.contact.contacts"} {L key = "admin.common.statistics.tpl.24"} 
			   	 	<h2>{$contactDB->fetchCount("createTime>='{generate::sqlDate(strtotime('-1 days'))}'")}</h2>    	 
			   	  </div> 
  				</div> 
				<div class="span3">
				  <div class="box pad margin-bottom align-center">
			   	 	{L key = "admin.tools.tpl.contact.contacts"} {L key = "admin.common.statistics.tpl.7days"} 
			   	 	<h2>{$contactDB->fetchCount("createTime>='{generate::sqlDate(strtotime('-7 days'))}'")}</h2>    	 
			   	  </div> 
  				</div>  
				<div class="span3">
				  <div class="box pad margin-bottom align-center">
			   	 	{L key = "admin.tools.tpl.contact.contacts"} {L key = "admin.common.statistics.tpl.30days"} 
			   	 	<h2>{$contactDB->fetchCount("createTime>='{generate::sqlDate(strtotime('-30 days'))}'")}</h2>    	 
			   	  </div> 
  				</div>  
				<div class="span3">
				  <div class="box pad margin-bottom align-center">
			   	 	{L key = "admin.tools.tpl.contact.contacts"}
			   	 	<h2>{$contactDB->fetchCount()}</h2>    	 
			   	  </div> 
  				</div>    				  				  				  	  				
			</div>
			{/if}
		{if is_array($emails) and $searchString==''}
			{include file='common/paginator.tpl' elementsCount=$emailsCount count=$pageCount}
		{/if}
	</div>
</div>
	