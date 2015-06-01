<div class="tab-menu-top">
	<a href="{$HOME}admin/system/requestlog/showLogs/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.requestlog"}</h3>	
	<a href="{$HOME}admin/system/requestlog/showAccessLogs/ip/" class="btn btn-small"><i class="fa fa-barcode icon-grey"></i>{L key = "admin.system.tpl.groupip"}</a>
	<a href="{$HOME}admin/system/requestlog/showAccessLogs/url/" class="btn btn-small"><i class="fa fa-list-alt icon-grey"></i>{L key = "admin.system.tpl.groupurl"}</a>
	<a href="{$HOME}admin/system/requestlog/showAccessLogs/" class="btn btn-small"><i class="fa fa-clock-o icon-grey"></i>{L key = "admin.system.tpl.lastacceslogs"}</a>
	<span class="line-vertical"></span> 	
	
	<a href="{$HOME}admin/do/tools/cleanAccessLog/30/" class="btn btn-warning btn-small"><i class="fa fa-times-circle"></i>{L key = "admin.system.tpl.cleanlast30"}</a>
    <a href="{$HOME}admin/do/tools/cleanAccessLog/0/" class="btn btn-danger btn-small"><i class="fa fa-times-circle "></i>{L key = "admin.system.tpl.cleanall"}</a>
	<span class="line-vertical"></span> 

	<a href="{$HOME}admin/do/tools/refreshResuestLogData/" class="btn btn-primary btn-small"><i class="fa fa-refresh "></i>{L key = "admin.system.tpl.updata"}</a>	
