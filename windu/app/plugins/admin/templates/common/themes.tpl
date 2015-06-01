<div class="tab-menu-top">
	<a href="{$HOME}admin/themes/themes/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
	<h3 class="pull-left tab-title"> {L key = "admin.themes.tpl.graphictemplates"}</h3>
</div>
<div class="row-fluid">
	<div class="span4 box">
		<h5><i class="fa fa-picture-o icon-margin icon-grey"></i> {L key = "admin.themes.common.tpl.graphicstyles"}</h5>
		{include file='common/widgets_modal.tpl'}
		{include file='common/themes_list.tpl'}
	</div>
	<div class="span8">
		{if $hideFileForm!=1}
            <ul class="nav nav-tabs nav-tabs-top" id="tabModerator" style="margin-top:0px!important;">
                <li class="active">
                    <a href="#tabModerator1"><i class="color-icons icons-clipboard-list icon-margin"></i>{L key="creator.tpl.webst"}</a>
                </li>
                <li class="">
                    <a href="#tabModerator2"><i class="color-icons icons-calendar-list icon-margin"></i>{L key="creator.tpl.blog"}</a>
                </li>
                <li class="">
                    <a href="#tabModerator3"><i class="color-icons icons-chart-up icon-margin"></i>{L key="creator.tpl.portal"}</a>
                </li>
                <li class="">
                    <a href="#tabModerator4"><i class="color-icons icons-balloon-white-left icon-margin"></i>{L key="creator.tpl.forum"}</a>
                </li> 
                <li class="">
                    <a href="#tabModerator5"><i class="color-icons icons-newspaper icon-margin"> </i>{L key = "admin.themes.controller.addtemp"}</a>
                </li>                               
            </ul>		    
            <div class="tab-content tab-moderator box no-padding">
                <div class="tab-pane active" id="tabModerator1">
                    {foreach themesDB::getThemesFromAddonsServer('web') as $theme}
                        {if !themesDB::themeExists($theme.name)}
                        <div class="addonsBox">
                            <a href="{$HOME}admin/do/themes/addThemeFromAddonsServer/{$theme.fileEkey}/{$theme.name}/"> {if $theme.imageUrl!='0' or $theme.imageUrl!=''} <img src="{$theme.imageUrl}"> {else} <img src="{$smarty.const.ADDONS_SERVER}image/{$theme.imageEkey}/150/150/smart/original/90/"> {/if} 
                                <div class="buttons">
                                    <span class="badge badge-inverse">{str_replace(array('_','-'),array(' ',' '),$theme.name)}</span>
                                </div>
                            </a>
                        </div>
                        {/if}
                    {/foreach}            
                </div>
                <div class="tab-pane" id="tabModerator2">
                    {foreach themesDB::getThemesFromAddonsServer('blog') as $theme}
                        {if !themesDB::themeExists($theme.name)}
                        <div class="addonsBox">
                            <a href="{$HOME}admin/do/themes/addThemeFromAddonsServer/{$theme.fileEkey}/{$theme.name}/"> {if $theme.imageUrl!='0' or $theme.imageUrl!=''} <img src="{$theme.imageUrl}"> {else} <img src="{$smarty.const.ADDONS_SERVER}image/{$theme.imageEkey}/150/150/smart/original/90/"> {/if} 
                                <div class="buttons">
                                    <span class="badge badge-inverse">{str_replace(array('_','-'),array(' ',' '),$theme.name)}</span>
                                </div>
                            </a>
                        </div>
                        {/if}
                    {/foreach}               
                </div>
                <div class="tab-pane" id="tabModerator3">
                    {foreach themesDB::getThemesFromAddonsServer('portal') as $theme}
                        {if !themesDB::themeExists($theme.name)}
                        <div class="addonsBox">
                            <a href="{$HOME}admin/do/themes/addThemeFromAddonsServer/{$theme.fileEkey}/{$theme.name}/"> {if $theme.imageUrl!='0' or $theme.imageUrl!=''} <img src="{$theme.imageUrl}"> {else} <img src="{$smarty.const.ADDONS_SERVER}image/{$theme.imageEkey}/150/150/smart/original/90/"> {/if} 
                                <div class="buttons">
                                    <span class="badge badge-inverse">{str_replace(array('_','-'),array(' ',' '),$theme.name)}</span>
                                </div>
                            </a>
                        </div>
                        {/if}
                    {/foreach}              
                </div>
                <div class="tab-pane" id="tabModerator4">
                    {foreach themesDB::getThemesFromAddonsServer('forum') as $theme}
                        {if !themesDB::themeExists($theme.name)}
                        <div class="addonsBox">
                            <a href="{$HOME}admin/do/themes/addThemeFromAddonsServer/{$theme.fileEkey}/{$theme.name}/"> {if $theme.imageUrl!='0' or $theme.imageUrl!=''} <img src="{$theme.imageUrl}"> {else} <img src="{$smarty.const.ADDONS_SERVER}image/{$theme.imageEkey}/150/150/smart/original/90/"> {/if} 
                                <div class="buttons">
                                    <span class="badge badge-inverse">{str_replace(array('_','-'),array(' ',' '),$theme.name)}</span>
                                </div>
                            </a>
                        </div>
                        {/if}
                    {/foreach}              
                </div>    
                <div class="tab-pane" id="tabModerator5">
                    <div class="margin-top">
                        <h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> {L key = "admin.themes.controller.addtemp"}</h5>
                        {$formTheme->toHtml()}
                    </div>
                    <div class="margin-top">
                        <h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> {L key = "admin.themes.controller.addtemplatezip"}</h5>
                        {$formThemeFile->toHtml()}
                    </div>            
                </div>                                           
            </div>		    

		{else}
		<div class="box box-floating">
			<h5><i class="fa fa-pencil icon-margin icon-grey"></i> {L key = "admin.content.tpl.edit"}</h5>
			{$formTheme->toHtml()}
		</div>
		{/if}
	</div>
</div>
