<div class="tab-menu-top">
	<a href="{$HOME}admin/tools/seo/redirectAdd/" class="btn btn-small btn-primary">{L key = "admin.system.tpl.add"}</a>

	<a href="{$HOME}admin/tools/seo/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.seo"}</h3>
</div>
{$action = $REQUEST->getVariable('action')}
{$id = $REQUEST->getVariable('id')}
<div class="row-fluid">
	<div class="span6">	
	  	<div class="box">
	  		<h5><i class="fa fa-exclamation-circle icon-margin icon-grey">&nbsp;</i>{L key = "admin.system.tpl.commonerrors"}</h5>
			<table class="table table-striped">
			  <tbody>
				{assign "cname" 'COUNT(data)'}
			    {foreach $logDB->fetchCountGroup('data',"bucket = 1",null,'*', 20) as $log}
				<tr {if $log->id == $REQUEST->getVariable('id')}class="active"{/if}>
					<td>{if $redirectDB->hasRedirect($log->data)}
						<i class="fa fa-check-circle icon-green icon-margin">&nbsp;</i>
						{else}<i class="fa fa-minus-circle icon-red icon-margin">&nbsp;</i>{/if}
						{str_replace($HOME,'',$log->data)|truncate:60}</td>
					<td class="align-right"><span class="badge badge-inverse">{$log->$cname}</span></td>
					<td>
						<div class="buttons">
							<a href="{$HOME}admin/tools/seo/redirectAdd/{$log->id}/">
								<i class="fa fa-mail-forward icon-green">&nbsp;</i>
							</a>							
						</div>					
					</td>
				</tr>
				{foreachelse}
					<div class="pad">{L key = "admin.system.tpl.noelements"}</div>
			  	{/foreach}   
			  </tbody>
			</table>					
		</div>	  			
	</div> 
	{if !is_object($formRedirect)}
	<div class="span6">	
	  	<div class="box">
	  		<h5><i class="fa fa-tasks icon-margin icon-grey">&nbsp;</i>{L key = "admin.system.tpl.listactive"}
			  	<div class="buttons">
		    		<a href="{$HOME}admin/tools/seo/redirectAdd/" class="btn btn-small btn-primary">{L key = "admin.system.tpl.add"}</a>
			  	</div>		  		
	  		</h5>
			<table class="table table-striped">
			  <tbody>
			    {foreach $redirectDB->fetchAll() as $redirect}
				<tr>
					<td><i class="color-icons icons-document--exclamation icon-margin">&nbsp;</i>{str_replace($HOME,'',$redirect->source)|truncate:70}</td>
					<td>{$redirect->target}</td>
					<td>
						<div class="buttons">
							<a href="{$HOME}admin/do/tools/deleteRedirect/{$redirect->id}/">
								<i class="fa fa-times-circle icon-red">&nbsp;</i>
							</a>							
						</div>					
					</td>					
				</tr>
				{foreachelse}
					<div class="pad">{L key = "admin.system.tpl.noelements"}</div>
			  	{/foreach} 
			  </tbody>
			</table>					
		</div>	  			
	</div> 
	{/if}
  {if is_object($formRedirect)}
	<div class="span6">	
	  	<div class="box">
	  		{$formRedirect->toHtml()}
	  	</div>
	</div>	
  {/if}	 

</div>
		 
    	