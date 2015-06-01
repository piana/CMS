<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div id="filesModalPanel" class="modal hide in" tabindex="-1" role="dialog" aria-labelledby="filesModalLabel" aria-hidden="false" style="display: none; ">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="filesModalLabel">{L key = "admin.content.common.tpl.addfiles"}</h3>
	</div>
	<div class="modal-body">
		<iframe src="{$HOME}admin/ajax/files/modalUploader/main/"></iframe>
	</div>
</div>	
<div class="tab-menu-top">
	<a href="{$HOME}admin/content/files/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
	<h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.file"}</h3>
	<a href="#filesModalPanel" class="btn btn-small btn-primary" data-toggle="modal" data-target="#filesModalPanel"><i class="fa fa-plus-circle icon-button icon-margin"></i>{L key = "admin.common.tpl.addfile"}</a>
</div>	
<div class="row-fluid">
	{if $filesDB->fetchCount()==0}
		<div class="center-box">
			<a href="#filesModalPanel" data-toggle="modal" data-target="#filesModalPanel" class="btn btn-large">
				<i class="fa fa-plus-circle fa-2x"></i>
				{L key = "admin.common.tpl.addfile"}
			</a>
		</div>	
	{else}		
	  <div class="{if isset($formEditFile)}span4{else}span12{/if}">
		{$pageCount = 20}
		{$page = $pageCount*$REQUEST->getVariable('p')}
		{$elementCount = $filesDB->fetchCount()}  	
		
	  	{include file='common/paginator.tpl' elementsCount=$elementCount count=$pageCount}
	  	<div class="box">
			<h5><i class="fa fa-upload icon-margin icon-grey"></i>{L key = "admin.common.tpl.list"}</h5>
			{if isset($formEditFile)}
				{include file='common/files_list.tpl'}
			{else}
				{include file='common/files_list.tpl' extended=1}
			{/if}
		</div>
		{include file='common/paginator.tpl' elementsCount=$elementCount count=$pageCount}
	  </div>
	  {if isset($formEditFile)}
	  	<div class="span8">
	  		<div class="box-floating">
	  			<div class="box">
	  				{$fileLogs = $filesLogDB->fetchCountGroup("strftime('%Y%m%d', createTime)","fileId = {$REQUEST->getVariable('id')}",'createTime','*')}
				  	{if count($fileLogs)>0}
					  	<h5><i class="fa fa-signal icon-margin icon-grey"></i> {L key = "admin.common.tpl.downstats"}</h5>
		
					  	{literal}
						    <script type="text/javascript">
						      google.load("visualization", "1", {packages:["corechart"]});
						      $(document).ready(function() {
							      window.dataStatLast = google.visualization.arrayToDataTable([
									  {/literal}
									  ['Date', 'Pobrania'],
						    	      {$lastMailing = 0}
						    	      {foreach $fileLogs as $stat}
						    	      ['{$stat->createTime}', {$stat->{"COUNT(strftime('%Y%m%d', createTime))"}}],
						    	      {$lastMailing = $stat->{"COUNT(strftime('%Y%m%d', createTime))"}}
						    	      {foreachelse}
						    	      ['0000-00-00 00:00:00', 0]
						    	      {/foreach}
							     	  {literal}
							        ]);
							      drawLineChartMedium('chartLineStatLast',window.dataStatLast);
							  }); 
						    </script>
						 {/literal}		
						 <div id="chartLineStatLast" style="width: 99.9%; height:200px;"></div>  	 
					{/if} 			
			  		<h5><i class="fa fa-pencil icon-margin icon-grey">&nbsp;</i> {L key = "admin.common.tpl.editfile"}</h5>
			  		{$formEditFile->toHtml()}
				</div>
			</div>				
	  	</div>
	  {/if}
	{/if}  
</div>	 
  	