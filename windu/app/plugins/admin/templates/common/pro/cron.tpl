<div class="tab-menu-top">
	<a href="{$HOME}admin/system/cron/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.system.tpl.cron"}</h3>
	<a href="{$HOME}admin/do/system/cleanCronLog/30/" class="btn btn-warning btn-small">{L key = "admin.system.tpl.cleanlast30"}</a>
	<a href="{$HOME}admin/do/system/cleanCronLog/0/" class="btn btn-danger btn-small">{L key = "admin.system.tpl.cleanall"}</a>
</div>	
	 <div class="row-fluid">   	 
    	  <div class="span{if usersDB::isDeveloper()}3{else}2{/if} mobileHidden">
    	  	{if usersDB::isDeveloper()}
    	  	<div class="box margin-bottom">
    	  		<h5>{L key = "admin.system.tpl.crontasks"}</h5>
				<table class="table table-striped tablesort">
				  <tbody>
				  {foreach cron::$cronTasks as $keyTask => $task}
					<tr>
						<td>{L key=$task}</td>
						<td class="align-right">
							<div class="buttons">
								<a onclick="loadDoActionGreen('{$HOME}admin/do/tools/toggleCronConfigAjax/{$keyTask}/','#croninstalled-{$keyTask}')" id='croninstalled-{$keyTask}'><i class="fa fa-check-circle {if config::get($keyTask) != '0'}icon-green{else}icon-red{/if}">&nbsp;</i></a>
							</div>
						</td>
					</tr>
				  {/foreach}   
				  </tbody>
				</table>    	  		
    	  	</div>	
    	  	{/if}
    	  	<div class="box pad margin-bottom align-center">
   	 			{L key = "admin.controller.pro.cron.tpl.last24"}
   	 			<h2>{$logDB->fetchCount("createTime>='{generate::sqlDatetime(strtotime('-1 day'))}'")}</h2>
   	 		</div>
     	  	<div class="box pad margin-bottom align-center">
   	 			{L key = "admin.controller.pro.cron.tpl.last7"}
   	 			<h2>{$logDB->fetchCount("createTime>='{generate::sqlDatetime(strtotime('-7 days'))}'")}</h2>
   	 		</div>  
     	  	<div class="box pad margin-bottom align-center">
   	 			{L key = "admin.controller.pro.cron.tpl.last30"}
   	 			<h2>{$logDB->fetchCount("createTime>='{generate::sqlDatetime(strtotime('-30 days'))}'")}</h2>
   	 		</div>   	 			 		
		  </div>	
		  <div class="span{if usersDB::isDeveloper()}9{else}10{/if}">
			  <div class="box box-silver">
				<ul id="requestTab" class="nav nav-tabs" style="margin-bottom:0px;">
	              <li class="active" style="margin-left:5px;"><a href="#hour" data-toggle="tab"><i class="fa fa-clock-o icon-margin icon-grey"></i> 	{L key = "admin.controller.pro.cron.tpl.hour"}</a></li>
	              <li class=""><a href="#day" data-toggle="tab"><i class="fa fa-calendar icon-margin icon-grey"></i> 	{L key = "admin.controller.pro.cron.tpl.day"}</a></li>
	              <li class=""><a href="#week" data-toggle="tab"><i class="fa fa-calendar icon-margin icon-grey"></i> 	{L key = "admin.controller.pro.cron.tpl.week"}</a></li>
	              <li class=""><a href="#month" data-toggle="tab"><i class="fa fa-calendar icon-margin icon-grey"></i> 	{L key = "admin.controller.pro.cron.tpl.month"}</a></li>
	              <li class=""><a href="#all" data-toggle="tab"><i class="fa fa-repeat icon-margin icon-grey"></i> 	{L key = "admin.controller.pro.cron.tpl.all"}</a></li>              
	            </ul>		
				<div id="requestTabContent" class="tab-content">
	              <div class="tab-pane" id="all">

						<table class="table table-striped">
						  <tbody>			  	
				  			{foreach $cronlogDB->fetchAll(null,'id DESC','*',90) as $cronelog}
							<tr>
								<td><i class="color-icons icons-clock-history-frame icon-margin">&nbsp;</i> {generate::showDatatime($cronelog->createTime)}</td>
								<td>
									{foreach unserialize($cronelog->message) as $message}
										<i class="color-icons icons-tick icon-margin">&nbsp;</i> {$message = explode('_',$message)}{L key=$message.0} {if $message.1!=''}<span class="badge badge-info">{$message.1}</span>{/if}<br>						
									{/foreach}
								</td>
								<td class="align-right"><span class="badge {if $cronelog->executeTime>15}badge-important{elseif $cronelog->executeTime>5}badge-warning{else}badge-inverse{/if}">{$cronelog->executeTime}</span></td>
							</tr>			  		
				  			{/foreach}
						  </tbody>
						</table>
             
	              </div>
	
	              <div class="tab-pane active in" id="hour">
	              {$cronHourBucket = $cronlogDB->fetchAll("bucket={cronlogDB::BUCKET_HOUR}",'id DESC','*',72)}
	              
		  	{literal}
			    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
			    <script type="text/javascript">
			    
			      google.load("visualization", "1", {packages:["corechart"]});
			      $(document).ready(function() {
				      window.dataStatCronHour = google.visualization.arrayToDataTable([
						  {/literal}
						  ['Date', 'Execute Time'],
			    	      {foreach generate::appendChartArrayEmptyRows(array_reverse($cronHourBucket),'createTime','executeTime',3600,72) as $stat}
			    	      ['{$stat->createTime}', {$stat->executeTime}],
			    	      {/foreach}
				     	  {literal}
				        ]);
				      drawLineChartMedium('dataStatCronHour',window.dataStatCronHour);
				  }); 
			    </script>
			 {/literal}		
			 <div id="dataStatCronHour" style="width: 99.9%; height:200px;"></div> 
			 
						<table class="table table-striped">
						  <tbody>			  	
				  			{foreach $cronHourBucket as $cronelog}
							<tr>
								<td><i class="color-icons icons-clock-history-frame icon-margin">&nbsp;</i> {generate::showDatatime($cronelog->createTime)}</td>
								<td>
									{foreach unserialize($cronelog->message) as $message}
										<i class="color-icons icons-tick icon-margin">&nbsp;</i> {$message = explode('_',$message)}{L key=$message.0} {if $message.1!=''}<span class="badge badge-info">{$message.1}</span>{/if}<br>						
									{/foreach}
								</td>
								<td class="align-right"><span class="badge {if $cronelog->executeTime>15}badge-important{elseif $cronelog->executeTime>5}badge-warning{else}badge-inverse{/if}">{$cronelog->executeTime}</span></td>
							</tr>			  		
				  			{/foreach}
						  </tbody>
						</table>
           
	              </div>
	
	              <div class="tab-pane" id="day">
	              {$cronDayBucket = $cronlogDB->fetchAll("bucket={cronlogDB::BUCKET_DAY}",'id DESC','*',90)}
	              
		  	{literal}
			    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
			    <script type="text/javascript">
			    
			      google.load("visualization", "1", {packages:["corechart"]});
			      $(document).ready(function() {
				      window.dataStatCronDay = google.visualization.arrayToDataTable([
						  {/literal}
						  ['Date', 'Execute Time'],
			    	      {foreach generate::appendChartArrayEmptyRows(array_reverse($cronDayBucket),'createTime','executeTime',24*3600,90) as $stat}
			    	      ['{$stat->createTime}', {$stat->executeTime}],
			    	      {/foreach}
				     	  {literal}
				        ]);
				      drawLineChartMedium('dataStatCronDay',window.dataStatCronDay);
				  }); 
			    </script>
			 {/literal}		
			 <div id="dataStatCronDay" style="width: 99.9%; height:200px;"></div> 
			 	              
						<table class="table table-striped">
						  <tbody>			  	
				  			{foreach $cronDayBucket as $cronelog}
							<tr>
								<td><i class="color-icons icons-clock-history-frame icon-margin">&nbsp;</i> {generate::showDatatime($cronelog->createTime)}</td>
								<td>
									{foreach unserialize($cronelog->message) as $message}
										<i class="color-icons icons-tick icon-margin">&nbsp;</i> {$message = explode('_',$message)}{L key=$message.0} {if $message.1!=''}<span class="badge badge-info">{$message.1}</span>{/if}<br>						
									{/foreach}
								</td>
								<td class="align-right"><span class="badge {if $cronelog->executeTime>15}badge-important{elseif $cronelog->executeTime>5}badge-warning{else}badge-inverse{/if}">{$cronelog->executeTime}</span></td>
							</tr>			  		
				  			{/foreach}
						  </tbody>
						</table>
	              </div>
	
	              <div class="tab-pane" id="week">
	              {$cronWeekBucket = $cronlogDB->fetchAll("bucket={cronlogDB::BUCKET_WEEK}",'id DESC','*')}
	              
		  	{literal}
			    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
			    <script type="text/javascript">
			    
			      google.load("visualization", "1", {packages:["corechart"]});
			      $(document).ready(function() {
				      window.dataStatCronWeek = google.visualization.arrayToDataTable([
						  {/literal}
						  ['Date', 'Execute Time'],
			    	      {foreach generate::appendChartArrayEmptyRows(array_reverse($cronWeekBucket),'createTime','executeTime',7*24*3600) as $stat}
			    	      ['{$stat->createTime}', {$stat->executeTime}],
			    	      {/foreach}
				     	  {literal}
				        ]);
				      drawLineChartMedium('dataStatCronWeek',window.dataStatCronWeek);
				  }); 
			    </script>
			 {/literal}		
			 <div id="dataStatCronWeek" style="width: 99.9%; height:200px;"></div> 
			 	              
					<table class="table table-striped">
					  <tbody>			  	
			  			{foreach $cronWeekBucket as $cronelog}
						<tr>
							<td><i class="color-icons icons-clock-history-frame icon-margin">&nbsp;</i> {generate::showDatatime($cronelog->createTime)}</td>
							<td>
								{foreach unserialize($cronelog->message) as $message}
									<i class="color-icons icons-tick icon-margin">&nbsp;</i> {$message = explode('_',$message)}{L key=$message.0} {if $message.1!=''}<span class="badge badge-info">{$message.1}</span>{/if}<br>						
								{/foreach}
							</td>
							<td class="align-right"><span class="badge {if $cronelog->executeTime>15}badge-important{elseif $cronelog->executeTime>5}badge-warning{else}badge-inverse{/if}">{$cronelog->executeTime}</span></td>
						</tr>			  		
			  			{/foreach}
					  </tbody>
					</table>
	              </div>
	
	              <div class="tab-pane" id="month">
	              {$cronMonthBucket = $cronlogDB->fetchAll("bucket={cronlogDB::BUCKET_MONTH}",'id DESC')}
	              
		  	{literal}
			    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
			    <script type="text/javascript">
			    
			      google.load("visualization", "1", {packages:["corechart"]});
			      $(document).ready(function() {
				      window.dataStatCronMonth = google.visualization.arrayToDataTable([
						  {/literal}
						  ['Date', 'Execute Time'],
			    	      {foreach generate::appendChartArrayEmptyRows(array_reverse($cronMonthBucket),'createTime','executeTime',31*7*24*3600) as $stat}
			    	      ['{$stat->createTime}', {$stat->executeTime}],
			    	      {/foreach}
				     	  {literal}
				        ]);
				      drawLineChartMedium('dataStatCronMonth',window.dataStatCronMonth);
				  }); 
			    </script>
			 {/literal}		
			 <div id="dataStatCronMonth" style="width: 99.9%; height:200px;"></div> 
			 	              
					<table class="table table-striped">
					  <tbody>			  	
			  			{foreach $cronMonthBucket as $cronelog}
						<tr>
							<td><i class="color-icons icons-clock-history-frame icon-margin">&nbsp;</i> {generate::showDatatime($cronelog->createTime)}</td>
							<td>
								{foreach unserialize($cronelog->message) as $message}
									<i class="color-icons icons-tick icon-margin">&nbsp;</i> {$message = explode('_',$message)}{L key=$message.0} {if $message.1!=''}<span class="badge badge-info">{$message.1}</span>{/if}<br>						
								{/foreach}
							</td>
							<td class="align-right"><span class="badge {if $cronelog->executeTime>15}badge-important{elseif $cronelog->executeTime>5}badge-warning{else}badge-inverse{/if}">{$cronelog->executeTime}</span></td>
						</tr>			  		
			  			{/foreach}
					  </tbody>
					</table>
	              </div>
	            </div>	                        		  
			  </div>
		</div> 
	</div>
		