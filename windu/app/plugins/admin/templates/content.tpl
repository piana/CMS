  	<div class="tabbable">
	  <div class="tab-content">
	    {if $subpage=='help'}
	    	{include file='common/help.tpl' ekey=lang::read('admin.help.content')} 
	    {elseif $subpage=='pages'}		  
     		{include file='common/pages.tpl'}
	    {elseif $subpage=='lang'}
		    {if !usersDB::isNoob()}
		    	{include file='common/lang.tpl'}
		    {/if}
	    {elseif $subpage=='trash'}
			{include file='common/trash.tpl'}
	    {elseif $subpage=='files'}
			<div class="row-fluid">
				{include file='common/files.tpl'}
			</div> 	      		
	    {elseif $subpage=='images'}
			<div class="row-fluid">
				{include file='common/images.tpl'}
			</div> 	      		
	    {elseif $subpage=='banners'}
	    	{if license::hasPro('')}
	    		{include file='common/plus/banners.tpl'}
	    	{else}
	    		{include file='common/goPro.tpl'} 
	    	{/if}
	    {elseif $subpage=='polls'}
	    	{if license::hasPro('')}
	    		{include file='common/plus/polls.tpl'}
	    	{else}
	    		{include file='common/goPro.tpl'} 
	    	{/if}
	    {elseif $subpage=='calendar'}
	    	{if license::hasPro('')}
	    		{include file='common/plus/calendar.tpl'}
	    	{else}
	    		{include file='common/goPro.tpl'} 
	    	{/if}
	    {elseif $subpage=='autosave'}
    		{include file='common/autosave.tpl'}
 	    {elseif $subpage=='config'}
			{include file='common/config.tpl' class='content'}		
	    {/if}	    	            	        	    
	  </div>
	</div>