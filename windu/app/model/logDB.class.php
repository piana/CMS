<?php /*windu.org model*/
class logDB extends baseDB
{
	const BUCKET_404 = 1;
	const BUCKET_LOGIN_SUCCESS = 2;
	const BUCKET_LOGIN_ERROR = 3;
	const BUCKET_DOMAIN_VALID_ERROR = 91;
	const BUCKET_ERROR = 99;
	const BUCKET_UPDATE = 10;
	const BUCKET_SEO_PLUS = 20;
	const BUCKET_SEO_MINUS = 21;

    const BUCKET_USER_ACTIONS_ADD = 30;
    const BUCKET_USER_ACTIONS_EDIT = 31;
    const BUCKET_USER_ACTIONS_DELETE = 32;
    const BUCKET_USER_ACTIONS_OTHER = 33;
	
	function __construct($customMySQL = array())
	{
		$this->otherDbFile = FILE_DB_LOG_FILE;
		parent::__construct($customMySQL);
	}		
	public function add($bucket,$data)
	{
        $user = usersDB::getLoggedUser();

        if($user!=null){
            $data['userId'] = $user->id;
        }
		$data['bucket'] = $bucket;

        $returnData = $this->insert($data);
		return $returnData;
	}
    public function addHistory($bucket,$data){
        $user = usersDB::getLoggedUser();
        $logDB = new logDB();

        if($user!=null){
            $data['userId'] = $user->id;
        }
        $data['bucket'] = $bucket;

        $returnData = $logDB->insert($data);
        return $returnData;
    }
    public function insert(array $data = array())
    {
		$data['createTime'] = generate::sqlDatetime();
		$data['createIP'] = generate::ip();
    	parent::insert($data);
    } 
   	public function clean($date){
   		$date = generate::sqlDatetime($date);
   		$this->deleteRows("createTime <= '{$date}' and bucket!=".self::BUCKET_UPDATE);
   	}
    public function getHistoryLogs($page,$pageCount){
       $logs = $this->fetchAll("bucket=".self::BUCKET_USER_ACTIONS_ADD.' OR bucket='.self::BUCKET_USER_ACTIONS_EDIT.' OR bucket='.self::BUCKET_USER_ACTIONS_DELETE.' OR bucket='.self::BUCKET_USER_ACTIONS_OTHER,'createTime DESC','*',"{$page},{$pageCount}");
       foreach($logs as $key => $log){
           $dataPom = explode(' <---> ',$log->data);

           $logs[$key]->data = unserialize($dataPom[1]);
           $logs[$key]->table = $dataPom[0];
       }
       return $logs;
    }
    public function getHistoryLogsCount(){
        return $this->fetchCount("bucket=".self::BUCKET_USER_ACTIONS_ADD.' OR bucket='.self::BUCKET_USER_ACTIONS_EDIT.' OR bucket='.self::BUCKET_USER_ACTIONS_DELETE.' OR bucket='.self::BUCKET_USER_ACTIONS_OTHER);
    }
}
?>