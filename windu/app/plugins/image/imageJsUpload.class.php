<?php  /*windu.org image*/
class imageJsUpload extends image
{
    public function post($request) {
    	$usersDB = new usersDB();
    	if($usersDB->getLoggedIn('AdminUser')==null){
    		exit;
    	}
    	
       	$info = image::saveIncomingImages($request->getVariable('bucket'),true);
       	$finalArr['files'] = $info;
        $json = json_encode($finalArr);
		
        echo $json;
    }

}