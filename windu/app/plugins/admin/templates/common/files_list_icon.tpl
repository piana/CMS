{if preg_match('/.css/', $name) or  preg_match('/.less/', $name)}	
    {assign value="icons-document-list" var="icon"}			    	
{elseif preg_match('/.js/', $name)}
    {assign value="icons-document-node" var="icon"}
{elseif preg_match('/.tpl/', $name)}
    {assign value="icons-cheque" var="icon"}  
{elseif preg_match('/.txt/', $name)}
    {assign value="icons-document-word" var="icon"}   
{elseif preg_match('/.zip/', $name)}
    {assign value="icons-document-zipper" var="icon"}  
{elseif preg_match('/.jpg/', $name)}
    {assign value="icons-document-text-image" var="icon"}      
{elseif preg_match('/.png/', $name)}
    {assign value="icons-document-text-image" var="icon"}       
{elseif preg_match('/.php/', $name)}
    {assign value="icons-document-code" var="icon"}         
{else}
   {assign value="icon" var="icon"}	
{/if} 			   
<i class="color-icons {$icon} icon-margin"> </i> 