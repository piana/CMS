<?php /*windu.org model*/
Class rateController extends widgetMainController
{		
	public function run() {
		$ratesDB = new ratesDB();
		return array("ratesDB" => $ratesDB);
	}
}
?>