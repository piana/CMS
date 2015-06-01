<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		{$resourceVersion = intval(config::get('resourcesVersion'))}
		<link rel="stylesheet" href="{$HOME}app/resources/bootstrap/css/bootstrap.min.css?ver={$resourceVersion}">
		<link rel="stylesheet" href="{$HOME}app/plugins/admin/resources/css/bootstrap-extends.css?ver={$resourceVersion}">
		<link rel="stylesheet" href="{$HOME}app/resources/css/font-awesome.min.css?ver={$resourceVersion}">
		<link rel="stylesheet" href="{$HOME}app/plugins/admin/resources/css/login.css?ver={$resourceVersion}">

		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script type="text/javascript" src="{$HOME}app/resources/js/jquery.js?ver={$resourceVersion}"></script>
		<script type="text/javascript" src="{$HOME}app/resources/js/jquery.validate.js?ver={$resourceVersion}"></script>
		<script type="text/javascript" src="{$HOME}app/resources/bootstrap/js/bootstrap.min.js?ver={$resourceVersion}"></script>
		
		<title>Windu - Admin</title>
	</head>
<body>
    <noscript>Your browser does not support JavaScript!</noscript>
    {nocache}
        {include file=$page}
    {/nocache}
</body> 
</html>