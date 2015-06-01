<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div class="tabbable">
  <div class="tab-content">
	{if $subpage=='help'}
    	{include file='common/help.tpl' ekey=lang::read('admin.help.system')} 
    {elseif $subpage=='system'}		  
    	{include file='common/conservation.tpl'} 
    {elseif $subpage=='stats'}	
    	{include file='common/statistics.tpl'}
    {elseif $subpage=='backup'}	
    	{if license::hasPro()}
			{include file='common/plus/backup.tpl'}  
    	{else}
    		{include file='common/goPro.tpl'} 
    	{/if}
    {elseif $subpage=='licence'}	
	   {include file='common/license.tpl'}
    {elseif $subpage=='notifications'}	
    	<div class="row-fluid">
    		{include file='common/notify.tpl'}
	 	</div>	  
    {elseif $subpage=='log'}	
    	{if license::hasPro()}
    		{include file='common/plus/log.tpl'}
    	{else}
    		{include file='common/goPro.tpl'} 
    	{/if}	
    {elseif $subpage=='cron'}	
    	{if license::hasPro('pro')}
    		{include file='common/pro/cron.tpl'}
    	{else}
    		{include file='common/goPro.tpl'} 
    	{/if}	    
    {elseif $subpage=='firewall'}	
	   	{if license::hasPro('pro')}
	   		{include file='common/pro/firewall.tpl'}
	   	{else}
	   		{include file='common/goPro.tpl'} 
	   	{/if}
	{elseif $subpage=='requestlog'}	
	   	{if license::hasPro('pro')}
	   		{include file='common/pro/requestlog.tpl'}
	   	{else}
	   		{include file='common/goPro.tpl'} 
	   	{/if}
    {elseif $subpage=='config'}	
			{include file='common/config.tpl' class='system'}	  	
	{/if}	                      
  </div>
</div>