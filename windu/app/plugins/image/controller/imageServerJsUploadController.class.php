<?php /*windu.org image controller*/

Class imageServerJsUploadController extends controller
{
	public function index(){
	
		$upload_handler = new imageJsUpload();

		switch ($_SERVER['REQUEST_METHOD']) {
			case 'POST': $upload_handler->post($this->request); break;
			default: header('HTTP/1.1 405 Method Not Allowed');
		}
	}
}
?>