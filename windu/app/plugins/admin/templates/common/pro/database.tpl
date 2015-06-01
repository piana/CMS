<div class="tab-menu-top">
	<a href="{$HOME}admin/tools/database/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.database"}</h3>	
	{$formDatabaseSearch->toHtml()}
	{if $smarty.const.DB_TYPE=='sqlite'}<a href="{$HOME}admin/tools/database/migrationConnectionSetup/" class="btn btn-warning btn-small">{L key = "admin.common.conservation.tpl.migration"}</a>{/if}
	<a href="{$HOME}admin/do/system/vacuumDatabase/" class="btn btn-small">{L key = "admin.common.conservation.tpl.cleandatabase"}</a>
</div>
{if is_array($searchResult)}
<div class="row-fluid">
	<div class="span12 box">
		<h5>Wynik wyszukiwania dla <span class="badge">{$searchString}</span></h5>
	  	<table class="table table-striped tablesort">
	  		<thead>
	  			<tr>
			 		<th>Tabela</th>
			 		<th>Id</th>
			 		<th>Zawartosc</th>
				</tr>
	  		</thead>
			{foreach $searchResult as $key=>$result}
			    {foreach $result as $resultRow}
				<tr>
					<td><a href="{$HOME}admin/tools/database/editRow/{$key}/{$resultRow->id}/#{$resultRow->id}" class="badge badge-inverse">{$key}</a></td>
					<td><a href="" class="badge">{$resultRow->id}</a></td>
					<td>
						{foreach $resultRow as $resultColumn}
							{str_ireplace($searchString,"<span class='badge badge-warning'>{$searchString}</span>",$resultColumn)}
	                    {/foreach}
                    </td>
                </tr>  
                {/foreach} 
			{/foreach}
		</table>
	</div>
