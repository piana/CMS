<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="robots" content="INDEX, FOLLOW">
        <meta name="GOOGLEBOT" content="INDEX, FOLLOW">
        <meta name="revisit-after" content="7 days">
        <meta name="description" content="{{$meta->description}}">
        <meta name="keywords" content="{{$meta->keywords}}">
        <meta name="copyright" content="Copyright (c) WinduCMS">
        <meta name="distribution" content="global">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:700,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>      
		{{foreach resourceManager::loadFrontCSS() as $cssFile}}
			<link rel='stylesheet' type='text/css' href='{{$cssFile}}'>
		{{/foreach}}	
		{{foreach resourceManager::loadFrontLESS() as $lessFile}}
			<link rel='stylesheet/less' type='text/css' href='{{$lessFile}}'>
		{{/foreach}}
		<script type="text/javascript">
			window.HOME = "{{$HOME}}";
			window.TEMPLATE = "{{config::get(template)}}";
		</script>	
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		{{foreach resourceManager::loadFrontJS() as $jsFile}}
			<script type="text/javascript" src="{{$jsFile}}"></script>
		{{/foreach}}
		<title>{{$meta->title}}</title>
	</head>
<body>
	{{include file=$pageTpl}}
</body> 
</html>