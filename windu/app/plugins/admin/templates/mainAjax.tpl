<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style type="text/css">
		{foreach resourceManager::loadAdminCSS() as $cssFile}
			@import url("{$cssFile}");	
		{/foreach}				        
			@import url("{$HOME}app/plugins/admin/resources/css/ajax.css");    
		</style>
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		
		<script type="text/javascript">
			window.HOME = "{$HOME}";
			window.SUBDIR = "{$smarty.const.SUBDIR}";
			window.TEMPLATE = "{config::get(template)}";
			window.MAX_UPLOAD_FILE_SIZE = "{$smarty.const.MAX_UPLOAD_FILE_SIZE}";
		</script>
		
		{foreach resourceManager::loadAdminJS() as $jsFile}
			<script type="text/javascript" src="{$jsFile}"></script>
		{/foreach}		

		<title>Windu - Admin</title>
	</head>
<body>
    {nocache}
	    {include file=$page_content}
    {/nocache}
</body> 
</html>