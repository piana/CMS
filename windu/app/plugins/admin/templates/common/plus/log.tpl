<div class="tab-menu-top">
	<a href="{$HOME}admin/system/log/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.common.log.tpl.logs"}</h3>	
	<a href="{$HOME}admin/system/log/showLogs/1/" class="btn btn-small">{L key = "admin.common.log.tpl.error"}</a>
	<a href="{$HOME}admin/system/log/showLogs/99/" class="btn btn-small">{L key = "admin.common.log.tpl.syserror"}</a>
	<a href="{$HOME}admin/system/log/showLogs/2_3/" class="btn btn-small">{L key = "admin.common.log.tpl.logerror"}</a>
	<a href="{$HOME}admin/system/log/showLogs/10/" class="btn btn-small">{L key = "admin.system.tpl.update"}</a>
    <a href="{$HOME}admin/system/log/showLogs/30_31_32_33/" class="btn btn-small">Zapis bazy</a>
	<span class="line-vertical"></span>
	<a href="{$HOME}admin/do/system/clean/30/" class="btn btn-small">{L key = "admin.system.tpl.cleanlast30"}</a>
	<a href="{$HOME}admin/do/system/clean/0/" class="btn btn-warning btn-small">{L key = "admin.system.tpl.cleanall"}</a>
	{if usersDB::isDeveloper()}
		<span class="line-vertical"></span> 
		{if config::getSystemRun("log")}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/log/" class="btn btn-success btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.log.tpl.deact"}</a>
		{else}
			<a href="{$HOME}admin/mainDo/toggleSystemRun/log/" class="btn btn-danger btn-small"><i class="fa fa-power-off "></i>{L key = "admin.common.log.tpl.act"}</a>
		{/if}	
	{/if}
</div>		
{if !config::getSystemRun("log")}
	<div class="alert alert-error">
	  {L key = "admin.common.log.tpl.warn"}
	</div>
{/if}
<div class="row-fluid">   	 
   	  <div class="span2 mobileHidden">
   	  	<div class="box pad margin-bottom align-center">
 			{L key = "admin.common.log.tpl.logs"}
 			<h2>{$logDB->fetchCount()}</h2>
 		</div>
   	 	<div class="box margin-bottom">
   	 		<h5><i class="fa fa-info-circle icon-margin icon-grey"></i> {L key = "admin.common.log.tpl.types"}</h5>
	  		{assign "cname" "COUNT(bucket)"}
			<table class="table table-striped">
			  <tbody>			  	
	  			{foreach $logDB->fetchCountGroup('bucket',$whereDate) as $domain}
				<tr>
					<td>{$domain->bucket|truncate:15}</td>
					<td class="align-center"><h2>{$domain->$cname}</h2></td>
				</tr>			  		
	  			{/foreach}
			  </tbody>
			</table>
		</div>				   	 		
	  </div>	
	  <div class="span10">
	  	<div class="box">
	  	<h5><i class="fa fa-list-alt icon-margin icon-grey"></i> {L key = "admin.common.log.tpl.loglist"}</h5>
	  	{literal}
		    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
		    <script type="text/javascript">
		    
		      google.load("visualization", "1", {packages:["corechart"]});
		      $(document).ready(function() {
			      window.dataStatLast = google.visualization.arrayToDataTable([
					  {/literal}
					  ['Date', 'Logi'],
		    	      {$lastMailing = 0}
		    	      {foreach generate::appendChartArrayEmptyRows($logDB->fetchCountGroup("strftime('%Y%m%d', createTime)",$logId,'createTime','*'),'createTime',"COUNT(strftime('%Y%m%d', createTime))",24*3600) as $stat}
		    	      ['{$stat->createTime}', {$stat->{"COUNT(strftime('%Y%m%d', createTime))"}}],
		    	      {$lastMailing = $stat->{"COUNT(strftime('%Y%m%d', createTime))"}}
		    	      {/foreach}
			     	  {literal}
			        ]);
			      drawLineChartMedium('chartLineStatLast',window.dataStatLast);
			  }); 
		    </script>
		 {/literal}		
		 <div id="chartLineStatLast" style="width: 99.9%; height:200px;"></div>  		  	
	  	{if isset($errorLogsByError)}
	  		{include file='common/log_list.tpl' whereDate=$errorLogsByError groupBy='id'}
	  	{elseif isset($logId)}
	  		{include file='common/log_list.tpl' whereDate=$logId groupBy='data'}
	  	{else}		  	
	  		{include file='common/log_list.tpl' whereDate="" groupBy='data'}
	  	{/if}
	  	</div>
	  </div>
</div>
	