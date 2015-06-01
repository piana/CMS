<?php /*windu.org core*/ 
class requestHttp extends request {
	
	private $urlParameters = null;
	
	public function __construct($server, $GET, $POST) {

		$this->urlParameters = parse_url($server['REQUEST_URI']);
		$this->urlParameters['path'] = preg_replace("/^".preg_quote(SUBDIR,'/')."/", "", $this->urlParameters['path'],1);

		preg_match("/\.([A-Za-z]+)$/",$this->urlParameters['path'],$matches);
		$this->urlParameters['path'] = "/".str_replace($matches[0], "", $this->urlParameters['path']);

		$this->urlParameters['requestPattern'] = SUBDIR;
		$this->urlParameters['SERVER'] = $server;

		$this->setVariables(array("GET" => $GET, "POST" => $POST));
	}

	public function path() {
		return $this->urlParameters['path'];
	}

	public function extension() {
		return $this->urlParameters['extension'];
	}


	public function routeName() {
		$routing = $this->getRouting();
		return $routing['route']['parameters']['name'];
	}	
	
	public function server($key) {
		return $this->urlParameters['SERVER'][$key];
	}	

	public function requestPattern() {
		return $this->urlParameters['requestPattern'];
	}	
	
	public function httpRoot() {
		return __BASE.SUBDIR;
	}
	
	public function protocol() {
		preg_match("/^[A-Z]+/", $this->urlParameters['SERVER']['SERVER_PROTOCOL'], $match);
		return strtolower($match[0]);
	}
   	
}

?>