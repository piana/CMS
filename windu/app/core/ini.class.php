<?php /*windu.org core*/
class ini
{
    public static function parse($filename) {
        $ini_arr = parse_ini_file($filename);
        if ($ini_arr === FALSE) {
            return FALSE;
        }
        
        $ini = array();
	    foreach($ini_arr as $key => $value)
		{
		    $p = &$ini;
		    foreach(explode('.', $key) as $k) $p = &$p[$k];
		    $p = $value;
		}
		unset($p);
		
        return $ini;
    }

}
?>
