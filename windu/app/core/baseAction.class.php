<?php /*windu.org core*/
abstract class baseAction
{
	function __construct()
	{
		$this->POST = $_POST;
		$this->GET = $_GET;
	}
	
	abstract function execute ();
}