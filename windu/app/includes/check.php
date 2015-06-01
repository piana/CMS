<?php
	$extensionsArray = array('curl','mbstring');
	$apacheModulesArray = array('mod_alias','mod_authz_host','mod_autoindex','mod_mime','mod_env','mod_rewrite');
	
	$sapi_type = php_sapi_name();
	if (substr($sapi_type, 0, 6) != 'apache') {
	    $apache_modules = null;
	} else {
	    $apache_modules = apache_get_modules();
	}

	$error = 0;
	
	function checkCHMOD($path,$exclude = array()) {
		$dir = opendir($path);
		
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' ) && (!in_array($file,$exclude))) {
				if ( is_dir($path.'/'.$file)) {
					if (!is_writable($path.'/'.$file) and !is_readable($path.'/'.$file)) {
						$error['file'][] = $path.'/'.$file;
					}
					checkCHMOD($path.'/'.$file,$exclude);
				}
				else {
					if (!is_writable($path.'/'.$file) or !is_readable($path.'/'.$file)) {
						$error['dir'][] = $path.'/'.$file;
					}
				}
			}
		}
		closedir($dir);
		return $error;
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style type="text/css">
			@import url("<?php echo __HOME;?>app/resources/bootstrap/css/bootstrap.min.css");
			@import url("<?php echo __HOME;?>app/plugins/admin/resources/css/bootstrap-extends.css");
			@import url("<?php echo __HOME;?>app/resources/css/icons.css");
			@import url("<?php echo __HOME;?>app/plugins/admin/resources/css/login.css");
		</style>
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script type="text/javascript" src="<?php echo __HOME;?>app/resources/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo __HOME;?>app/resources/js/jquery.validate.js"></script> 
		<script type="text/javascript" src="<?php echo __HOME;?>app/resources/bootstrap/js/bootstrap.min.js"></script>  
		<title>Login</title>
	</head>
	<body>
		<div class="loginbox">
			<img src="<?php echo __HOME;?>app/plugins/admin/resources/img/logo-login.png">
			
			<div class="loginbox-white">
			<h4 style="margin-bottom:-1px;">System check raport</h4>		
			<table class="table table-striped margin-bottom" style="border-bottom:1px #ddd solid;">
				<tbody>			
					<?php
						$phpverpom = explode('.',phpversion());
						echo '<tr><td class="left-column-install">PHP version minimum: <strong>5.2</strong></td>';
						echo '<td class="right-column-install"><strong>';
						if ($phpverpom[0] < 5 or $phpverpom[1]< 2){
							echo '<span class="badge badge-important">'.phpversion().'</span>';
							$error = 1;
						}else{
							echo '<span class="badge badge-success">'.phpversion().'</span>';
						}
						echo '</strong></td></tr>';
					
						$extensionError = 0;
						foreach ($extensionsArray as $extension) {
							if (!extension_loaded($extension)){
								echo '<tr><td class="left-column-install">PHP extension: <strong>'.$extension.'</strong></td><td class="right-column-install"><strong>';
								echo '<span class="badge badge-important">ERROR</span>';
								echo '</strong></td></tr>';
								$error = 1;
								$extensionError = 1;
							}							
						}
						
						if (!(extension_loaded('pdo_sqlite') or extension_loaded('pdo_mysql'))){
								echo '<tr><td class="left-column-install">PHP extension: <strong>pdo_sqlite</strong></td><td class="right-column-install"><strong>';
								echo '<span class="badge badge-important">ERROR</span>';
								echo '</strong></td></tr>';
								
								echo '<tr><td class="left-column-install">PHP extension: <strong>pdo_mysql</strong></td><td class="right-column-install"><strong>';
								echo '<span class="badge badge-important">ERROR</span>';
								echo '</strong></td></tr>';		
														
								$error = 1;
								$extensionError = 1;
						}						
						if ($extensionError==0) {
							echo '<tr><td class="left-column-install">PHP extensions </td><td class="right-column-install"><strong>';
							echo '<span class="badge badge-success">OK</span>';
							echo '</strong></td></tr>';
						}

						$apacheModulesError = 0;
						foreach ($apacheModulesArray as $module) {
							if (is_array($apache_modules)) {
								if (!in_array($module, $apache_modules)){
									echo '<td class="left-column-install">Apache module: <strong>'.$module.'</strong></td><td class="right-column-install"><strong>';
									echo '<span class="badge badge-important">ERROR</span>';
									echo '</strong></td></tr>';
									$error = 1;
									$apacheModulesError = 1;
								}
							}
						}	
						if ($apacheModulesError==0) {
							echo '<tr><td class="left-column-install">Apache modules </td><td class="right-column-install"><strong>';
							echo '<span class="badge badge-success">OK</span>';
							echo '</strong></td></tr>';
						}
						
						$filePermissionError = 0;

						$cacheFilesCheck = checkCHMOD(__SITE_PATH.'/cache/');
						if (count($cacheFilesCheck['dir'])>0 or count($cacheFilesCheck['dir'])>0) {
							echo '<tr><td class="left-column-install">Dir permission <strong>cache</strong></td>';
							echo '<td class="right-column-install"><strong>';							
							echo '<span class="badge badge-important">';
								 $errorsNum = intval($cacheFilesCheck['file'])+intval($cacheFilesCheck['dir']);
							echo $errorsNum;
							echo '</span>';
							echo '</strong></td></tr>';
							$error = 1;
							$filePermissionError = 1;
						}		

						$dataFilesCheck = checkCHMOD(__SITE_PATH.'/data/');
						if (count($dataFilesCheck['dir'])>0 or count($dataFilesCheck['dir'])>0) {
							echo '<tr><td class="left-column-install">Dir permission <strong>data</strong></td>';
							echo '<td class="right-column-install"><strong>';							
							echo '<span class="badge badge-important">';
								 $errorsNum = intval($dataFilesCheck['file'])+intval($dataFilesCheck['dir']);
							echo $errorsNum;
							echo '</span>';
							echo '</strong></td></tr>';
							$error = 1;
							$filePermissionError = 1;	
						}
						$appFilesCheck = checkCHMOD(__SITE_PATH.'/app/');
						if (count($appFilesCheck['dir'])>0 or count($appFilesCheck['dir'])>0) {
							echo '<tr><td class="left-column-install">Dir permission <strong>app</strong></td>';
							echo '<td class="right-column-install"><strong>';							
							echo '<span class="badge badge-important">';
								 $errorsNum = intval($appFilesCheck['file'])+intval($appFilesCheck['dir']);
							echo $errorsNum;
							echo '</span>';
							echo '</strong></td></tr>';
							$error = 1;
							$filePermissionError = 1;	
						}						
						if (!@is_writable(__SITE_PATH.'/') and !@is_readable(__SITE_PATH.'/')) {
							echo '<tr><td class="left-column-install">Main dir permission</td>';
							echo '<td class="right-column-install"><strong>';							
							echo '<span class="badge badge-important">ERROR</span>';
							echo '</strong></td></tr>';
							$error = 1;
							$filePermissionError = 1;
						}	
						if ($filePermissionError==0) {
							echo '<tr><td class="left-column-install">Permission for files and dirs</td><td class="right-column-install"><strong>';
							echo '<span class="badge badge-success">OK</span>';
							echo '</strong></td></tr>';
						}											
						
						if($error==0){
							file_put_contents(__SITE_PATH.'/data/log/systemchecked.tmp', microtime());
							if (!file_exists(__SITE_PATH.'/data/log/systemchecked.tmp')) {
								echo '<div style="color:red; padding:15px;">System can not create file<br><strong>/data/log/systemchecked.tmp</strong><br>add file manually</div>';
							}
						}
					?>		
					</tbody>
				</table>
				<?php
					if($error!=0){
						echo '<a href="'.__HOME.'" class="btn btn-danger btn-large" style="margin-bottom:30px;">Check again</a>';
					}else{
						echo '<a href="'.__HOME.'admin/install/" class="btn btn-primary btn-large" style="margin-bottom:30px;">Start installation</a>';
					}
				?>
			</div>
		</div>
	</body> 
</html>