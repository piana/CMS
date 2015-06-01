<?php /*windu.org model*/
class mailingsDB extends traceDB
{
	const STATUS_ACTIVE = 1;
	const STATUS_UNACTIVE = 0;	

	public function add($data) {
		$data['status']=self::STATUS_ACTIVE;
		$data['sendedEmails']=0;
		$data['lastSendEmailId']=0;
		$this->insert($data);
	}
	public function getActive() {
		return $this->fetchAll("status=".self::STATUS_ACTIVE);
	}
	public function getUnactive(){
		return $this->fetchAll("status=".self::STATUS_UNACTIVE);
	}
	public function sendMailing($mailingId) {
		$mailing = $this->fetchRow("id={$mailingId}");
		return $this->send($mailingId,$mailing->contactGroup, $mailing->lastSendEmailId, config::get('mailingSendLimit'),$mailing->subject, $mailing->contentId, $mailing->senderName, $mailing->from, $mailing->replay, $mailing->return);
	}
	public function send($mailingId,$bucketId, $startId, $part, $subject, $messageId, $senderName, $from, $replay, $return) {
		$contactDB = new contactDB();
		$emails = $contactDB->getEmails($bucketId,$startId,$part);
		
		$mailingtempaltesDB = new mailingtemplatesDB();

		foreach ($emails as $email){
			$message = $mailingtempaltesDB->render($messageId, $email);
			mail::send($email->email, $subject, $message, $senderName, $from, $replay, $return);
			$data['lastSendEmailId'] = $email->id;
			$data['sendedEmails'] = $this->get($mailingId, 'sendedEmails')+1;
			$this->updateRow($data,"id={$mailingId}");
		}
		if ($data['lastSendEmailId']==$contactDB->fetchRow($bucketId,'id DESC')->id) {
			$this->set($mailingId, 'status', self::STATUS_UNACTIVE);
		}
		return count($emails);
	}
}
?>
