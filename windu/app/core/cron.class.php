<?php /*windu.org core*/
class cron
{
	public static $cronTasks = array(	'hour_move_acceslogs'=>'core.cron.class.access',
										'hour_rss_update'=>'core.cron.class.feedup',
										'hour_mailing_send'=>'core.cron.class.smailing',
										'day_write_system_status'=>'core.cron.class.writesys',
										'day_clean_firewall'=>'core.cron.class.cleanold',
										'day_sitemap'=>'core.cron.class.generate',
										'week_compact_versions'=>'core.cron.class.pver',
										'week_flush_cache'=>'core.cron.class.cleancache',
										'week_delete_old_requestlogs'=>'core.cron.class.cleanoldrequest',
										'week_delete_old_logs'=>'core.cron.class.cleanologs',
										'month_vacum'=>'core.cron.class.database',
										'month_clean_firewall'=>'core.cron.class.cleanfire',
										'month_delete_thumbs'=>'core.cron.class.deleteall',
										'month_clean_backups'=>'core.cron.class.deleteold ',
										'month_backup'=>'core.cron.class.backupsys');
	
	public static function run() {

		$cronelogDB = new cronlogDB();
		$cronPath = DATA_PATH.'log/cron/';
		
		$hourPath = $cronPath.'hour-'.date('Y-m-d-H',strtotime('now')).'.log';
		$dayPath = $cronPath.'day-'.date('Y-m-d',strtotime('now')).'.log';
		$weekPath = $cronPath.'week-'.date('Y-W',strtotime('now')).'.log';
		$monthPath = $cronPath.'month-'.date('Y-m',strtotime('now')).'.log';
		$timeStart = round(microtime(true), 4);
		
		if (!file_exists($hourPath)) {
			@ignore_user_abort(true);
			$files = glob( $cronPath.'hour-*' );
			if (is_array($files)){array_map("unlink",$files);}			

			file_put_contents($hourPath, ' ');
			
			$message = self::hour();
			$cronelogDB->add(cronlogDB::BUCKET_HOUR, $message,round(microtime(true), 4)-$timeStart);
		}elseif (!file_exists($dayPath)) {
			@ignore_user_abort(true);
			$files = glob( $cronPath.'day-*' );
			if (is_array($files)){array_map("unlink",$files);}					

			file_put_contents($dayPath, ' ');
			
			$message = self::day();
			$cronelogDB->add(cronlogDB::BUCKET_DAY, $message,round(microtime(true), 4)-$timeStart);
		}elseif (!file_exists($weekPath)) {
			@ignore_user_abort(true);
			$files = glob( $cronPath.'week-*' );
			if (is_array($files)){array_map("unlink",$files);}					

			file_put_contents($weekPath, ' ');
			
			$message = self::week();
			$cronelogDB->add(cronlogDB::BUCKET_WEEK, $message,round(microtime(true), 4)-$timeStart);
			router::reload(null,null,true);
		}elseif (!file_exists($monthPath)) {
			@ignore_user_abort(true);
			$files = glob( $cronPath.'month-*' );
			if (is_array($files)){array_map("unlink",$files);}					
	
			file_put_contents($monthPath, ' ');		
			
			$message = self::month();
			$cronelogDB->add(cronlogDB::BUCKET_MONTH, $message,round(microtime(true), 4)-$timeStart);
		}						
	}
	
	private static function hour() {
		if (config::get('hour_move_acceslogs')!=='0') {
			$message[] = accesslogFileDB::moveLogsToDatabase();
		}
		if (config::get('hour_rss_update')!=='0' and license::hasPro()) {
			$message[] = rss::addAllActualFeeds();
		}	
		if (config::get('hour_mailing_send')!=='0' and license::hasPro()) {
			$message[] = adminMailingDoController::sendAllActiveMailings();
		}		
		$message = self::runPluginsCronTasks('hour',$message);	

		return serialize($message);
	}	
	private static function day() {
		if (config::get('day_write_system_status')!=='0') {$message[] = systemStatus::writeTodayStatus(HOME);}
		if (config::get('day_clean_firewall')!=='0') {$message[] = firewall::cleanOldFilesDay();}
		
		if (config::get('sitemap') and config::get('day_sitemap')!=='0') {
			$sitemap = seo::sitemap();
			baseFile::saveFile(__SITE_PATH.'/sitemap.xml', $sitemap);
			$message[] = 'core.cron.class.newsite';
		}	
		$message = self::runPluginsCronTasks('day',$message);	
		return serialize($message);
	}
	private static function week() {
		if (config::get('week_compact_versions')!=='0') {$message[] = pagesbackupsDB::compactAllPagesVersions();}		
		
		if (config::get('week_flush_cache')!=='0') {
			cache::flushAllCache();
			$message[] = 'core.cron.class.allcache';
		}
		if (config::get('week_delete_old_requestlogs')!=='0') {
			$accesslogDB = new accesslogDB();
			$accesslogDB->clean(time()-3600*24*90);
			$message[] = 'core.cron.class.oldrequest';
		}
		if (config::get('week_delete_old_logs')!=='0') {
			$logsDB = new logDB();
			$logsDB->clean(time()-3600*24*90);
			$message[] = 'core.cron.class.oldlogs';
		}	
		$message = self::runPluginsCronTasks('week',$message);
		return serialize($message);
	}
	private static function month() {
		if (config::get('month_clean_firewall')!=='0') {$message[] = firewall::cleanOldFilesMonth();}
		if (config::get('month_vacum')!=='0') {$message[] = baseDB::vacuum();}
		
		if (config::get('month_delete_thumbs')!=='0') {
			image::deleteImageThumbsAll();
			cache::flushAllCache();
			$message[] = 'core.cron.class.images';	
		}
		if (config::get('month_backup')!=='0' and license::hasPro()) {
			$backupBD = new backupDB();
			$message[] = $backupBD->backupAll();
		}
		if (config::get('month_clean_backups')!=='0' and license::hasPro()) {
			$backupBD = new backupDB();
			$message[] = $backupBD->cleanOldBackups();
		}
		$message = self::runPluginsCronTasks('month',$message);
		return serialize($message);
	}

	private static function runPluginsCronTasks($type,$message) {
		foreach (pluginManager::getList() as $plugin){
			$cronFilePath = __SITE_PATH.'/app/plugins/'.$plugin.'/cron/'.$type.'.class.php';
			if (file_exists($cronFilePath)){
				require_once $cronFilePath;
				$className = 'cron'.ucfirst($plugin).ucfirst($type);
				$cronClass = new $className;
				$message[] = $cronClass->run();
			}
		}
		return $message;
	}
}
?>