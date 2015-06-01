{function name=treelist} 
 	{foreach $data->subdir as $tpl}
		 	{if is_dir($tpl->path)}
		 	<tr {if "{$tpl->name}" == "{$REQUEST->getVariable('tpl')}"}class="active theme-{$theme->name}"{else}class="theme-{$theme->name}"{/if}>
		 		{assign separatorMain $separator}
		 		{assign separator "{$separator}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"}	
		 		{assign hiddenKey "themes_{$tpl->name}"}
			    <td>{$separator}
			    	<a href="#" onclick="toggleHidden('{$hiddenKey}')">
					    {if preg_match('/tpl_views*/', $tpl->name)}	
					    	<i class="color-icons icons-folder-horizontal icon-margin"> </i>				    	
						{elseif preg_match('/tpl_*/', $tpl->name)}
					    	<i class="color-icons icons-folder-horizontal icon-margin"> </i>
					    {elseif preg_match('/tpl_views*/', $tpl->name)}	
					    	<i class="color-icons icons-applications-blue icon-margin"> </i>						    	
					    {elseif preg_match('/img*/', $tpl->name)}	
					    	<i class="color-icons icons-blue-folder-horizontal icon-margin"> </i>	
					    {elseif preg_match('/css*/', $tpl->name) or preg_match('/less*/', $tpl->name)}	
					    	<i class="color-icons icons-blue-folder-horizontal icon-margin"> </i>		
					    {elseif preg_match('/js*/', $tpl->name)}	
					    	<i class="color-icons icons-blue-folder-horizontal icon-margin"> </i>						    					    	
					    {else}
					    	<i class="color-icons icons-folder-horizontal icon-margin"> </i>	
						{/if}  			   			
						{str_replace(array('_','-'),array(' ',' '),$tpl->name)|ltrim:'tpl_'}
					</a>
				</td>
			    <td>
				    <div class="buttons">
				      	<a href="{$HOME}admin/themes/themes/add/{$theme->name}/{$tpl->name}/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;
				    </div>
			    </td>
			    {if cookie::readCookie($hiddenKey)==1}{assign hidden 0}{else}{assign hidden 1}{/if}
	 			{treelist data=$tpl hidden=$hidden hiddenKey=$hiddenKey dirname=$tpl->name}
	 			{assign separator "{$separatorMain}"}
	 		</tr>
		 	{else}
		 	<tr class="{if $hidden==true}hidden {/if}{$hiddenKey}{if "{$tpl->name}" == "{$REQUEST->getVariable('tpl')}"} active{/if} theme-{$theme->name}" id="themefile-{md5("{$theme->name}{$data->name}{$tpl->name}")}">
			    <td><span{if $data->name=='img'} data-toggle="tooltip" data-placement="right" data-original-title="<img src='{$HOME}data/themes/{$theme->name}/{$data->name}/{$tpl->name}'>"{/if}>{$separator}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{include file='common/files_list_icon.tpl' name=$tpl->name}{$tpl->name|truncate:20:"...":true}</span></td>
			    <td>
				    <div class="buttons">
				      	{if $data->name!='img'}
                            <a href="{$HOME}admin/themes/themes/edit/{$theme->name}/{$dirname}/{$data->name}/{$tpl->name}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
						{else}
						<span>
							<i onclick="togglepopover('{md5($tpl->name)}');" style="cursor:pointer; " style="cursor:normal; " id="popover-id-{md5($tpl->name)}" class="fa fa-info-circle icon-grey cl-{md5($tpl->name)}" rel="popovercontentlist" data-content="{literal}{{$TEMPLATE_HOME}}/img/{/literal}{$tpl->name}">&nbsp;</i>
						</span>
						{/if}
				      	{if usersDB::isDeveloper()}
				      		<span onclick="loadDoActionDelete('{$HOME}admin/do/themes/delete/{$theme->name}/{$data->name}/{$tpl->name}/','#themefile-{md5("{$theme->name}{$data->name}{$tpl->name}")}',0)"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
						{/if}
				    </div>
			    </td>
			 </tr>
			{/if}
	{/foreach} 
{/function}

<table class="table">
  <tbody>
	{foreach $themes as $theme}
    <tr {if "{$theme->name}" == "{$REQUEST->getVariable('theme')}" and $REQUEST->getVariable('tpl')==null}class="active"{/if} id="theme-{$theme->name}">
      <td>
      	<a href="{$HOME}admin/themes/themes/show/{$theme->name}/">
      		<i class="color-icons icons-newspaper icon-margin"> </i>
			{str_replace(array('_','-'),array(' ',' '),$theme->name)}
		</a>
      </td>
      <td>
	    <div class="buttons buttons-five">
	    	<a href="{$HOME}admin/themes/themes/editTheme/{$theme->name}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
	    	<a href="{$HOME}admin/do/themes/duplicateTemplate/{$theme->name}/"><i class="fa fa-random icon-green">&nbsp;</i></a>
	    	<a href="{$HOME}admin/do/themes/downloadTemplate/{$theme->name}/"><i class="fa fa-download icon-green">&nbsp;</i></a>
			{if $theme->name == config::get(template)}
				<span><i class="fa fa-eye icon-blue">&nbsp;</i></span>
			{else}
				<a href="{$HOME}admin/do/themes/setTempleteActive/{$theme->name}/"><i class="fa fa-eye-slash icon-grey">&nbsp;</i></a>
			{/if}	    
	      	{if usersDB::isDeveloper() and $theme->name != config::get(template)}
	      		<span onclick="loadDoActionDelete('{$HOME}admin/do/themes/delete_template/{$theme->name}/','#theme-{$theme->name}',0)"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
			{else}
				<span><i class="fa fa-times-circle icon-grey">&nbsp;</i></span>
			{/if}
	    </div>
      </td>
    </tr>
		{if $REQUEST->getVariable('theme')==$theme->name}
  			{treelist data=$theme}
		{/if}
	{/foreach}	  	
  </tbody>
</table>


