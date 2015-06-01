  	<div class="tabbable">
	  <div class="tab-content">
		  
	    {foreach $buckets as $key => $bucket}
		    {if $subpage==$key}
				<div class="tab-menu-top">				
					<a href="{$HOME}admin/config/{$key}/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
					<h3 class="pull-left tab-title"> {L key = $configDB->bucketNames[$key]}</h3>
	 				<a href="{$HOME}admin/config/{$key}/" class="btn btn-small btn-primary"><i class="fa fa-times-circle "></i> {L key = "admin.config.tpl.add"}</a>
				</div>		    
		    	<div class="row-fluid">
				  <div class= "span6">
				  	<div class="box">
					<table class="table table-striped tablesort">
					<thead>
						<tr>
							<th>{L key="admin.config.tpl.constant"}</th>
							<th>{L key="admin.config.controller.value"}</th>
							<th class="smallWidthHidden">{L key="admin.config.controller.description"}</th>
							<th></th>
						</tr>
					</thead>				
					<tbody>
					  {foreach $bucket as $variable}
						<tr {if $variable->id == $REQUEST->getVariable('id')}class="active"{/if}>
							<td><i class="color-icons icons-pill icon-margin">&nbsp;</i>{$variable->name}</td>
							<td><span class="badge badge-inverse">{$variable->value}</span></td>
							<td class="smallWidthHidden">{L key="config.short.description.{$variable->name}"}</td>
							<td>
								<div class="buttons buttons-three" style="min-width: 75px;">
									<a href="{$HOME}admin/config/{$key}/edit/{$variable->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
									{if usersDB::isDeveloper()}
										{if $variable->nodelete==1}
										
										{else}
										<a href="{$HOME}admin/do/config/delete/{$variable->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
										{/if}
									{/if}
									<a href="#config_tab4" data-toggle="tooltip" data-placement="right" data-original-title="{L key="config.long.description.{$variable->name}"}">	
										<i class="fa fa-question-circle icon-grey" >&nbsp;</i>
									</a>								
								</div>
							</td>
						</tr>
					  {/foreach}   
					  </tbody>
					</table>
		      		</div>
				  </div>
				  <div class="span6">
				  	{if $key==1}<div>{/if}
				  		<div class="box box-floating">
				  			<h5><i class="fa fa-plus-circle icon-margin icon-grey">&nbsp;</i>{L key = "admin.config.tpl.addconstanttoconfig"}</h5>
				  			{$forms.$key->toHtml()}
				  		</div>	
				  	{if $key==1}</div>{/if}
				  </div>
				</div>	     	
			{/if}
	    {/foreach}	    
	</div>