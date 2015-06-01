<?php /*windu.org core*/
class log
{
    public static function write($data,$bucket = 0)
    {
    	if (config::getSystemRun("log")) {
    		if (is_array($data)) {
    			$data = serialize($data);
    		}

			$logDB = new logDB();
			$logDB->add($bucket, array("data" => $data));
    	}
    }
    public static function writeHistory($data,$tableName,$bucket = 0){
        $excludedArray = array('log','session','cache','pagesbackups','notify','accesslog','bannerlog','cronlog','fileslog','forumReadedLog','mail','rates');
        if (config::getSystemRun("log") and !in_array($tableName,$excludedArray)) {
            $logDB = new logDB();
            $logDB->addHistory($bucket, array("data" => $tableName.' <---> '.$data));
        }
    }
}
?>
