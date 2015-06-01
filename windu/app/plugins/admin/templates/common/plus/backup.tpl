<div class="tab-menu-top">
	<a href="{$HOME}admin/system/backup/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	 <h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.backup"}</h3>
	<a href="{$HOME}admin/do/backup/backup/" class="btn btn-primary btn-small">{L key = "admin.system.tpl.backupcopy"}</a>
	<span class="line-vertical"></span>
	{if config::get("month_backup")}
		<a href="{$HOME}admin/do/tools/toggleCronConfig/month_backup/" class="btn btn-success btn-small"><i class="fa fa-power-off "></i>{L key = "admin.system.common.tpl.monthlybackupcop"}</a>
	{else}
		<a href="{$HOME}admin/do/tools/toggleCronConfig/month_backup/" class="btn btn-danger btn-small"><i class="fa fa-power-off "></i>{L key = "admin.system.common.tpl.monthlybackupcop"}</a>
	{/if}	
</div>	

{if !empty($backups)}
<div class="row-fluid">
  <div class="span2">
	<div class="box margin-bottom align-center" style="padding-top:15px;">
      	<div class="pad">
      	{if !check::backup(true)}
      		<i class="fa fa-exclamation-triangle fa-4x icon-yellow"></i>
    		<h4>{L key = "admin.common.backup.tpl.warning"}</h4>
    		{L key = "admin.common.backup.tpl.recomendedcopy"}<br><br>
    	{else}
    		<i class="fa fa-check fa-4x icon-green"></i>
    		<h4>{L key = "admin.common.backup.tpl.allok"}</h4>
    		{L key = "admin.common.backup.tpl.copyexists"}<br><br>
    	{/if}
    	</div>
    </div> 
  </div>
  <div class="span10 box">
	<h5><i class="fa fa-download icon-margin icon-grey"></i> {L key = "admin.system.common.tpl.backuplist"}</h5>
	{include file='common/backup_list.tpl'}
  </div>
</div>    
{else}
<div class="box-center">
  <i class="fa fa-exclamation-triangle fa-5x icon-yellow"></i>
			<h4>{L key = "admin.common.backup.tpl.warning"}</h4>
			{L key = "admin.common.backup.tpl.createbackupcopy"}<br><br>
  	<a href="{$HOME}admin/do/backup/backup/" class="btn btn-primary btn-large">{L key = "admin.system.tpl.backupcopy"}</a>
</div>
{/if}  
 
	