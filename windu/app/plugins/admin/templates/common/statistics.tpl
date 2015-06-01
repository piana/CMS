<div class="tab-menu-top">
	<a href="{$HOME}admin/system/stats/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
		<h3 class="pull-left tab-title"> {L key = "admin.system.tpl.stats"}</h3>	
	{if usersDB::isDeveloper()}
		{if !config::getSystemRun("requestLog")}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/requestLog/"  data-toggle="tooltip" data-placement="bottom" data-original-title="System jest konieczny do działania statystyk!" class="btn btn-danger btn-small"><i class="fa fa-power-off "></i>Aktywuj RequestLog</a>
		{/if}	
		{if !config::getSystemRun("monitoring")}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/monitoring/"  data-toggle="tooltip" data-placement="bottom" data-original-title="System jest konieczny do działania statystyk!" class="btn btn-danger btn-small"><i class="fa fa-power-off "></i>Aktywuj Monitoring</a>
		{/if}		
		{if config::getSystemRun("statistic")}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/statistic/" class="btn btn-success btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.statistics.tpl.deactivate"}</a>
		{else}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/statistic/" class="btn btn-danger btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.statistics.tpl.activate"}</a>
		{/if}	
	{/if}
</div>	
{if !config::getSystemRun("statistic")}
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
	{if $systemStatusDB->fetchCount()!=0}
		<div class="row-fluid">  
			<div class="span2 mobileHidden">	
		  	{$mean = ($systemStatusDB->fetchSum('pageViewsUniqueCookiesIP')/$systemStatusDB->fetchCount())}
			{$views1 = ($systemStatusDB->fetchSum('pageViewsUniqueCookiesIP',"date>='{generate::sqlDate(strtotime('-1 days'))}'"))}
			{$views7 = ($systemStatusDB->fetchSum('pageViewsUniqueCookiesIP',"date>='{generate::sqlDate(strtotime('-7 days'))}'"))}
			{$views30 = ($systemStatusDB->fetchSum('pageViewsUniqueCookiesIP',"date>='{generate::sqlDate(strtotime('-30 days'))}'"))}
			
				{if $mean>0}
			   	 <div class="box pad margin-bottom align-center">
					{L key = "admin.common.statistics.tpl.24"}<br>
					<h2>{$views1}<span class="stat-procent {if ($views1-$mean)>0}green{else}red{/if}">{(($views1-$mean)/$mean)|ceil}%</span></h2>   
				 </div>
				 <div class="box pad margin-bottom align-center">
					{L key = "admin.common.statistics.tpl.7days"}<br>
					<h2>{$views7}<span class="stat-procent {if ($views7/7-$mean)>0}green{else}red{/if}">{((($views7/7)-$mean)/$mean)|ceil}%</span></h2>   
			   	 </div> 
			   	 <div class="box pad margin-bottom align-center">	
					{L key = "admin.common.statistics.tpl.30days"}<br>
					<h2>{$views30}<span class="stat-procent {if ($views30/30-$mean)>0}green{else}red{/if}">{((($views30/30)-$mean)/$mean)|ceil}%</span></h2>
			   	 </div>  
				{/if}  	 		
		   	 	<div class="box pad margin-bottom align-center">
		   	 		{L key = "admin.common.statistics.tpl.avg24"}
		   	 		<h2>{$mean|ceil}</h2>
		   	 	</div>
		   	 	<div class="box pad margin-bottom align-center">
		   	 		{L key = "admin.common.statistics.tpl.avg7"}
		   	 		<h2>{($mean*7)|ceil}</h2>
		   	 	</div>
		   	 	<div class="box pad margin-bottom align-center">
		   	 		{L key = "admin.common.statistics.tpl.avg30"}
		   	 		<h2>{($mean*30)|ceil}</h2>
		   	 	</div>
			</div>  
		  <div class="span10">
						<div class="box box-silver margin-bottom">
							<ul id="requestTab" class="nav nav-tabs" style="margin-bottom:0px;">
				              <li class="" style="margin-left:5px;"><a href="#weekStat" data-toggle="tab">{L key = "admin.common.statistics.tpl.last7"}</a></li>
				              <li class="active"><a href="#monthStat" data-toggle="tab">{L key = "admin.common.statistics.tpl.range"}</a></li>
		
				            </ul>		
							<div id="requestTabContent" class="tab-content">
				              <div class="tab-pane" id="weekStat">
								<h5><i class="fa fa-globe icon-margin icon-grey"></i> {L key = "admin.common.statistics.tpl.visits"}</h5>
								{if !cache::isCached("lastVisitsAccessLog",'7200')}
									{cache::write("lastVisitsAccessLog",array_reverse($accesslogDB->fetchCountGroup("hour","visitCookie=0",'insertTime DESC','*',168)),'accessLog')}
								{/if}
								{assign lastVisitsAccessLog cache::read("lastVisitsAccessLog")}
						  		{literal}
							    <script type="text/javascript">
							      google.load("visualization", "1", {packages:["corechart"]});
							      $(document).ready(function() {
							    	  window.dataStatHourDay = google.visualization.arrayToDataTable([
							    	      {/literal}
							    	      ['Date', 'Requests'],
							    	      {foreach generate::appendChartArrayEmptyRows($lastVisitsAccessLog,'insertTime',"COUNT(hour)",3600,168) as $stat}
							    	      ['{$stat->insertTime}', {$stat->{"COUNT(hour)"}}],
							    	      {/foreach}
							    	      {literal}
								        ]);
								      drawLineChartMedium('chartLineStatHourDay',window.dataStatHourDay);
								  }); 
							    </script>
							 	{/literal}		
								<div id="chartLineStatHourDay" style="width: 99.9%; height:200px;"></div> 	
		             
				              </div>
				              <div class="tab-pane active in" id="monthStat">
			
									<h5><i class="fa fa-globe icon-margin icon-grey"></i> {L key = "admin.common.statistics.tpl.visits"}</h5>
								  	{literal}
									    <script type="text/javascript">
									      google.load("visualization", "1", {packages:["corechart"]});
									      $(document).ready(function() {
										      window.dataStat = google.visualization.arrayToDataTable([
												  {/literal}
												  ['Date', 'Visits'],
												  {foreach generate::appendChartArrayEmptyRows(array_reverse($systemStatusDB->fetchAll(null, 'id DESC')),'date','pageViewsUniqueCookiesIP',24*3600) as $stat}
												  ['{$stat->date}', {intval($stat->pageViewsUniqueCookiesIP)}],
												  {/foreach}
										     	  {literal}
										        ]);
										      drawLineChartMedium('chartLineStat',window.dataStat);
										  }); 
									    </script>
									 {/literal}		
									 <div id="chartLineStat" style="width: 99.9%; height:200px;"></div>  
									 
									<h5><i class="fa fa-random icon-margin icon-grey"></i> {L key = "admin.common.statistics.tpl.visitsacc"}</h5>
								  	{literal}
									    <script type="text/javascript">
									      google.load("visualization", "1", {packages:["corechart"]});
									      $(document).ready(function() {
										      window.dataStatMore = google.visualization.arrayToDataTable([
												  {/literal}
												  ['Date', 'Visits by Cookie', 'Visits by IP'],
												  {foreach generate::appendChartArrayEmptyRows(array_reverse($systemStatusDB->fetchAll(null, 'id DESC')),'date','pageViewsUniqueCookie',24*3600) as $stat}
												  ['{$stat->date}', {intval($stat->pageViewsUniqueCookie)}, {intval($stat->pageViewsUniqueIP)}],
												  {/foreach}
										     	  {literal}
										        ]);
										      drawLineChartMedium('chartLineStatMore',window.dataStatMore);
										  }); 
									    </script>
									 {/literal}		
									 <div id="chartLineStatMore" style="width: 99.9%; height:200px;"></div> 		 
							  
									<h5><i class="icon-circle-arrow-right icon-margin icon-grey"></i> {L key = "admin.common.statistics.tpl.requests"}</h5>
								  	{literal}
									    <script type="text/javascript">
									      google.load("visualization", "1", {packages:["corechart"]});
									      $(document).ready(function() {
										      window.dataStatRequest = google.visualization.arrayToDataTable([
												  {/literal}
												  ['Date', 'Visits'],
												  {foreach generate::appendChartArrayEmptyRows(array_reverse($systemStatusDB->fetchAll(null, 'id DESC')),'date','requests',24*3600) as $stat}
												  ['{$stat->date}', {intval($stat->requests)}],
												  {/foreach}
										     	  {literal}
										        ]);
										      drawLineChartMedium('chartLineStatRequest',window.dataStatRequest);
										  }); 
									    </script>
									 {/literal}		
									 <div id="chartLineStatRequest" style="width: 99.9%; height:200px;"></div>  
			
				              </div>
		 
				            </div>	
				         </div>	 
		  </div>
		</div>
	{else}
	<div class="alert alert-info">
	  {L key = "admin.nodata"}
	</div>
	{/if}
