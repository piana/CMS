<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style type="text/css">
				@import url("{$HOME}app/resources/bootstrap/bootstrap.css");
	            @import url("{$HOME}app/resources/css/jquery-ui/jquery-ui.css");
				{foreach $REQUEST->getCSS() as $css}
					@import url("{$HOME}{$css}");
				{/foreach}	            
		</style>
		<script type="text/javascript" src="{$HOME}app/resources/js/jquery.js"></script>
		<script type="text/javascript" src="{$HOME}app/resources/js/jquery-ui.js"></script>
		<script type="text/javascript" src="{$HOME}app/resources/js/main.js"></script>
		<script type="text/javascript" src="{$HOME}app/resources/bootstrap/js/bootstrap-dropdown.js"></script>
		{foreach $REQUEST->getJS() as $js}
			<script type="text/javascript" src="{$HOME}{$js}"></script>
		{/foreach}
		<title>Windu CMS</title>
	</head>
<body>
  <div class="container">
      {include file='page_menu.tpl'}
      {include file=$page_content}
  </div>
</body> 
</html>