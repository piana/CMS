<div class="tab-menu-top">
	<a href="{$HOME}admin/system/system/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.system.tpl.system"}</h3>	
	<a href="{$HOME}admin/do/system/vacuumSystem/" class="btn btn-warning">{L key = "admin.system.tpl.systemclear"}</a>
	<a href="{$HOME}admin/do/system/cleanSystem/" class="btn btn-danger">{L key = "admin.system.tpl.strongsystemclear"}</a>
</div>	
    <div class="row-fluid">
		<div class="span2 mobileHidden">
		  	<div class="box margin-bottom align-center" style="padding-top:15px;">
	  	<div class="pad">
	  	{if check::update(false,false)}
	  		<i class="fa fa-exclamation-triangle fa-4x icon-yellow"></i>
			<h4>{L key = "admin.common.conservation.tpl.warning"}</h4>
			{L key = "admin.common.conservation.tpl.recommendact"}<br><br>
	  		<a href="{$HOME}admin/update/" class="btn btn-warning btn-large">{L key = "admin.system.tpl.updatesystem"}</a>
		{else}
			<i class="fa fa-check fa-4x icon-green"></i>
			<h4>{L key = "admin.common.conservation.tpl.systemuptodate"}</h4>
			{L key = "admin.common.conservation.tpl.yoursystemuptodate"} <strong>{config::get(revision)}</strong><br><br>
		{/if}
		</div>
	</div>	
  	<div class="box margin-bottom align-center" style="padding-top:15px;">
	  	<div class="pad">
	  	{if check::widgetUpdate()}
	  		<i class="fa fa-exclamation-triangle fa-4x icon-yellow"></i>
			<h4>{L key = "admin.common.conservation.tpl.warning"}</h4>
			{L key = "admin.common.conservation.tpl.recommendact"}<br><br>
	  		<a href="{$HOME}admin/do/themes/updateAllWidgets/" class="btn btn-primary btn-large">{L key = "admin.common.conservation.tpl.updateallwidgets"}</a>
		{else}
			<i class="fa fa-check fa-4x icon-green"></i>
			<h4>{L key = "admin.common.conservation.tpl.widgetuptodate"}</h4>
			{L key = "admin.common.conservation.tpl.yourwidgetuptodate"}<br><br>
		{/if}
		</div>
	</div>	
			
  </div>	
      	
  <div class="span5">
  	<div class="box margin-bottom">
  		<h5><i class="fa fa-exclamation-circle icon-margin icon-grey"></i> {L key = "admin.system.tpl.commonsystemerrors"}</h5>

  	{literal}
	    <script type="text/javascript">
	    
	      google.load("visualization", "1", {packages:["corechart"]});
	      $(document).ready(function() {
		      window.dataConservationLast = google.visualization.arrayToDataTable([
				  {/literal}
				  ['Date', 'Logi'],
	    	      {foreach $logDB->fetchCountGroup("strftime('%Y%m%d', createTime)",'bucket = 99','createTime','*',30) as $stat}
	    	      ['{$stat->createTime}', {$stat->{"COUNT(strftime('%Y%m%d', createTime))"}}],
	    	      {/foreach}
		     	  {literal}
		        ]);
		      drawLineChartMedium('chartLineStatLastConservation',window.dataConservationLast);
		  }); 
	    </script>
	 {/literal}		
	 <div id="chartLineStatLastConservation" style="width: 99.9%; height:200px;"></div>  		  		
		<table class="table table-striped">
		  <tbody>
			{assign "cname" 'COUNT(data)'}
		    {foreach $logDB->fetchCountGroup('data',"bucket = 99",null,'*', 10) as $log}
			<tr>
				<td><span data-toggle="tooltip" data-placement="left" title="{$log->data|escape:'html'|truncate:500}"><i class="color-icons icons-exclamation-red icon-margin">&nbsp;</i>{$log->data|truncate:40}</span></td>
				<td class="align-right"><span class="badge badge-important">{$log->$cname}</span></td>
			</tr>
		  {/foreach}   
		  </tbody>
		</table>					
	</div>			 			  
	  	<div class="box">
	  		<h5><i class="fa fa-user icon-margin icon-grey"></i> {L key = "admin.system.tpl.lastusers"}</h5>
			<table class="table table-striped">
			  <tbody>
			  	{assign "cname" 'COUNT(data)'}
			  {foreach $logDB->fetchCountGroup('data',"bucket = 2 or bucket = 3","createTime DESC",'*',10) as $log}
			<tr>
				<td><i class="color-icons {if $log->bucket == 2}icons-user-white{else}icons-user-thief{/if} icon-margin">&nbsp;</i>{$log->data}</td>
				<td>{$log->$cname}</td>
				<td>{generate::showDatatime($log->createTime)}</td>
				<td class="smallWidthHidden">{$log->createIp}</td>
			</tr>
		  {/foreach}   
				  </tbody>
				</table>			  		
		</div>
	</div>
  
  <div class="span5">
	<div class="box margin-bottom">
		{if !cache::isCached("{$SITE_PATH}/data/backups/",'3600')}
			{cache::write("{$SITE_PATH}",round(baseFile::getSize("{$SITE_PATH}")/1048576,2),'disSize')}
			{cache::write("{$SITE_PATH}/data/backups/",round(baseFile::getSize("{$SITE_PATH}/data/backups/")/1048576,2),'disSize')}
			{cache::write("{$SITE_PATH}/data/files/",round(baseFile::getSize("{$SITE_PATH}/data/files/")/1048576,2),'disSize')}
			{cache::write("{$SITE_PATH}/data/database/",round(baseFile::getSize("{$SITE_PATH}/data/database/")/1048576,2),'disSize')}
			{cache::write("{$SITE_PATH}/data/themes/",round(baseFile::getSize("{$SITE_PATH}/data/themes/")/1048576,2),'disSize')}
			{cache::write("{$SITE_PATH}/cache/",round(baseFile::getSize("{$SITE_PATH}/cache/")/1048576,2),'disSize')}
		{/if}			  	
  		<h5>
			<i class="fa fa-upload icon-margin icon-grey"></i> {L key = "admin.system.tpl.memory"}
		  	<div class="buttons">
				<a href="{$HOME}admin/do/system/clearBucketCache/disSize/" class="btn btn-small btn-primary">{L key = "admin.system.tpl.refreshdata"}</a>					  		
		  	</div>						
		</h5>
		<h2 class="align-center" style="margin-top:40px;">{cache::read("{$SITE_PATH}")}MB</h2>
		
	  	{literal}
		    <script type="text/javascript">
		      google.load("visualization", "1", {packages:["corechart"]});
		      $(document).ready(function() {
			      window.dataSize = google.visualization.arrayToDataTable([
					  {/literal}
					  ['Date', 'Size'],
					  {foreach array_reverse($systemStatusDB->fetchAll(null, 'id DESC', '*', '30')) as $stat}
					  ['{$stat->date}', {$stat->size}],
					  {/foreach}
			     	  {literal}
			        ]);
			      drawLineChartSmall('chartLineSize',window.dataSize);
			  }); 
		    </script>
		 {/literal}		
		 <div id="chartLineSize" style="margin-top:-10px; width: 99.9%; height:89px;"></div> 					

  		
  		<div class="pad">
  			{assign backupsSize 100*(cache::read("{$SITE_PATH}/data/backups/")/cache::read("{$SITE_PATH}"))}
	  		{assign filesSize 100*(cache::read("{$SITE_PATH}/data/files/")/cache::read("{$SITE_PATH}"))}
	  		{assign databaseSize 100*(cache::read("{$SITE_PATH}/data/database/")/cache::read("{$SITE_PATH}"))}
	  		{assign themesSize 100*(cache::read("{$SITE_PATH}/data/themes/")/cache::read("{$SITE_PATH}"))}
	  		{assign cacheSize 100*(cache::read("{$SITE_PATH}/cache/")/cache::read("{$SITE_PATH}"))}
		  	{assign otherSize 100-($backupsSize+$filesSize+$databaseSize+$themesSize)}
		  	
			</div>	
			<table class="table table-striped">
			  <tbody>

				<tr>
					<td><i class="color-icons icons-databases icon-margin">&nbsp;</i>{L key = "admin.common.conservation.tpl.files"}</td>
					<td>{cache::read("{$SITE_PATH}/data/files/")}MB</td>
					<td class="smallWidthHidden" style="width:55%">
			  			<div class="progress progress-striped">
						  <div class="bar" style="width: {$filesSize}%"></div>
						</div>							
					</td>
				</tr>	
				<tr>
					<td><i class="color-icons icons-databases icon-margin">&nbsp;</i>{L key = "admin.common.conservation.tpl.themes"}</td>
					<td>{cache::read("{$SITE_PATH}/data/themes/")}MB</td>
					<td class="smallWidthHidden" style="width:55%">
			  			<div class="progress progress-striped">
						  <div class="bar" style="width: {$themesSize}%"></div>
						</div>							
					</td>
				</tr>
				<tr>
					<td><i class="color-icons icons-databases icon-margin">&nbsp;</i>{L key = "admin.common.conservation.tpl.database"}</td>
					<td>{cache::read("{$SITE_PATH}/data/database/")}MB</td>
					<td class="smallWidthHidden" style="width:55%">
			  			<div class="progress progress-striped">
						  <div class="bar" style="width: {$databaseSize}%"></div>
						</div>							
					</td>
				</tr>
				<tr>
					<td><i class="color-icons icons-databases icon-margin">&nbsp;</i>{L key = "admin.common.conservation.tpl.backups"}</td>
					<td>{cache::read("{$SITE_PATH}/data/backups/")}MB</td>
					<td class="smallWidthHidden" style="width:55%">
			  			<div class="progress progress-striped">
						  <div class="bar" style="width: {$backupsSize}%"></div>
						</div>							
					</td>
				</tr>
				<tr>
					<td><i class="color-icons icons-databases icon-margin">&nbsp;</i>{L key = "admin.common.conservation.tpl.cache"}</td>
					<td>{cache::read("{$SITE_PATH}/cache/")}MB</td>
					<td class="smallWidthHidden" style="width:55%">
			  			<div class="progress progress-striped">
						  <div class="bar" style="width: {$cacheSize}%"></div>
						</div>							
					</td>
				</tr>						
				<tr>
					<td><i class="color-icons icons-databases icon-margin">&nbsp;</i>{L key = "admin.common.conservation.tpl.others"}</td>
					<td>{cache::read("{$SITE_PATH}")-(cache::read("{$SITE_PATH}/data/files/")+cache::read("{$SITE_PATH}/data/themes/")+cache::read("{$SITE_PATH}/data/database/")+cache::read("{$SITE_PATH}/data/backups/")+cache::read("{$SITE_PATH}/cache/"))}MB</td>
					<td class="smallWidthHidden" style="width:55%">
			  			<div class="progress progress-striped">
						  <div class="bar" style="width: {$otherSize}%"></div>
						</div>							
					</td>
				</tr>																					
			  </tbody>
			</table>			  			
		</div>				  
		<div class="box margin-bottom">
		  	{include file='common/notify_list.tpl' simple=1}
		</div>				  
  </div>
</div>	  
