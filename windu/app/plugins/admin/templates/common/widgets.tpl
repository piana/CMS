<div class="tab-menu-top">
	<a href="{$HOME}admin/themes/widgets/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
	<h3 class="pull-left tab-title"> {L key = "admin.themes.tpl.widgets"}</h3>
	{if is_array($widgetsToUpdate)}<a href="{$HOME}admin/do/themes/updateAllWidgets/" class="btn btn-warning">{L key = "admin.themes.common.tpl.updateall"}</a>{/if}
</div>
{if count($widgetsToUpdate)>0}
<div class="alert alert-warning">
	{L key = "admin.themes.common.tpl.newupdate"}
</div>
{/if}
<div class="row-fluid">
	<div class="span5 box">
		<h5><i class="fa fa-map-marker icon-margin icon-grey"></i> {L key = "admin.themes.common.tpl.widgets"}
		<div class="buttons">
		    <a href="{$HOME}admin/do/themes/updateAllWidgets/" class="btn btn-small btn-warning">{L key = "admin.themes.common.tpl.updateall"}</a>
			<a href="{$HOME}admin/themes/widgets/" class="btn btn-small btn-primary">{L key = "admin.themes.controller.add"}</a>
		</div></h5>
		{include file='common/widget_list.tpl' active=1}
		<h5>{L key = "admin.themes.common.tpl.widgets.deactivated"}</h5>
		{include file='common/widget_list.tpl' active=0}
	</div>
	<div class="span7">
		{if $hideWidgetFileForm!=1}
    		<div class="box" style="overflow:hidden;">
    			<h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> {L key = "admin.themes.common.tpl.widgetsnotinst"}</h5>
    			<table class="table table-striped tablesort">
                    <tbody>
    				{foreach $widgetsFromAddonsServer as $widget}
        				{if !widgetsDB::widgetExists($widget.name)}
                            <tr>
                                <td>{include file='common/widget_icons.tpl' themename=$widget.name} {$widget.name}</td>
                                <td>{$widget.description}</td>
                                <td><span class="badge">{$widget.downloads}</span></td>
                                <td>
                                    <div class="buttons">
                                        <a href="{$HOME}admin/do/themes/addWidgetFromAddonsServer/{$widget.fileEkey}/{$widget.name}/"><i class="fa fa-download icon-blue">&nbsp;</i></a>
                                    </div>
                                </td>
                            </tr>
        				{/if}
    				{/foreach}
    				</tbody>
    			</table>
    		</div>
       		<div class="box margin-top">
    			<h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> {L key = "admin.themes.controller.addclean"}</h5>
    			{$formWidget->toHtml()}
    		</div>
    		<div class="box margin-top">
    			<h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> {L key = "admin.themes.controller.addfromzip"}</h5>
    			{$formWidgetFile->toHtml()}
    		</div>
		{else}
		<div class="box box-floating">
			<h5><i class="fa fa-pencil icon-margin icon-grey"></i> {L key = "admin.content.tpl.edit"}</h5>
			{$formWidget->toHtml()}
		</div>
		{/if}
	</div>
</div>