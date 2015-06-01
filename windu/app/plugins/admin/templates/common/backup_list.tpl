<table class="table table-striped">
  <tbody>
	{foreach $backups as $backup}
    <tr>
      <td>
      	<i class="color-icons icons-databases icon-margin"> </i>
		{$backup->name}
      </td>
      <td>
		{if !cache::isCached($backup->path)}
			{cache::write($backup->path,round(baseFile::getSize($backup->path)/1048576,2),'dirSize')}
		{/if}
		{if !cache::isCached("{$backup->path}.zip")}
			{cache::write("{$backup->path}.zip",round(baseFile::getSize("{$backup->path}.zip")/1048576,2),'dirSize')}
		{/if}	
		<span class="badge">
		{cache::read($backup->path)+cache::read("{$backup->path}.zip")} MB
		</span>
      </td>      
      <td>
	    <div class="buttons {if usersDB::isDeveloper()} buttons-three{/if}">
	    	{if file_exists("{$SITE_PATH}/data/backups/{$backup->name}.zip")}<a href="{$HOME}data/backups/{$backup->name}.zip"><i class="fa fa-download icon-green">&nbsp;</i></a>
			{else}<a href="{$HOME}admin/do/backup/compress/{$backup->name}/"><i class="fa fa-compress icon-green">&nbsp;</i></a>{/if}
			
	   		{if usersDB::isDeveloper()}<a href="{$HOME}admin/do/backup/restore/{$backup->name}/"><i class="fa fa-upload icon-blue">&nbsp;</i></a>{/if}
	      	{if usersDB::isDeveloper()}<a href="{$HOME}admin/do/backup/delete/{$backup->name}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>{/if}
	    </div>
      </td>
    </tr>

	{/foreach}	  	
  </tbody>
</table>