</div>
{if !config::getSystemRun("requestLog")}
	<div class="alert alert-error">	
	  {L key = "admin.system.tpl.warn"}
	</div>
{/if}
{if is_array($accesLogs)}
	<div class="row-fluid">
		<div class="span12">
			{include file='common/paginator.tpl' elementsCount=$accesLogsCount count=$pageCount}
			<div class="box">
				<table class="table table-striped">
					{if $REQUEST->getVariable('action')=='showIpAccessLogs'}
						<h5><i class="fa fa-clock-o icon-margin icon-grey">&nbsp;</i>{L key = "admin.system.tpl.last7"}</h5>
						{literal}
					    <script type="text/javascript">
					      google.load("visualization", "1", {packages:["corechart"]});
					      $(document).ready(function() {
					    	  window.dataRequestLogDay = google.visualization.arrayToDataTable([
					    	      {/literal}
					    	      ['Date', 'Requests'],
					    	      {foreach generate::appendChartArrayEmptyRows(array_reverse($accesslogDB->fetchCountGroup("hour","ip='{$REQUEST->getVariable('id')}'",'insertTime DESC','*',168)),'insertTime','COUNT(hour)',3600,168) as $stat}
					    	      ['{$stat->insertTime}', {$stat->{"COUNT(hour)"}}],
					    	      {/foreach}
					    	      {literal}
						        ]);
						      drawLineChartMedium('chartLineRequestsDay',window.dataRequestLogDay);
						  }); 
					    </script>
					 	{/literal}		
						<div id="chartLineRequestsDay" style="width: 99.9%; height:200px;"></div> 	
					{/if}
					<h5><i class="fa fa-tasks icon-margin icon-grey">&nbsp;</i>{L key = "admin.system.tpl.loglist"}</h5>
					{foreach $accesLogs as $log}
						<tr>
							<td>{generate::showDatatime($log->insertTime)}</td>
							<td><a href="{$HOME}{ltrim($log->url,'/')}">{$log->url|truncate:80}</a></td>
							<td><a href="{$HOME}admin/system/requestlog/showIpAccessLogs/{$log->ip}/">{$log->ip}</a></td>
							{if $filter!=''}
								<td class="align-right"><span class="badge badge-inverse">{$log->$filtercname}</span></td>
							{/if}
						</tr>
					{/foreach}
				</table>
				
			</div>
			{include file='common/paginator.tpl' elementsCount=$accesLogsCount count=$pageCount}
		</div>	
	</div>	
	{elseif $REQUEST->getVariable('action')!='' }	
	<div class="row-fluid">
		<div class="span12">
			<div class="box box-silver">
				<ul id="requestTab" class="nav nav-tabs" style="margin-bottom:0px;">
	              <li class="active" style="margin-left:5px;"><a href="#requestlogweek" data-toggle="tab">{L key = "admin.system.tpl.last3"}</a></li>
	              <li class=""><a href="#requestlogmonth" data-toggle="tab">{L key = "admin.system.tpl.last30"}</a></li>
	              <li class=""><a href="#requestlogall" data-toggle="tab">{L key = "admin.system.tpl.wholer"}</a></li>
	            </ul>		
				<div id="requestTabContent" class="tab-content">
	              <div class="tab-pane active in" id="requestlogweek">

			  		{literal}
				    <script type="text/javascript">
				      google.load("visualization", "1", {packages:["corechart"]});
				      $(document).ready(function() {
				    	  window.dataRequestLogDay = google.visualization.arrayToDataTable([
				    	      {/literal}
				    	      ['Date', 'Requests'],
				    	      {foreach generate::appendChartArrayEmptyRows(array_reverse($accesslogDB->fetchCountGroup("hour",null,'insertTime DESC','*',72)),'insertTime',"COUNT(hour)",3600,72) as $stat}
				    	      ['{$stat->insertTime}', {$stat->{"COUNT(hour)"}}],
				    	      {/foreach}
				    	      {literal}
					        ]);
					      drawLineChartMedium('chartLineRequestsDay',window.dataRequestLogDay);
					  }); 
				    </script>
				 	{/literal}		
					<div id="chartLineRequestsDay" style="width: 99.9%; height:200px;"></div> 	
             
	              </div>
	              <div class="tab-pane" id="requestlogmonth">

			  		{literal}
				    <script type="text/javascript">
				      google.load("visualization", "1", {packages:["corechart"]});
				      $(document).ready(function() {
				    	  window.dataRequestLogMonth = google.visualization.arrayToDataTable([
				    	      {/literal}
				    	      ['Date', 'Requests'],
				    	      {foreach generate::appendChartArrayEmptyRows(array_reverse($accesslogDB->fetchCountGroup("day",null,'insertTime DESC','*',30)),'insertTime',"COUNT(day)",24*3600,30) as $stat}
				    	      ['{$stat->insertTime}', {$stat->{"COUNT(day)"}}],
				    	      {/foreach}
				    	      {literal}
					        ]);
					      drawLineChartMedium('chartLineRequestsMonth',window.dataRequestLogMonth);
					  }); 
				    </script>
				 	{/literal}		
					<div id="chartLineRequestsMonth" style="width: 99.9%; height:200px;"></div> 	

	              </div>
	              <div class="tab-pane" id="requestlogall">
			  		{literal}
				    <script type="text/javascript">
				      google.load("visualization", "1", {packages:["corechart"]});
				      $(document).ready(function() {
				    	  window.dataRequestLogAll = google.visualization.arrayToDataTable([
				    	      {/literal}
				    	      ['Date', 'Requests'],
				    	      {foreach generate::appendChartArrayEmptyRows(array_reverse($accesslogDB->fetchCountGroup("month",null,'insertTime DESC','*')),'insertTime',"COUNT(month)",31*24*3600) as $stat}
				    	      ['{$stat->insertTime}', {$stat->{"COUNT(month)"}}],
				    	      {/foreach}
				    	      {literal}
					        ]);
					      drawLineChartMedium('chartLineRequestsAll',window.dataRequestLogAll);
					  }); 
				    </script>
				 	{/literal}		
					<div id="chartLineRequestsAll" style="width: 99.9%; height:200px;"></div> 	
					</div> 
	            </div>	
	         </div>
         </div>
      </div>   
        <div class="row-fluid">	
			<div class="span3 box pad margin-bottom margin-top align-center mobileHidden">
	   	 		{L key = "admin.system.tpl.polled24"}
	   	 		<h2>{$accesslogDB->fetchCount("insertTime>='{generate::sqlDate(strtotime('-1 days'))}'")}</h2>
	   	 	</div>   
	    	<div class="span3 box pad margin-bottom margin-top align-center mobileHidden">
	   	 		{L key = "admin.system.tpl.polled7"}
	   	 		<h2>{$accesslogDB->fetchCount("insertTime>='{generate::sqlDate(strtotime('-7 days'))}'")}</h2>
	   	 	</div>
	    	<div class="span3 box pad margin-bottom margin-top align-center mobileHidden">
	   	 		{L key = "admin.system.tpl.polled30"}
	   	 		<h2>{$accesslogDB->fetchCount("insertTime>='{generate::sqlDate(strtotime('-30 days'))}'")}</h2>
	   	 	</div>   
	    	<div class="span3 box pad margin-bottom margin-top align-center mobileHidden">
	   	 		{L key = "admin.system.tpl.polledgen"}
	   	 		<h2>{$accesslogDB->fetchCount()}</h2>
	   	 	</div>   
	   	 </div>	
	   	 <div class="row-fluid">	
			<div class="span6">
		    	<div class="box margin-bottom">
		    		<h5><i class="fa fa-globe icon-margin icon-grey">&nbsp;</i>{L key = "admin.system.tpl.mostfreq"}</h5>
					<table class="table table-striped">
					  <tbody>			  	
				  		{foreach $accesslogDB->fetchCountGroup('url',null, null,'*',9) as $urlgroup}
						<tr>
							<td>{$urlgroup->url}</td>
							<td>{$urlgroup->{'COUNT(url)'}}</td>
						</tr>			  		
				  		{/foreach}
					  </tbody>
					</table>
		   	 	</div>		   	 	
			</div>	
			   	 
	    	<div class="span6">
	    		<div class="box margin-bottom">
	    			<h5><i class="fa fa-filter icon-margin icon-grey">&nbsp;</i>{L key = "admin.system.tpl.asked"}</h5>
					<table class="table table-striped">
					  <tbody>			  	
				  		{foreach $accesslogDB->fetchCountGroup('ip',null, null,'*',10) as $ipgroup}
						<tr>
							<td><a href="{$HOME}admin/system/requestlog/showIpAccessLogs/{$ipgroup->ip}/">{$ipgroup->ip}</a></td>
							<td>{$ipgroup->{'COUNT(ip)'}}</td>
						</tr>			  		
				  		{/foreach}
					  </tbody>
					</table>
				</div>	
	   	 	</div> 	
	   	 </div>	
{/if}
