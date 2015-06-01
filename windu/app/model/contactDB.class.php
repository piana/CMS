<?php /*windu.org model*/
class contactDB extends traceDB
{
	const STATUS_UNACTIVE = 0;
	const STATUS_ACTIVE = 1;
	public $contactColumns = array('name','email','telephone','mobile','adress','city','code','country','taxid','other');	
	
	public function add($data,$bucket) {
		$data['bucket'] = $bucket;
		$data['sendedEmails'] = 0;
		$data['status'] = self::STATUS_ACTIVE;
		$data['ekey'] = generate::ekey($this);
		if (empty($data['name'])) {
			$name = explode('@', $data['email']);
			$data['name']=$name[0];
		}
		
		if ($this->fetchCount("email= :email and bucket= :bucket", array(':email' => $data['email'], ':bucket' => $data['bucket'] ) )<=0) {
			$this->insert($data);
		}elseif ($this->fetchCount("email = :email", array(':email' => $data['email']) )>0){
			unset($data['sendedEmails']);
			unset($data['status']);
			unset($data['ekey']);
			unset($data['email']);
			
			$contact = $this->updateRow($data,"email = :email", array(':email' => $data['email']) );
		}
	}
	public function addSmart($data,$bucketName = 'Contact Form'){
		$contactGroupsDB = new contactgroupsDB();
		$group = $contactGroupsDB->fetchRow("name = :bucketName", null, '*', array( ':bucketName' => $bucketName ) );
		if($group==null){
			$contactGroupsDB->add(array('name'=>$bucketName));
			$group = $contactGroupsDB->fetchRow("name = :bucketName", null, '*', array( ':bucketName' => $bucketName ) );
		}
		foreach ($data as $key => $val) {
			if (!in_array($key, $this->contactColumns)) {
				unset($data[$key]);
			}
		}
		$this->add($data, $group->id);
	}	
	
	public function deleteByBucket($bucket) {
		$this->deleteRows("bucket=:bucket", array( ':bucket' => $bucket ));
	}
	public function getEmails($bucket,$startId = 0,$limit = 1000,$status = self::STATUS_ACTIVE,$sendedEmailsLimit = 0,$what = 'id,name,email,ekey',$fetchType = PDO::FETCH_OBJ) {
		if ($sendedEmails>0){
        	$sendedEmailsWhere = "and sendedEmails < '{$sendedEmailsLimit}'";
        }else{
        	$sendedEmailsWhere = '';
        }
		$emails = $this->fetchAll("id >= {$startId} and bucket='{$bucket}' and status='{$status}' $sendedEmailsWhere ","id ASC",$what,$limit,null,null,$fetchType);
		return $emails;
	}

	public function getEmailsCount($bucket,$status = self::STATUS_ACTIVE) {
		$emailsCount = $this->fetchCount("bucket = :bucket and status = :status", array( ':bucket' => $bucket, ':status' => $status ) );
		return $emailsCount;
	}	
	public function exclude($ekey) {
		return $this->updateRow(array('status'=>self::STATUS_UNACTIVE),"ekey = :ekey", array( ':ekey' => $ekey ) );
	}

}
?>
