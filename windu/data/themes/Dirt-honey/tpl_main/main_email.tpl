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
		<style type="text/css">
			@import url("{{$HOME}}data/themes/{{config::get(template)}}/bootstrap/css/bootstrap.min.css");
			{{foreach themesDB::getAllResources('css') as $CSS}}
			@import url("{{$CSS}}");
			{{/foreach}}			
		</style>
		<script type="text/javascript">
			window.HOME = "{{$HOME}}";
			window.TEMPLATE = "{{config::get(template)}}";
		</script>	
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script type="text/javascript" src="{{$HOME}}app/resources/js/jquery.js"></script>
		<script type="text/javascript" src="{{$HOME}}data/themes/{{config::get(template)}}/bootstrap/js/bootstrap.min.js"></script>  
		<script type="text/javascript" src="{{$HOME}}app/plugins/front/resources/js/front.js"></script>
		{{foreach themesDB::getAllResources('js') as $JS}}
		<script type="text/javascript" src="{{$JS}}"></script>
		{{/foreach}}
		<title>{{$meta->title}}</title>
	</head>
<body>
	{{include file=$pageTpl}}
</body> 
</html>