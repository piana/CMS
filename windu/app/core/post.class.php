<?php /*windu.org core*/
class post
{
	public static function readAll()
	{
		foreach ($_POST as $name => $value) {
			$values[$name] = base64_decode(self::read($name));
		}
		return $values;
	}		
	public static function read($name,$noDecode = false)
	{
		if (isset($_POST[$name]))
		{
			if ($noDecode) {
				return $_POST[$name];
			}else{
				return base64_decode($_POST[$name]); 
			}
		}
		else
		{
			return null;
		}
	}
	public static function set($name,$val)
	{
		return "{$name}=".base64_encode($val);
	}
}
?>
