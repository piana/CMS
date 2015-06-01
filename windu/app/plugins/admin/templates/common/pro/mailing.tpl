<div class="tab-menu-top">
	<a href="{$HOME}admin/tools/mailing/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.mailing"}</h3>	
	<a href="{$HOME}admin/tools/mailing/addMailingTemplate/" class="btn btn-primary btn-small">{L key = "admin.tools.tpl.addtemplate"}</a>
	<a href="{$HOME}admin/tools/mailing/addMailingContactGroup/" class="btn btn-primary btn-small">{L key = "admin.tools.tpl.addcontactlist"}</a>
	<a href="{$HOME}admin/tools/mailing/addMailing/" class="btn btn-primary btn-small">{L key = "admin.tools.tpl.createmailing"}</a>
	<span class="line-vertical"></span>
	<a href="{$HOME}admin/do/mailing/sendAllMailings/" class="btn btn-warning btn-small">{L key = "admin.tools.tpl.sendallmailings"}</a>
</div>	
<div class="row-fluid">
	<div class="span4">
		<div class="box">
			<h5>
				<i class="fa fa-file icon-margin icon-grey">&nbsp;</i>{L key = "admin.tools.mailing.controller.template"}
			  	<div class="buttons">
			  		<a href="{$HOME}admin/tools/mailing/addMailingTemplate/" class="btn btn-primary btn-small">{L key = "admin.tools.tpl.addtemplate"}</a>
			  	</div>				
			</h5>
			<table class="table table-striped">
			  <tbody>
				{foreach $mailingTemplatesList as $mailingTemplate}
			    <tr {if $mailingTemplate->id == $REQUEST->getVariable('id')}class="active"{/if}>
			      <td>
			      	<i class="color-icons icons-cheque icon-margin"> </i>
					{$mailingTemplate->name}
			      </td>
			      <td>
				    <div class="buttons buttons-two">
				    	<a href="{$HOME}admin/tools/mailing/editMailingTemplate/{$mailingTemplate->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
				      	<a href="{$HOME}admin/do/mailing/deleteTemplate/{$mailingTemplate->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
				    </div>
			      </td>
			    </tr>
				{/foreach}	  	
			  </tbody>
			</table>
		</div>
		
		<div class="box margin-top">
			<h5>
				<i class="fa fa-user icon-margin icon-grey">&nbsp;</i>{L key = "admin.tools.mailing.controller.contactsgroup"}
			  	<div class="buttons">
			  		<a href="{$HOME}admin/tools/mailing/addMailingContactGroup/" class="btn btn-primary btn-small">{L key = "admin.tools.tpl.addcontactlist"}</a>
			  	</div>						
			</h5>
			<table class="table table-striped">
			  <tbody>
				{foreach $contactsGroups as $contactGroup}
			    <tr {if $contactGroup->id == $REQUEST->getVariable('id')}class="active"{/if}>
			      <td>
			      	<i class="color-icons icons-mail-open-document-text icon-margin"> </i>
					{$contactGroup->name}
			      </td>
			      <td><span class="badge badge-inverse">{$contactDB->fetchCount("bucket={$contactGroup->id}")}</span></td>		      
			      <td>
				    <div class="buttons buttons-six">
				    	<a href="{$HOME}admin/tools/mailing/showMailingContact/{$contactGroup->id}/"><i class="fa fa-align-justify icon-blue">&nbsp;</i></a>
				    	<a href="{$HOME}admin/tools/mailing/addMailingContact/{$contactGroup->id}/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
				    	<a href="{$HOME}admin/tools/mailing/addMailingMassContact/{$contactGroup->id}/"><i class="fa fa-plus-circle icon-black">&nbsp;</i></a>
				    	<a href="{$HOME}admin/tools/mailing/addMailingMassContactFromUsers/{$contactGroup->id}/"><i class="fa fa-plus-circle icon-blue">&nbsp;</i></a>
				    	<a href="{$HOME}admin/tools/mailing/editMailingContactGroup/{$contactGroup->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
				      	<a href="{$HOME}admin/do/mailing/deleteContactGroup/{$contactGroup->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
				    </div>
			      </td>
			    </tr>
			
				{/foreach}	  	
			  </tbody>
			</table>
		</div>		
		
		<div class="box margin-top">
			<h5>
			<i class="fa fa-list-alt icon-margin icon-grey">&nbsp;</i>{L key = "admin.tools.mailing.controller.mailinglist"}
		  	<div class="buttons">
		  		<a href="{$HOME}admin/tools/mailing/addMailing/" class="btn btn-primary btn-small">{L key = "admin.tools.tpl.createmailing"}</a>
		  	</div>				
			</h5>
			<table class="table table-striped">
			  <tbody>
				{foreach $mailingList as $mailing}
			    <tr {if $mailing->status == mailingsDB::STATUS_UNACTIVE}class="unactive"{/if}>
			      <td>
			      	<i class="color-icons icons-mail-forward icon-margin"> </i>
					{$mailing->name}
			      </td>
			      <td>
				    <div class="buttons">
				    	{if $mailing->status == mailingsDB::STATUS_ACTIVE}
				    	<a href="{$HOME}admin/do/mailing/sendMailing/{$mailing->id}/"><i class="icon-play icon-green">&nbsp;</i></a>
				    	{/if}
				      	<a href="{$HOME}admin/do/mailing/deleteMailing/{$mailing->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
				    </div>
			      </td>
			    </tr>
				{/foreach}	 				 	
			  </tbody>
			</table>
		</div>			
		<div class="box margin-top">
			<div class="pad">
				<a href="{$HOME}admin/do/mailing/sendAllMailings/" class="btn btn-warning">{L key = "admin.tools.tpl.sendallmailings"}</a>
			</div>
		</div>
	</div>
	<div class="span8">
		
			{if is_object($formMailing)}
			<div class="box">
				<h5>{$titleForm}</h5>
				{$formMailing->toHtml()}
			</div>	
			{elseif is_array($emails)}
			<div class="box">
				<h5>{L key = "admin.tools.tpl.emailadress"}</h5>
				<table class="table table-striped">
				  <tbody>
					{foreach $emails as $email}
				    <tr>
				      <td>
				      	<i class="color-icons icons-mail-air icon-margin"> </i>
						{$email->email}
				      </td>
				      <td>
					    <div class="buttons buttons-two">
					    	<a href="{$HOME}admin/tools/mailing/editMailingContact/{$email->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
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
				<h5><i class="fa fa-info-circle icon-margin icon-grey">&nbsp;</i>{L key = "admin.tools.tpl.sentstats"}</h5>
			  	{literal}
				    <script type="text/javascript">
				      google.load("visualization", "1", {packages:["corechart"]});
				      $(document).ready(function() {
				    	  window.dataMailings = google.visualization.arrayToDataTable([
				    	      {/literal}
				    	      ['Date', 'Sended Emails'],
				    	      {$lastMailing = 0}
				    	      {foreach array_reverse($systemStatusDB->fetchAll(null, 'id DESC', '*', 30)) as $stat}
				    	      ['{$stat->date}', {$stat->sendedEmails-$lastMailing}],
				    	      {$lastMailing = $stat->sendedEmails}
				    	      {/foreach}
				    	      {literal}
					        ]);
					      drawLineChartMedium('chartLineMailings',window.dataMailings);
					  }); 
				    </script>
				 {/literal}		
				 <div id="chartLineMailings" style="width: 99.9%; height:200px;"></div> 						
			  </div>	
			</div>  		 			
			<div class="row-fluid mobileHidden">
				<div class="span3">
				  <div class="box pad margin-bottom align-center">
			   	 	{L key = "admin.tools.tpl.contact.sendedEmails"} {L key = "admin.common.statistics.tpl.24"}
			   	 	<h2>{$mailDB->fetchCount("createTime>='{generate::sqlDate(strtotime('-1 days'))}'")}</h2>    	 
			   	  </div> 
  				</div>
 				<div class="span3">
				  <div class="box pad margin-bottom align-center">
			   	 	{L key = "admin.tools.tpl.contact.sendedEmails"} {L key = "admin.common.statistics.tpl.7days"}
			   	 	<h2>{$mailDB->fetchCount("createTime>='{generate::sqlDate(strtotime('-7 days'))}'")}</h2>    	 
			   	  </div> 
  				</div>
				<div class="span3">
				  <div class="box pad margin-bottom align-center">
			   	 	{L key = "admin.tools.tpl.contact.sendedEmails"} {L key = "admin.common.statistics.tpl.30days"}
			   	 	<h2>{$mailDB->fetchCount("createTime>='{generate::sqlDate(strtotime('-30 days'))}'")}</h2>    	 
			   	  </div> 
  				</div>
 				<div class="span3">
				  <div class="box pad margin-bottom align-center">
			   	 	{L key = "admin.tools.tpl.contact.sendedEmails"}
			   	 	<h2>{$mailDB->fetchCount()}</h2>    	 
			   	  </div> 
  				</div> 	
  			</div> 	
			{/if}
		{if is_array($emails)}
			{include file='common/paginator.tpl' elementsCount=$emailsCount count=$pageCount}
		{/if}
	</div>
</div>
