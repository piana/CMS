<?php /*windu.org model*/
class cronlogDB extends baseDB
{
	const BUCKET_HOUR = 0;
	const BUCKET_DAY = 1;
	const BUCKET_WEEK = 2;
	const BUCKET_MONTH = 3;
		
	function __construct($customMySQL = array())
	{
		$this->otherDbFile = FILE_DB_LOG_FILE;
		parent::__construct($customMySQL);
	}
	public function add($bucket,$message,$time)
	{
		if ($time>=20) {
			notifyDB::add('admin.notify.cron.long ', notifyDB::STATUS_DANGER,'admin/system/cron/');
		}
		$data['bucket'] = $bucket; 
		$data['message'] = $message; 
		$data['createTime'] = generate::sqlDatetime();
		$data['executeTime'] = round($time, 4);
		return $this->insert($data);
	}
   	public function clean($date){
   		$date = generate::sqlDatetime($date);
   		$this->deleteRows("createTime <= '{$date}'");
   	}	
}
?>