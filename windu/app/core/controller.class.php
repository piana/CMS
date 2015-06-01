<?php /*windu.org core*/
class controller
{
	public $request;
	public function __construct(request $request){
		$this->request = $request;
	}
}
?>