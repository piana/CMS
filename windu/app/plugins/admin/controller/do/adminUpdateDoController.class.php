<?php /*windu.org admin controller*/
Class adminUpdateDoController Extends adminAuthDoController{
	public static $updateMethodsString = "'download','makeUpdate','flushCache','updatePHP','checkSystem','finish'";
	public function __construct(request $request, $plugins = array())
	{
		lang::set('admin');
		parent::__construct($request);
	}
	public function download() {
		$updateObject = new updateManager();
		$updateObject->setDownloadUpdateFlag( true );
		$updateObject->setPerformUpdateFlag( false );
		$updateObject->update();
		echo 1;
	}

	public function makeUpdate() {
		$updateObject = new updateManager();
		$updateObject->setDownloadUpdateFlag( false );
		$updateObject->setPerformUpdateFlag( true );
		$updateObject->update();

        cache::flushSystemCache();
        cache::resetExternalCaches();
		echo 1;
	}	
	public function flushCache() {
		//clear system cache
		cache::flushAllCache();
		
		//clear old notify
		$notifyDB = new notifyDB();
		$notifyDB->closeAll();

		echo 1;
	}
	public function updatePHP() {
		updatePHP::run();
		echo 1;
	}	
	public function checkSystem() {
		check::all();
		echo 1;
	}		
	public function finish() {
		//write cookie blocking many updates
		cookie::setCookie('update',0,3600);
		
		//Update log
		log::write("Update to revision ".config::get('revision'),logDB::BUCKET_UPDATE);
		echo 1;
	}
}
?>
