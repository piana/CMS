<?php /*windu.org model*/
Class contactFormController extends widgetMainController
{		
	public function run() {
		
        $form = new form('contactForm','contactFormSuccess',$_POST,'POST','form-horizontal',null,false,false,'contactform.message.negative');
		$elements = explode(',',$this->params['inputs']);
        
		foreach($elements as $element){
        	$elementName = generate::cleanFileName($element);
			$form->add($elementName, 'input-text', $element);
			$form->addRule($elementName, 'required', null,lang::read('front.form.giveelement'));
		}
        $form->add('email', 'input-text',lang::read('front.form.email'),null,array());
		$form->addRule('email', 'required', null, lang::read('front.form.giveemail'));	
		$form->addRule('email', 'email', null, lang::read('front.form.givecorrectemail'));	
        
        $form->add('content','textarea',lang::read('front.form.contactformcontent'),null,array('class'=>'span3'));
        $form->addRule('content', 'required', null, lang::read('front.form.givecontent'));
        
        $form->addButton('login',lang::read('front.form.send'),'btn btn-primary margin-right');
		$form->setHandler($this);
		$form->handle();
        
		return array("form" => $form);
	}
	public function contactFormSuccess($data) {
    	foreach($data as $key => $dataOne){
        	$message.="<strong>".$key."</strong>: ".$dataOne.'<br>';
        }
    	
        $to = $this->params['email'];
		$subject = lang::read('front.form.msgsent');
		
		$senderName = $data['email'];
		$from = $data['email'];
		$replay = $data['email'];
		$return = $data['email'];
        
    	mail::send($to,$subject,$message,$senderName,$from,$replay,$return);
    	
    	$dataContact = $data;
    	$contactDB = new contactDB();
    	$contactDB->addSmart($dataContact,'Contact Form Test');
    	
        router::reload('contactform.message.positive','mp');
	}    
}
?>