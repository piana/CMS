<?php /*windu.org core*/ 

abstract class request {
	
	protected $variables = array();
	protected $routing = null;
	
	public abstract function path();
	public abstract function extension();
	public abstract function httpRoot();

	public final function setVariables($variables) {
		$this->variables = array_merge($this->variables,$variables);
	}
	
	public final function variables($type) {
		return $this->variables[strtoupper($type)];
	}
	
	public final function setRouting($routing) {
		$this->routing = $routing;
	}
	
	public final function getRouting() {
		return $this->routing;
	}
	
	//returns current route
	public function httpPath() {
		return $this->httpRoot().ltrim($this->path(),"/");
	}
	
	public final function controllerName() {
		$controller = explode("_",$this->controllerClass());
		return $controller[count($controller)-1];
	}
	
	public final function controllerClass() {
		return $this->routing['route']['parameters']['controller'];
	}
	public function setVariable($key,$value) {
		$this->routing['variables'][$key] = $value;
	}
	
	//TODO - zoptymalizowac!!
	public final function getVariable($key) {
		if (isset($this->routing['variables'])) foreach($this->routing['variables'] as $varKey => $value) {
			if ($key === $varKey) return $value;
		}
		
		if (isset($this->variables['POST'])) foreach($this->variables['POST'] as $varKey => $value) {
			if ($key === $varKey) return $value;
		}
	
		if (isset($this->variables['GET'])) foreach($this->variables['GET'] as $varKey => $value) {
			if ($key === $varKey) return generate::prepareGet($value);
		}		
		
		return null;
	}
	
	public function __set($name, $value) {
		$this->setVariable($name,$value);
	}
	
	public function __get($name) {
		return $this->getVariable($name);
	}
	
	public function __call($method, $args) {
		if(preg_match('/^(get)([a-zA-Z0-9_]*)$/', $method, $matches)) { 
			$variable = lcfirst($matches[2]);
			return $this->getVariable($variable);
		}
	}
   	
}

?>