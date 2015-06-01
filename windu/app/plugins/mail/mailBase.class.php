<?php /*windu.org mail*/
class mailBase
{
	public static function sendMail($to, $subject, $message, $name, $from, $replay, $return, $parameters){
		if ($name==null) {
			$name=$to;
		}
		
		$messageId = generate::ekey('mailDB','messageId',32,3);
		$mailDB = new mailDB();
		$mailDB->add($to,$messageId);
		
		$mail = new PHPMailer();
		//$mail->IsSendmail();
		$mail->CharSet = 'utf-8';
		$mail->IsMail();

		$mail->AddReplyTo($replay, config::get('pageName').' - MAILER');
		$mail->AddAddress($to, $name);
		$mail->SetFrom($from, config::get('pageName'));
		$mail->Subject = $subject;
		$mail->MsgHTML($message);
		
		if(!$mail->Send()) {
			notifyDB::add('admin.notify.error.mailer', notifyDB::STATUS_ERROR);
		}		
		
		return true;
	}
}
?>