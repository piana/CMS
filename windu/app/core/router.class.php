<?php /*windu.org core*/
class router {
	
	private static $routingTable = array();
	private static $instance;
	
	public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new router();
        }
        return self::$instance;
    }
        
	public function __construct() {
		$file = CACHE_PATH."system/routingtable.tmp";
		
		if (file_exists($file)){
			router::$routingTable = unserialize(file_get_contents($file));
		}else{
			$routingConfig = pluginManager::getConfig('router');

			foreach($routingConfig as $pattern => $parameters) {
				$routeIndex = $parameters['name'];
				
				router::$routingTable[$routeIndex]['pattern'] = $pattern;
				router::$routingTable[$routeIndex]['parameters'] = $parameters;
	
				preg_match_all("/\#([a-zA-Z]+)/", $pattern, $matches);
	
				router::$routingTable[$routeIndex]['variableName'] = $matches[1];
	
				$pattern = preg_quote($pattern,'/');
				$pattern = str_replace($matches[0], "([^\/]+)", $pattern);
	
				router::$routingTable[$routeIndex]['regexp'] = "/^".$pattern."$/";
				$routeIndex++;
			}
			file_put_contents($file, serialize(router::$routingTable));	
		}	
	}

	private function getRouting($path) {
		$fileKey = $path;
		
		if (cache::fileIsCached('routing', $fileKey)){
			return cache::fileRead('routing', $fileKey);
		}else{		
			foreach(router::$routingTable as $route) {
				if (preg_match($route['regexp'],$path,$matches)) {
					$routing['route'] = $route;
	
					array_shift($matches);
					$variables = array();
					
					foreach($matches as $key => $value) {
						$variables[$route['variableName'][$key]] = $value;
					}
					
					$routing['variables'] = $variables;

					cache::fileWrite('routing', $fileKey, $routing);
					return $routing;
				}
			}
		}
	}
	
	public static function route($target, $variables = array(), $anchor = null) {
		
		$extesion = "";
		if (is_array($target)){
			$extesion = ".".$target[1];
			$target=$target[0];
		}
		if (strpos($target,"/") === false){
			$route = router::$routingTable[$target];
			$keys = array_keys($variables);
			array_walk($keys, "prependHash");
			preg_match_all("/\#([a-zA-Z]+)/", $route['pattern'], $routeVars);
			$routePath = str_replace($keys, array_values($variables), $route['pattern']).$extesion;
			$variables = array_diff_key($variables, array_flip($routeVars[1]));
			$variablesUrl = null;
			if($variables!=null){
				$variablesUrl = "?".http_build_query($variables);
			}
			$route = rtrim(HOME,'/').$routePath.$variablesUrl;
		} else {
			$route = $target;
			if (count($variables) > 0) $route.="?".http_build_query($variables);
		}
		
		if ($anchor != null) $anchor = "#".$anchor;
		return html_entity_decode($route).$anchor;
	}

	public static function unique() {
		return md5("" . mt_rand(0,PHP_INT_MAX-1) . "A" . microtime(true));
	}
	
	public static function loadUrl($target, array $query = array(), $permanent = false) {
		$route = self::route($target, $query);
		echo "<script language='javascript'>document.location.href='".$route."'</script>";
		exit;
	}
	
	public static function loadParent($target, array $query = array(), $permanent = false) {
		$route = self::route($target, $query);
		echo "<script language='javascript'>parent.location.href='".$route."'</script>";
		exit;
	}	
	public static function reloadParent() {
		echo "<script language='javascript'>self.parent.location.reload();</script>";
	}		
	public static function redirect($target, array $query = array(), $permanent = false, $anchor = null) {		
		$route = self::route($target, $query, $anchor);

		if ($permanent) header("HTTP/1.1 301 Moved Permanently");
		header("Location: ".$route);
		exit;
	}
	public static function back($request,$anchor = 'mp=admin.message.success') {
		$referer = str_replace($anchor, '', $request->server('HTTP_REFERER'));
		if ($anchor!=null) {
			if (strstr($referer, '?')==FALSE) {
				$anchor = '?'.$anchor;
			}else{
				$anchor = '&'.$anchor;
			}
		}
		$referer = $referer.$anchor;
		$referer = str_replace(array('?&','&&'), array('?','&'), $referer);
		self::redirect($referer);		
	}
	public static function reload($message = 'admin.message.success',$messageType = 'mp',$force = false) {
		if ($force==true) {
			self::redirect(self::selfLink());
		}
		if ($_POST!=null){
			self::redirect(self::selfLink(),array($messageType=>$message));
		}
	}
	public static function selfLink($anchor = null){
		if ($anchor!=null) {
			$anchor = '#'.$anchor;
		}
		$redirectUrlParts = explode('?',$_SERVER['REQUEST_URI']);
		$redirectUrl = $redirectUrlParts[0];
		return __BASE.$redirectUrl.$anchor;
	}
	public function callController(request $request) {
		$routing = $this->getRouting($request->path());
		$request->setRouting($routing);
		$controllerClassName = self::getController($request);
		$controller = new $controllerClassName($request);
		$action = self::getAction($request,$controller);
		$controller->$action();
	}

	public static function getController(request $request) {
		$className =  $request->controllerClass();
		if ($className==null) {
			$className='error404Controller';
		}
		return $className;
	}	
	public static function getAction(request $request,$controller) {
		
		if (method_exists($controller, $request->getVariable('action'))){
			return $request->getVariable('action');
		}
		return 'index';
	}
	public static function get404Redirect($source) {
		$redirectorDB = new redirectDB();
		$target = $redirectorDB->getTarget($source);
		if ($target!=null) {
			self::redirect($target);
		}
	}
}
function prependHash(&$value, $key) {
	$value = "#".$value;
}
?>
