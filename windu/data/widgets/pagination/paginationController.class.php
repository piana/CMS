<?php /*windu.org model*/
Class paginationController extends widgetMainController
{		
	public function run() {
		return array("page" =>$this->request->getVariable('p'),"pagesDB" => new pagesDB());
	}
}
?>