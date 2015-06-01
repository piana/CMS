<?php /*windu.org image controller*/

Class fileServerJsUploadController extends controller
{
	public function index(){
	    $usersDB = new usersDB();
    	if($usersDB->getLoggedIn('AdminUser')==null){
    		exit;
    	}	
    	
		$upload_handler = new fileJsUpload();

		switch ($_SERVER['REQUEST_METHOD']) {
			case 'POST': $upload_handler->post($this->request); break;
			default: header('HTTP/1.1 405 Method Not Allowed');
		}
	}
}
?>
