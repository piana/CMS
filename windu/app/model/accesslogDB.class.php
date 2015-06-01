<?php /*windu.org model*/
class accesslogDB extends baseDB
{
	function __construct($customMySQL = array())
	{
		$this->otherDbFile = FILE_DB_LOG_FILE;
		parent::__construct($customMySQL);
	}
   	public function clean($date){
   		$date = generate::sqlDatetime($date);
   		$this->deleteRows("insertTime <= '{$date}'");
   	}
   	public function fetchCountGroup($groupBy,$where = null,$order = null,$what = '*', $limit = null, $bindValues = array()) {
   		$cacheKey = md5($groupBy.$where.$order.$what.$limit.serialize($bindValues));
   		if (cache::fileIsCached('accessLog', $cacheKey)) {
   			return cache::fileRead('accessLog', $cacheKey);
   		}else{
   			$result = parent::fetchCountGroup($groupBy,$where,$order,$what,$limit,$bindValues);
   			cache::fileWrite('accessLog', $cacheKey, $result);
   		}
   		return $result;
   	}
	
}
?>