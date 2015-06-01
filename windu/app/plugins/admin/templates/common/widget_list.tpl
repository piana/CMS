{function name=widgettreelist} 
 	{foreach $data->subdir as $tpl}
 		{if is_dir($tpl->path)}
	 		<tr {if "{$tpl->name}" == "{$REQUEST->getVariable('tpl')}"}class="active widget-{$theme->name}"{else}class="widget-{$theme->name}"{/if}>
	 			{assign hiddenKey "widget_{$tpl->name}"}
			    <td style="padding-left:{$padding}px;"><i class="color-icons icons-folder-horizontal-open icon-margin"> </i>
				<a href="#" onclick="toggleHidden('{$hiddenKey}')">{$tpl->name}</a>
				</td>
			    <td>
				    <div class="buttons">
				      	<a href="{$HOME}admin/themes/widgets/addWidget/{$theme->name}/{$tpl->name}/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
				    </div>
			    </td>
			    {assign padding $padding+25}
			    {assign subdir $tpl->name}
			    
				{if cookie::readCookie($hiddenKey)==1}{assign hidden 0}{else}{assign hidden 1}{/if}
			    {widgettreelist hidden=$hidden data=$tpl hiddenKey=$hiddenKey dirname=$tpl->name}
				{$hiddenKey = ''}
				
			    {assign subdir ''}
			    {assign padding 30}
			    {$hidden=false}
		    </tr>
	    {/if}
	{/foreach} 
	
 	{foreach $data->subdir as $tpl}
 		{if !is_dir($tpl->path)}
		 	<tr class="widget-{$theme->name} {if $hidden==true}hidden {/if}{$hiddenKey}{if "{$tpl->name}" == "{$REQUEST->getVariable('tpl')}"} active{/if}" id="widgetfile-{md5("{$theme->name}{$subdir}{$tpl->name}")}">
			    <td style="padding-left:{$padding}px;"><i class="color-icons icons-document-code icon-margin"> </i>{$tpl->name}</td>
			    <td>
				    <div class="buttons">
				      	<a href="{$HOME}admin/themes/widgets/editWidget/{$theme->name}/{if $subdir!=''}{$subdir}/{/if}{$tpl->name}/#widget-{$theme->name}"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
				    	{if in_array($subdir,widgetsDB::$baseWidgetFolders) and usersDB::isDeveloper()}
							<span onclick="loadDoActionDelete('{$HOME}admin/do/themes/deleteWidgetFile/{$theme->name}/{$subdir}/{$tpl->name}/','#widgetfile-{md5("{$theme->name}{$subdir}{$tpl->name}")}',0)"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
				   		{/if}
				    </div>
			    </td>
		    </tr>
	    {/if}
	{/foreach} 	
{/function}

<table class="table">
  <tbody>
  	{if $active==0}
		{assign widgets $widgetsOff}
		{assign action 'activateWidget'}
	{else}
		{assign action 'deactivateWidget'}
	{/if}
	{foreach $widgets as $theme}
    <tr id="widget-{$theme->name}">
      <td>
      	<a href="{$HOME}admin/themes/widgets/show/{$theme->name}/#widget-{$theme->name}"{if $widgetsToUpdate[$theme->name]!=''}class="silver"{/if}>
			{include file='common/widget_icons.tpl' themename=$theme->name}     	
			{$theme->name}
		</a>
      </td>
      <td>
	    <div class="buttons {if usersDB::isDeveloper()} buttons-six {else} buttons-four {/if}">
	    	{if $widgetsToUpdate[$theme->name]}
                <a href="{$HOME}admin/do/themes/updateWidget/{$widgetsToUpdate[$theme->name]['fileEkey']}/{$theme->name}/">
                    {if adminThemesDoController::wasWidgetEdited($theme->name)}
                        <i class="fa fa-arrow-circle-up icon-dark"></i>
                    {else}
                        <i class="fa fa-arrow-circle-up icon-orange"></i>
                    {/if}
                </a>
            {/if}
	    	<a href="{$HOME}admin/themes/widgets/editWidgetName/{$theme->name}/#widget-{$theme->name}"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
	    	<a href="{$HOME}admin/do/themes/duplicateWidget/{$theme->name}/"><i class="fa fa-random icon-green">&nbsp;</i></a>
	    	<a href="{$HOME}admin/do/themes/downloadWidget/{$theme->name}/"><i class="fa fa-download icon-green">&nbsp;</i></a>
	    	{if usersDB::isDeveloper()}
	    		<a href="{$HOME}admin/do/themes/{$action}/{$theme->name}/"><i class="fa fa-eye {if $active==0}icon-red{else}icon-blue{/if}">&nbsp;</i></a>
	      		<span onclick="loadDoActionDelete('{$HOME}admin/do/themes/delete_widget/{$theme->name}/','#widget-{$theme->name}',0)"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
			{/if}
	    </div>
      </td>
    </tr>
		{if $REQUEST->getVariable('theme')==$theme->name}
			{assign padding 30}
  			{widgettreelist data=$theme}
		{/if}
	{/foreach}
	{if count($widgets)==0}<tr><td>{L key="admin.themes.tpl.noelements"}</td></tr>{/if}	  	
  </tbody>
</table>



