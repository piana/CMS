<?php /*windu.org admin controller*/
Class adminCheckDoController Extends adminAuthDoController{
	public function ajaxCheck() {
		lang::set('admin');
		$checkType = $this->request->getVariable('id');
		if (in_array($checkType, check::$allCheckMethods)) {
			$response = intval(check::$checkType());
			$responseInfo = lang::read('admin.check.'.$checkType);
			
			echo $responseInfo;
		}
	}
}
?>
