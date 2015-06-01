<div class="tab-menu-top">
	<a href="{$HOME}admin/system/firewall/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.firewall"}</h3>	
	<a href="{$HOME}admin/do/tools/firewallRecreateHtaacess/" class="btn btn-small btn-primary"><i class="fa fa-refresh "></i>{L key = "admin.common.pro.firewall.tpl.create"}</a>
	{if usersDB::isDeveloper()}
		{if config::getSystemRun("firewall")}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/firewall/" class="btn btn-success btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.pro.firewall.tpl.deactivate"}</a>
		{else}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/firewall/" class="btn btn-danger btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.pro.firewall.tpl.activate"}</a>
		{/if}	
	{/if}
</div>	
{if !config::getSystemRun("firewall")}
	<div class="alert alert-error">
	  {L key = "admin.common.pro.firewall.tpl.warning"}
	</div>
{/if}
<div class="row-fluid">
	<div class="span{if !is_array($firewallIpInfo)}6{else}4{/if}">
		<div class="box">
			<table class="table table-striped">
				<h5><i class="fa fa-ban icon-margin icon-grey">&nbsp;</i>{L key = "admin.common.pro.firewall.tpl.blocked"}
				  	<div class="buttons buttons-three">
			    		<a href="{$HOME}admin/do/tools/firewallActivateLocks/" class="btn btn-small">{L key = "admin.common.pro.firewall.tpl.activatex"}</a>
			    		<a href="{$HOME}admin/do/tools/firewallDeactivateLocks/" class="btn btn-small">{L key = "admin.common.pro.firewall.tpl.deactivatex"}</a>
			   	 		<a href="{$HOME}admin/do/tools/firewallDeleteAll/" class="btn btn-small btn-danger">{L key = "admin.common.pro.firewall.tpl.delete"}</a>				  		
				  	</div>				
				
				</h5>
				{foreach $firewallDB->fetchAll() as $denyIp}
					<tr {if $REQUEST->getVariable('id')==$denyIp->id}class="active"{/if}>
						<td><a href="{$HOME}admin/system/firewall/firewallIpInfo/{$denyIp->id}/"><i class="fa fa-minus-circle {if $denyIp->status == 1}icon-red{else}icon-green{/if}">&nbsp;</i> {$denyIp->createIp}</a></td>
						<td><a href="{$HOME}admin/system/firewall/firewallIpInfo/{$denyIp->id}/">{generate::showDatatime($denyIp->createTime)}</a></td>
						<td>{$denyIp->status}</td>
						<td>
							<div class="buttons buttons-two">
								<a href="{$HOME}admin/system/firewall/firewallIpInfo/{$denyIp->id}/">
									<i class="fa fa-info-circle icon-grey">&nbsp;</i>
								</a>							
								<a href="{$HOME}admin/do/tools/deleteFirewallIp/{$denyIp->id}/">
									{if $denyIp->status == 0}
										<i class="fa fa-times-circle icon-red">&nbsp;</i>
									{else}
										<i class="fa fa-times-circle icon-blue">&nbsp;</i>
									{/if}
								</a>	
							</div>
						</td>
					</tr>
				{foreachelse}
					<div class="pad">{L key = "admin.common.pro.firewall.tpl.noelements"}</div>	
				{/foreach}
			</table>
		</div>
	</div>	
	{if !is_array($firewallIpInfo)}
		<div class="span6">
			<div class="box">
				<h5><i class="fa fa-wrench icon-margin icon-grey">&nbsp;</i>{L key = "admin.common.pro.firewall.tpl.settings"}</h5>
				{$formFirewall->toHtml()}
			</div>
		</div>
	{/if}	
	{if is_array($firewallIpInfo)}
		<div class="span8">
				<div class="box margin-bottom">
				<h5>{L key = "admin.common.pro.firewall.tpl.graph"}<span class="badge badge-inverse">{$ip}</span></h5>
		  		{literal}
			    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
			    <script type="text/javascript">
			      google.load("visualization", "1", {packages:["corechart"]});
			      $(document).ready(function() {
			    	  window.dataRequestLogAll = google.visualization.arrayToDataTable([
			    	      {/literal}
			    	      ['Date', 'Requests'],
			    	      {$lastMailing = 0}
			    	      {foreach $firewallIpInfo as $stat}
			    	      ['{$stat->insertTime}', {$stat->{"COUNT(strftime('%Y%m%d%H', insertTime))"}}],
			    	      {$lastMailing = $stat->{"COUNT(strftime('%Y%m%d%H', insertTime))"}}
			    	      {/foreach}
			    	      {literal}
				        ]);
				      drawLineChartMedium('chartLineRequestsAll',window.dataRequestLogAll);
				  }); 
			    </script>
			 	{/literal}		
				<div id="chartLineRequestsAll" style="width: 99.9%; height:200px;"></div> 	
				</div> 
				
				
				
		    	<div class="box margin-bottom">
		    		<h5>{L key = "admin.common.pro.firewall.tpl.frequent"}</h5>
					<table class="table table-striped">
					  <tbody>			  	
				  		{foreach $accesslogDB->fetchCountGroup('url',"ip='{$ip}'", null,'*',10) as $urlgroup}
						<tr>
							<td>{$urlgroup->url}</td>
							<td>{$urlgroup->{'COUNT(url)'}}</td>
						</tr>			  		
				  		{/foreach}
					  </tbody>
					</table>
		   	 	</div>					
				
				
		</div>
	{/if}
</div>