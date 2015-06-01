<?php /*windu.org admin controller*/
Class adminFrontEditorDoController Extends adminAuthDoController{
	public function setPageTemplate() {
		$pageId = $this->request->getVariable('id');
		$templateName = $this->request->getVariable('secoundId');
	}
}
?>
