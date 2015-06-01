<?php /*windu.org core*/
class firewall
{
	public static function accessLog() {
		if(config::getSystemRun("firewall")){
			$time = date('Y-m-d-H',strtotime('now'));
			$filename = DATA_PATH.'log/firewall/'.$time.'-'.md5(generate::ip()).'.log';

			if (file_exists($filename)) {
				if (filesize($filename) >= config::get('firewallRequestLimit')) {
					$firewallDB = new firewallDB();
					$addCount = $firewallDB->add();
					if ($addCount==1) {
						mail::send(config::get('firewallEmail'), config::get('pageName').' - Firewall ALERT', 'ALERT! IP: <strong>'.generate::ip().'</strong> add to deny array on <strong>'.config::get('pageName').'</strong>',null,EMAIL_NOREPLAY,EMAIL_NOREPLAY,EMAIL_NOREPLAY,null,true);
						self::saveHtaacess();
					}elseif ($addCount<=3){
						if (cache::isCached('firewallMailSend'.generate::ip(),3600)) {
							mail::send(config::get('firewallEmail'), config::get('pageName').' - Firewall secound ALERT', 'ALERT! IP: <strong>'.generate::ip().'</strong> add <strong>'.$addCount.'</strong> times to deny array on <strong>'.config::get('pageName').'</strong>',null,EMAIL_NOREPLAY,EMAIL_NOREPLAY,EMAIL_NOREPLAY,null,true);
							cache::set('firewallMailSend'.generate::ip(), 1);
							self::saveHtaacess();
						}
					}
				}
			}
			file_put_contents($filename,1,FILE_APPEND);
			
		}	
	}
	
	public static function saveHtaacess() {

		$firewallDB = new firewallDB();
		$denyArray = $firewallDB->fetchAll("status>0",null,'createIp');
		
		$baseString = "order allow,deny\r\n";
		foreach ($denyArray as $deny){
			$baseString .= 'deny from '.$deny->createIp."\r\n";
		}
		
		$baseString .= "allow from all\r\n";
		$baseString .= '<IfModule mod_rewrite.c>
	RewriteEngine on 
	RewriteRule !(\.(php|ico|ICO|css|CSS|less|LESS|js|JS|htc|HTC|gpx|GPX|gif|GIF|jpg|JPG|jpeg|JPEG|png|PNG|swf|SWF|mp3|MP3|mp4|MP4|zip|ZIP|pdf|PDF|ttf|TTF|xml|XML|txt|TXT|eot|EOT|woff|WOFF|svg|SVG|xlsx|XLSX|xls|XLS|map|MAP))$ index.php [L,QSA]
</IfModule> 
<IfModule mod_expires.c>
	ExpiresActive On
	<FilesMatch "\.(ico|gif|jpe?g|png|svg|svgz|js|css|swf|ttf|otf|woff|eot)$">
		ExpiresDefault "access plus 1 month"
	</FilesMatch>
</IfModule>
<IfModule mod_deflate.c>
	AddOutputFilterByType DEFLATE text/html text/plain text/xml application/xml text/javascript text/css application/x-javascript application/xhtml+xml application/javascript

	# these browsers do not support deflate
	BrowserMatch ^Mozilla/4 gzip-only-text/html
	BrowserMatch ^Mozilla/4.0[678] no-gzip
	BrowserMatch bMSIE !no-gzip !gzip-only-text/html

	SetEnvIf User-Agent ".*MSIE.*" nokeepalive ssl-unclean-shutdown downgrade-1.0 force
</IfModule>';		
		
		baseFile::saveFile(__SITE_PATH.'/.htaccess', $baseString);
	}
	public static function cleanOldFilesDay() {
		$dataPattern = date('Y-m-d',strtotime("-1 day"));

		$mask = DATA_PATH."log/firewall/{$dataPattern}*";
		$files = glob( $mask );
		if (is_array($files)) {
			array_map( "unlink", $files);	
		}

   		return lang::read('firewall.class.firewallday') .date('Y-m-d',strtotime("-1 day"));
	}
	public static function cleanOldFilesMonth() {
		$dataPattern = date('Y-m',strtotime("-30 days"));

		$mask = DATA_PATH."log/firewall/{$dataPattern}*";
		$files = glob( $mask );
		if (is_array($files)) {
			array_map( "unlink", $files );	
		}
   		
   		return lang::read('firewall.class.month') .date('Y-m',strtotime("-30 days"));	
	}	
	public static function getDenyArray() {
		$firewallDB = new firewallDB();
		return $firewallDB->fetchAll("status>0");
	}
}

?>