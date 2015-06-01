<?php /*windu.org model*/
Class newsletterController extends widgetMainController
{		
	public function run() {
		$form = new form('newsletter','newsletterAddSuccess',$_POST,'POST','form-horizontal');

		$form->add('email', 'input-text',null,null,array("tooltip" => lang::read('front.form.email'),"class" => "input-medium","id" => "inputIcon" ,"placeholder" => lang::read('front.newsletter.email')));

		$form->addRule('email', 'required', null, lang::read('front.form.giveemail'));	
		$form->addRule('email', 'email', null, lang::read('front.form.givecorrectemail'));	

		$form->addButton('add',lang::read('front.newsletter.sign'),'btn btn-primary');

		$form->setHandler($this);
		$form->handle();
		return array("form" => $form);
	}

     public function newsletterAddSuccess($data) {
        $dataContact = $data;
    	$contactDB = new contactDB();
    	$contactDB->addSmart($dataContact,'Newsletter');
    
        router::reload('newsletter.message.positive','mp');
	}
}
?>