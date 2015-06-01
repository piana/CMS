	{if preg_match('/menuu*/', $themename)}
    	<i class="color-icons icons-property icon-margin"> </i>
    {elseif preg_match('/sliderr*/', $themename)}	
    	<i class="color-icons icons-projection-screen icon-margin"> </i>	
    {elseif preg_match('/search*/', $themename)}	
    	<i class="color-icons icons-magnifier-medium icon-margin"> </i>	
    {elseif preg_match('/user*/', $themename)}	
    	<i class="color-icons icons-user-gray icon-margin"> </i>	
    {elseif preg_match('/tags*/', $themename)}	
    	<i class="color-icons icons-price-tag icon-margin"> </i>	
    {elseif preg_match('/content*/', $themename)}	
    	<i class="color-icons icons-clipboard-text icon-margin"> </i>			    			    			    			    	
    {else}
    	<i class="color-icons icons-rocket icon-margin"> </i>	
	{/if}      	
