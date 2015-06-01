<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div class="tabbable">
	<div class="tab-content">
		{if $subpage=='help'}
	    	{include file='common/help.tpl' ekey=lang::read('admin.help.tools')} 
	    {elseif $subpage=='tools'}		  
	    		{include file='common/tools.tpl'} 
		{elseif $subpage=='mailing'}	
	    	{if license::hasPro('pro')}
	    		{include file='common/pro/mailing.tpl'} 
	    	{else}
	    		{include file='common/goPro.tpl'} 
	    	{/if}
		{elseif $subpage=='contacts'}	
{include file='common/contacts.tpl'}	     	
		{elseif $subpage=='seo'}	
	    	{if license::hasPro()}
	    		{include file='common/plus/seo.tpl'}
	    	{else}
	    		{include file='common/goPro.tpl'} 
	    	{/if}
		{elseif $subpage=='monitoring'}	
	    	{if license::hasPro('')}
	    		{include file='common/plus/monitoring.tpl'}
	    	{else}
	    		{include file='common/goPro.tpl'} 
	    	{/if}
	    {elseif $subpage=='rss'}	
	    	{if license::hasPro('')}
	    		{include file='common/plus/rss.tpl'}
	    	{else}
	    		{include file='common/goPro.tpl'} 
	    	{/if}
	    {elseif $subpage=='database'}	
	    	{if license::hasPro('pro')}
	    		{include file='common/pro/database.tpl'}
	    	{else}
	    		{include file='common/goPro.tpl'} 
	    	{/if}
		{elseif $subpage=='config'}	
			{include file='common/config.tpl' class='tools'}
		{/if}           	        	        	 
	</div>
</div>