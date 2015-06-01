<?php  /*windu.org mail*/
class mail extends mailBase
{	
    /**
     * 
     * @param string $to
     * @param string $subject
     * @param string $message
     * @param string $name (optional) name of author
     * @param string $from (optional) email of author ?
     * @param string $replay (optional) reply to email
     * @param string $return (optional) email in case of return?
     * @param type $additional_parameters (optional)
     * @return boolean returns true if mail is send correctly
     */
    public static function send($to,
								$subject,
								$message,
								$name = null,
								$from = EMAIL_NOREPLAY,
								$replay = EMAIL_NOREPLAY,
								$return = EMAIL_NOREPLAY,
								$additional_parameters = null,
								$loadDefaultTemplate = false){
    	
    	if ($loadDefaultTemplate) {
				$message = '
					<html>
						<body style="background-color:#f7f7f7; padding:15px; font-family: arial; font-size:14px;">
							<center>
								<div style="border:1px #e9e9e9 solid; background-color:white; padding:30px; color: #333; width:460px; text-align:center;">
									'.$message.'
								</div>
								<div style="font-size:10px; color: silver; margin-top:10px;">
									This mail has been from IP: '.$data['ip'].' at: '.$data['insertTime'].'
								</div>
							</center>
						</body>
					</html>			
				';
    	}
		return mail::sendMail($to, $subject, $message, $name, $from, $replay, $return, $additional_parameters);
	}
}
?>