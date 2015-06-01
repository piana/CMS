<?php  /*windu.org image*/
class fileJsUpload extends file
{
    public function post($request) {
    	$info = file::saveIncomingFiles($request->getVariable('bucket'),true);
    	$finalArr['files'] = $info;
        $json = json_encode($finalArr);

        echo $json;
    }

}
