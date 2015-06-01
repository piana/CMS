<div class="tab-menu-top">
	<a href="{$HOME}admin/tools/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
</div>	
{if cache::isCached("addonsServerHelp{$ekey}",2592000)}
	{assign helpContent cache::read("addonsServerHelp{$ekey}")}
{else}
	{$helpContent = baseFile::getExternalFileContent("{$smarty.const.ADDONS_SERVER_DATA}getHelpContent/{$ekey}/")}
	{cache::write("addonsServerHelp{$ekey}",$helpContent)}
{/if}
<div class="row-fluid">
	<div class="span7">
		<div class="box">
			<h5><i class="fa fa-user icon-margin icon-grey"></i> {L key = "admin.help.tpl.guide"}</h5>
			<div class="pad-big">
     			{$helpContent}
     		</div>
      	</div>
	</div>
	<div class="span5">
		<div class="box-floating box">
			<h5><i class="fa fa-user icon-margin icon-grey"></i> {L key = "admin.help.tpl.video"}</h5>
		</div>
	</div>
</div>	
