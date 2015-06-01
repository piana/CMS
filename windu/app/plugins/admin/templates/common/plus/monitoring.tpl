<div class="tab-menu-top">
	<a href="{$HOME}admin/tools/monitoring/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.monitoring"}</h3>	
	<span class="line-vertical"></span> 
	<a href="{$HOME}admin/do/tools/cleanMonitoring/30/" class="btn btn-small"><i class="fa fa-times-circle icon-grey"></i>{L key = "admin.system.tpl.cleanlast30"}</a>
	<a href="{$HOME}admin/do/tools/cleanMonitoring/0/" class="btn btn-danger btn-small"><i class="fa fa-times-circle "></i>{L key = "admin.system.tpl.cleanall"}</a>
	
	{if usersDB::isDeveloper()}
		<span class="line-vertical"></span> 
		{if config::getSystemRun("monitoringAlexa")}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/monitoringAlexa/" class="btn btn-success btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.statistics.tpl.alex"}</a>
		{else}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/monitoringAlexa/" class="btn btn-danger btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.statistics.tpl.alex"}</a>
		{/if}	
		{if config::getSystemRun("monitoringGoogle")}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/monitoringGoogle/" class="btn btn-success btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.statistics.tpl.google"}</a>
		{else}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/monitoringGoogle/" class="btn btn-danger btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.statistics.tpl.google"}</a>
		{/if}	
		{if !config::getSystemRun("requestLog")}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/requestLog/"  data-toggle="tooltip" data-placement="bottom" data-original-title="System jest konieczny do działania statystyk!" class="btn btn-danger btn-small"><i class="fa fa-power-off "></i>Aktywuj RequestLog</a>
		{/if}				
		{if config::getSystemRun("monitoring")}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/monitoring/" data-toggle="tooltip" data-placement="bottom" data-original-title="System jest konieczny do działania statystyk!" class="btn btn-success btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.statistics.tpl.deactivate"}</a>
		{else}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/monitoring/" class="btn btn-danger btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.statistics.tpl.activate"}/a>
		{/if}	
	{/if}	
</div>	
{if !config::getSystemRun("monitoring")}
	<div class="alert alert-error">
	  {L key = "admin.common.statistics.tpl.warning"}
	</div>
{else}
	{if !config::getSystemRun("requestLog")}
		<div class="alert alert-error">	
		  {L key = "admin.system.tpl.acceslogwarn"}
		</div>
	{/if}	
{/if}
{if $chartType==''}{$chartType = 'pageViewsUniqueCookiesIP'}{/if}
<div class="row-fluid">
	<div class="span3">
		<div class="box">
			<h5><i class="fa fa-list-alt icon-margin icon-grey"></i> {L key = "admin.common.statistics.tpl.stats"}</h5>
			<table class="table table-striped">
		 	 <tbody>
				{foreach $systemStatusColumns as $key=>$val}
					{if $systemStatusDB->fetchCount("{$key}")!=0}
					    <tr {if $key == $chartType}class="active"{/if}>
					 	    <td>
				  		    	<i class="color-icons icons-system-monitor--arrow icon-margin"> </i>
								<a href="{$HOME}admin/tools/monitoring/showStatChart/{$key}/">{$key}</a>
					  	    </td>
					 	    <td class="align-right">
                                {$trend = $systemStatusDB->getTrend("{$key}")}
                                <span class="badge {if $trend<0}badge-important{elseif $trend>0}badge-success{/if}">{$trend|round:1}</span>
					  	    </td>
				  	  	</tr>
				  	 {/if} 	
				{/foreach} 	
			  </tbody>
			</table>
		</div>
				
	</div>		
	<div class="span9">
		<div class="box-floating">
		  <div class="box">		
		    
			<h5><i class="fa fa-signal icon-margin icon-grey"></i> {$chartType} {L key = "admin.common.statistics.tpl.last90"}</h5>
		  	{literal}
			    <script type="text/javascript">
			    
			      google.load("visualization", "1", {packages:["corechart"]});
			      $(document).ready(function() {
				      window.dataStatLast = google.visualization.arrayToDataTable([
						  {/literal}
						  ['Date', 'Views'],
						  {foreach array_reverse($systemStatusDB->fetchAll(null, 'id DESC', '*',90)) as $stat}
						  ['{$stat->date}', {intval($stat->$chartType)}],
						  {/foreach}
				     	  {literal}
				        ]);
				      drawLineChartMedium('chartLineStatLast',window.dataStatLast);
				  }); 
			    </script>
			 {/literal}		
			 <div id="chartLineStatLast" style="width: 99.9%; height:200px;"></div>  	
			 
			
			 <h5><i class="fa fa-signal icon-margin icon-grey"></i> {$chartType} {L key = "admin.common.statistics.tpl.increases"}</h5>		
		  	 {literal}
			    <script type="text/javascript">
			      google.load("visualization", "1", {packages:["corechart"]});
			      $(document).ready(function() {
				      window.dataStat = google.visualization.arrayToDataTable([
						  {/literal}
						  ['Date', 'Views'],
						  {$last=$systemStatusDB->fetchRow(null, 'id ASC', '*')->$chartType}
						  {foreach array_reverse($systemStatusDB->fetchAll(null, 'id DESC', '*')) as $stat}
						  ['{$stat->date}', {intval($stat->$chartType-$last)}],
						  {$last = intval($stat->$chartType)}
						  {/foreach}
				     	  {literal}
				        ]);
				      drawLineChartMedium('chartLineStat',window.dataStat);
				  }); 
			    </script>
			 {/literal}		
			 <div id="chartLineStat" style="width: 99.9%; height:200px;"></div>  	

		  </div>
		  <div class="row-fluid">
		  	  {if $systemStatusDB->fetchCount()<1}
		  	  	{$mean = 0}
			  {else}
			  	{$mean = (($systemStatusDB->fetchSum($chartType))/($systemStatusDB->fetchCount()))}
			  {/if}
		  	  
			  <div class="span6 box pad margin-top align-center mobileHidden">
	   	 		{L key = "admin.common.statistics.tpl.today"}
	   	 		<h2>{$systemStatusDB->fetchRow(null,'id DESC')->$chartType|ceil}</h2>
	   	 	  </div>
   	 	  			  
			  <div class="span6 box pad margin-top align-center mobileHidden">
	   	 		{L key = "admin.common.statistics.tpl.avg"}
	   	 		<h2>{$mean|ceil}</h2>
	   	 	  </div>
   	 	  </div>
	  </div>
	</div>	
</div>
