<?php /*windu.org core*/
class get
{
	public static function readAll()
	{
		foreach ($_GET as $name => $value){
			$values[$name] = self::read($name);
		}
		return $values;
	}		
	public static function read($name)
	{
		if (isset($_GET[$name])){
			return base64_decode($_GET[$name]);
		}
		else{
			return null;
		}
	}
	public static function set($name,$val)
	{
		return "{$name}=".base64_encode($val);
	}
}
?>
