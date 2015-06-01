<?php /*windu.org model*/
Class userPanelController extends widgetMainController
{		
	public function run() {
		$usersDB = new usersDB();
		$user = $usersDB->getLoggedIn();
		if ($user==null) {
			router::redirect('front');
		}
		$userPageForm = new form('editUser','editUserSuccess',$_POST,'POST','form-horizontal');

		$userPageForm->add('username', 'input-text',lang::read('user.panel.username'),$user->username,array("tooltip" => lang::read('user.panel.shownname'),"placeholder" => lang::read('user.panel.kowal')));
		$userPageForm->add('name', 'input-text',lang::read('user.panel.name'),$user->name,array("placeholder" => lang::read('user.panel.jan')));
		$userPageForm->add('surname', 'input-text',lang::read('user.panel.surname'),$user->surname,array("placeholder" => lang::read('user.panel.kowalski')));
		
		$imagesDB = new imagesDB();
		
		//image/////
		$mainImage = $imagesDB->getFirstByBucket('user-'.$user->id);
		if(is_object($mainImage)){
			$userPageForm->add('HTML',"
			<div class='control-group'>
				<label class='control-label'>
					<a href='".HOME."do/deleteUserImage/'><i class='fa fa-times-circle'>&nbsp;</i></a>
				</label>
				<div class='controls'>
					<img src='".HOME."image/{$mainImage->ekey}/200/150/fit/'>
				</div>
			</div>");
		}

		$userPageForm->add('image', 'input-file',lang::read('user.panel.avatar'),null,array("tooltip" => lang::read('admin.content.controller.imagedescription')));	

		$userPageForm->add('HTML',"<br><br>");
		$userPageForm->add('password', 'input-password',lang::read('user.panel.password'),null,array("tooltip" => lang::read('user.panel.autogener')));
		$userPageForm->addRule('password', 'string', array(6,50),lang::read('user.panel.toshortpass'));	
		$userPageForm->addRule('password', 'same','passwordCompare',lang::read('user.panel.diffpasswords'));
		$userPageForm->add('passwordCompare', 'input-password',lang::read('user.panel.repeatpassword'),null);		
		
		$userPageForm->addButton('submit',lang::read('user.panel.save'));	
		
		$userPageForm->setHandler($this);
		$userPageForm->handle();

		return array("form" => $userPageForm);
	}
	public function editUserSuccess($data) {
		$usersDB = new usersDB();
		$user = $usersDB->getLoggedIn();

		if ($_FILES['image']['error']==0) {
			image::deleteImageByBucket('user-'.$user->id);
			image::saveIncomingImage($_FILES['image'],'user-'.$user->id);
		}		
		
		unset($data['passwordCompare']);
		if ($data['password']==null){
			unset($data['password']);
		}

		$usersDB->updateRow($data,"id={$user->id}");
		router::reload();
	}	
}
?>