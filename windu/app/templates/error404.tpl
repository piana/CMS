{header('HTTP/1.x 404 Not Found')}
{header("Status: 404 Not Found")}
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel='stylesheet' href='{$HOME}app/resources/css/reset.css'>
		<link rel='stylesheet' href='{$HOME}app/resources/css/404.css'>
		<title>Error 404</title>
	</head>
<body>
	<div class="errorMessage">
		<img src="{$HOME}app/resources/img/icon404.png"><br>
		Windu <strong>Error 404</strong>
		<p class="small">Page not exists! <a href="{$HOME}">Home page</a></p>
	</div>
</body> 
</html>