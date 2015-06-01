<?php /*windu.org model*/
Class notifyController extends widgetMainController
{		
	public function run() {
		
		$notifyMessageNegative = generate::cleanMessageKey($this->request->getVariable('mn'));
		$notifyMessagePositive = generate::cleanMessageKey($this->request->getVariable('mp'));

		return array("notifyMessagePositive" => $notifyMessagePositive,"notifyMessageNegative" => $notifyMessageNegative);
	}
}
?>