</div>	  
{elseif is_object($formMySQL) or $tablesToMigrateComma!='' or $tablesCheckResult!=''}
	<div class="row-fluid">
		<div class="span4">
			<div class="pad margin-bottom align-center">
					<i class="fa fa-sitemap fa-3x icon-dark">&nbsp;</i>
   	 			<h2>{L key = "admin.common.conservation.tpl.stepone"}</h2>
   	 			{L key = "admin.common.conservation.tpl.setconn"}
   	 		</div>	
   	 		{if $tablesToMigrateComma=='' and $tablesCheckResult==''}
	   	 		<div class="box margin-bottom align-center">		
					<h5>{L key = "admin.common.conservation.tpl.targetmysql"}</h5>
					{$formMySQL->toHtml()}
				</div>
			{else}
	   	 		<div class="align-center green box" style="padding-top:100px; padding-bottom:80px;">	
	   	 			<i class="fa fa-check fa-3x icon-green">&nbsp;</i>
					<h2>{L key = "admin.common.conservation.tpl.completed"}</h2>
				</div>				
			{/if}
		</div>	
		<div class="span4">
			<div class="pad margin-bottom align-center {if $tablesToMigrateComma=='' and $tablesCheckResult==''}silver{/if}">
				<i class="fa fa-upload fa-3x icon-dark">&nbsp;</i>
   	 			<h2>{L key = "admin.common.conservation.tpl.steptwo"}</h2>
   	 			{L key = "admin.common.conservation.tpl.transdata"}
   	 		</div>	
 			{if $tablesToMigrateComma!=''}
				<div class="box align-center">			
					<script>
						{literal}
					 	$(document).ready(function() {
					 		$.ajaxSetup ({
					 		    cache: false
					 		});
			
					 		var toCheckArray = new Array({/literal}{$tablesToMigrateComma}{literal});	
					 		var rowsCountArray = new Array({/literal}{$tablesToMigrateRowsCountComma}{literal});
					 		window.barWidth = 0;
					 		window.counter = 0;
							window.allimportedrows = 0;
							var time = 500;
							
						 	$.each(toCheckArray , function( index, checkType ) {
								for (var i = 0; i < rowsCountArray[index]; i=i+1000) {
									 $.ajax({
									     type: "GET",
									     url: '{/literal}{$HOME}{literal}admin/do/tools/ajaxMigrateTableMySQL/'+checkType+'/'+i+'/',
									     dataType: 'html',
									     success: function(response) {
									     	if($.isNumeric(response)){
									     		
										     	window.allimportedrows = window.allimportedrows + parseInt(response);
								 				window.barWidth = window.barWidth+100*(response/{/literal}{$rowsCountPomSum}{literal});
								 				$(".bar").css('width',window.barWidth+'%');
												$("#addedRowsCounter").html(window.allimportedrows);
												
												if(window.allimportedrows>={/literal}{$rowsCountPomSum}{literal}){
													$(".progress").addClass("progress-success");
													$(".progress").removeClass("active");
													$("#runDBConfig").removeClass("hidden");
												}
									     	}else{
									     		$(".progress").addClass("progress-danger");
									     		$("#renewDbImport").removeClass("hidden");
									     		$("#renewDbImport").removeClass("active");
									     		$("#dbMigrationErrorInfo").append(response);
									     		return false;
									     	}
										 }	
							 		});
								}	
							});
					    });
					 	{/literal}
					</script>	
					<div class="pad">
						<center>
							<span id="addedRowsCounter"></span>/{$rowsCountPomSum}
							<div class="progress progress-striped active">
							  <div class="bar" style="width: 0%; height:60px;"></div>
							</div>
							<div id="dbMigrationErrorInfo"></div>
							<a href="{$HOME}admin/tools/database/migrationCheck/" class="btn btn-large btn-primary hidden" id="runDBConfig">{L key = "admin.common.conservation.tpl.checkbase"}</a>
							<a href="{$HOME}admin/tools/database/migrationSetupMySQLSuccess/" class="btn btn-large btn-primary hidden" id="renewDbImport">{L key = "admin.common.conservation.tpl.tryagain"}</a>
						</center>
					</div>					
				</div>	
			{elseif $tablesCheckResult!=''}
	   	 		<div class="align-center green box" style="padding-top:100px; padding-bottom:80px;">	
	   	 			<i class="fa fa-check fa-3x icon-green">&nbsp;</i>	
					<h2>{L key = "admin.common.conservation.tpl.completed"}</h2>
				</div>		
			{/if}

		</div>	
		<div class="span4">
			<div class="pad margin-bottom align-center {if $tablesCheckResult==''}silver{/if}">
				<i class="fa fa-hdd-o fa-3x icon-dark">&nbsp;</i>
   	 			<h2>{L key = "admin.common.conservation.tpl.stepthree"}</h2>
   	 			{L key = "admin.common.conservation.tpl.finalization"}
   	 		</div>	
   	 		{if $tablesCheckResult!=''}		
				<div class="box align-center" style="padding-top:125px; padding-bottom:123px;">
					<a href="{$HOME}admin/tools/database/migrationFinish/" class="btn btn-large">{L key = "admin.common.conservation.tpl.rundatabase"}</a>
				</div>		
			{/if}		
		</div>	
	</div>	
{else}
	{assign elementsCountOnPage 100}
	{assign startElement $REQUEST->getVariable('p')*$elementsCountOnPage}
	
	<div class="row-fluid">
	
	  <div class="{if isset($dbTableObject)}span2{else}span12{/if} box">
	  	<table class="table table-striped tablesort">
	  		<thead>
	  			<tr>
			 		<th>{L key="admin.tools.tpl.database.tables"}</th>
					{if !isset($dbTableObject)}
					<th>{L key="admin.tools.tpl.database.path"}</th>
					<th>{L key="admin.tools.tpl.database.columnnumber"}</th>	
					<th>{L key="admin.tools.tpl.database.recordnumber"}</th>								
					{/if}  		
				</tr>
	  		</thead>
			{foreach $dbList as $dbFile}
				{if method_exists($dbFile->name|rtrim:'.class.php', 'fetchAll')}
				<tr {if $dbFile->name|rtrim:'.class.php'==$REQUEST->getVariable('id')}class="active"{/if}>
					<td>
						<a href="{$HOME}admin/tools/database/showTable/{$dbFile->name|rtrim:'.class.php'}/"><i class="color-icons icons-databases icon-margin">&nbsp;</i>{$dbFile->name|rtrim:'.class.php'}</a><br>
					</td>
					{if !isset($dbTableObject)}
						<td>{$dbFile->path|replace:$SITE_PATH:''}</td>
						<td>
							{baseDB::getColumnsCount("{$dbFile->name|rtrim:'.class.php'}")}
						</td>
						<td>
							<span class="badge badge-inverse">{baseDB::getRecordsCount("{$dbFile->name|rtrim:'.class.php'}")}</span>
						</td>										
					{/if}
				</tr>
				{/if}
			{/foreach}
		</table>
	  </div>	
	  {if isset($dbTableObject)}
	  <div class="{if  $formTableRowEdit!=null}span6{else}span10{/if} box" style="overflow:scroll">	
	  		{include file='common/paginator.tpl' elementsCount=$dbTableObject->fetchCount() count=$elementsCountOnPage}
		  	{assign tableOneRow $dbTableObject->fetchRow()}	
		  	{if $tableOneRow!=null}
				{foreach $tableOneRow as $rowTitle => $rowTitleVal}
					{$truncateCount=$truncateCount+1}
				{/foreach} 	
				{assign truncateCount 220/$truncateCount}
				{assign truncateCount $truncateCount|ceil}
				<table class="table table-striped tablesort whitebg">
					<thead>
					<tr>
						{foreach $tableOneRow as $rowTitle => $rowTitleVal}
						<th>{$rowTitle|truncate:$truncateCount}</th>
						{/foreach}
					</tr>
					</thead>
				  <tbody>
					{foreach $dbTableObject->fetchAll(null,null,'*',"$startElement,$elementsCountOnPage") as $row}
						<tr {if $row->id==$REQUEST->getVariable('secoundId')}class="active"{/if} id="{$row->id}">
						{foreach $row as $columnName => $columnVal}
							{if $columnName == 'id'}
								<td><a href="{$HOME}admin/tools/database/editRow/{$REQUEST->getVariable('id')}/{$columnVal}/#{$columnVal}" class="badge badge-inverse">{$columnVal}</a></td>
							{else}
								<td>
									<span {if strlen($columnVal)>=1} data-toggle="tooltip" data-placement="left" data-original-title="{$columnVal|escape:'html'|truncate:200}" {/if}>{$columnVal|escape:'html'|truncate:$truncateCount}</span>
								</td>
							{/if}
						{/foreach}
						</tr>
					{/foreach}
				  </tbody>
				</table>	
				{include file='common/paginator.tpl' elementsCount=$dbTableObject->fetchCount() count=$elementsCountOnPage}
			{else}
				<div class="pad">{L key = "admin.lang.tpl.nodata"}</div>
			{/if}	
	  </div>
	  
	  {/if}
	  {if $formTableRowEdit!=null}
	  <div class="span4">
		<div class="box box-floating">
			<h5>Id {$REQUEST->getVariable('secoundId')}</h5>
			{$formTableRowEdit->toHtml()}
		</div>
	  </div>	
	  {/if}	
	</div>
{/if} 	