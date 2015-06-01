<?php /*windu.org core*/
class systemStatus
{
    public static function writeTodayStatus($url) {
		if(config::getSystemRun("monitoring")){
			$systemStatusDB = new systemStatusDB();
			if(!$systemStatusDB->haveTodayStatus()){
				$actualStatus = self::generate($url);
				$systemStatusDB->addStatus($actualStatus);			
			}
			return lang::read('system.status.class.status') .date('Y-m-d',strtotime('now'));
		}
	}
	public static function generate($url) {
		//database status
		$status['images'] = baseDB::getRecordsCount('imagesDB');
		$status['files'] = baseDB::getRecordsCount('filesDB');
		$status['sendedEmails'] = baseDB::getRecordsCount('mailDB');
		$status['contacts'] = baseDB::getRecordsCount('contactDB');
		$status['pages'] = baseDB::getRecordsCount('pagesDB');
		$status['comments'] = baseDB::getRecordsCount('commentsDB');
		$status['rates'] = baseDB::getRecordsCount('ratesDB');
		
		$status['forumTopics'] = baseDB::getRecordsCount('forumTopicsDB');
		$status['forumPosts'] = baseDB::getRecordsCount('forumPostsDB');
		
		$status['versions'] = baseDB::getRecordsCount('pagesbackupsDB');

		$logDB = new logDB();
		$status['logErrors'] = $logDB->fetchCount("bucket=".logDB::BUCKET_ERROR);
		$status['log404'] = $logDB->fetchCount("bucket=".logDB::BUCKET_404);
		
		
		$status['users'] = baseDB::getRecordsCount('usersDB');
		
		//system status
		$status['revision'] = config::get('revision');
		$status['size'] = self::pageSize();
		
		//external google status
		if (config::getSystemRun('monitoringGoogle')) {
			$status['googlePr'] = seo::googlePr($url);
			$status['googlePageSpeed'] = self::googlePageSpeed($url);
		}
		
		//external alexa status
		if (config::getSystemRun('monitoringAlexa')){
			$status['alexaCountryRank'] = seo::alexaCountryRank($url);
			$status['alexaGlobalRank'] = seo::alexaGlobalRank($url);
			$status['alexaLink'] = seo::alexaLink($url);
			$status['alexaSpeed'] = seo::alexaLink($url);
		}
		
		//Visit statistics
		if (config::getSystemRun("statistic")) {
			$accesslogDB = new accesslogDB();
		
			$status['pageViewsUniqueIP'] = count($accesslogDB->fetchCountGroup("ip","insertTime >= '".generate::sqlDate(strtotime("-1 day"))." 00:00:00' AND insertTime <= '".generate::sqlDate(strtotime("-1 day"))." 23:59:59'"));
			$status['pageViewsUniqueCookie'] =  baseDB::getRecordsCount('accesslogDB',"visitCookie = 0 AND insertTime >= '".generate::sqlDate(strtotime("-1 day"))." 00:00:00' AND insertTime <= '".generate::sqlDate(strtotime("-1 day"))." 23:59:59'");
			$status['pageViewsUniqueCookiesIP'] = count($accesslogDB->fetchCountGroup("ip","visitCookie = 0 AND insertTime >= '".generate::sqlDate(strtotime("-1 day"))." 00:00:00' AND insertTime <= '".generate::sqlDate(strtotime("-1 day"))." 23:59:59'"));
			$status['requests'] = baseDB::getRecordsCount('accesslogDB',"insertTime >= '".generate::sqlDate(strtotime("-1 day"))." 00:00:00' AND insertTime <= '".generate::sqlDate(strtotime("-1 day"))." 23:59:59'");
		}
		return $status;
	}
	
	public static function pageSize($expire = 7200){
		if (!cache::isCached(__SITE_PATH,$expire)){
			cache::write(__SITE_PATH,round(baseFile::getSize(__SITE_PATH)/1048576,2),'disSize');
		}
		return cache::read(__SITE_PATH);		
	}
	public static function googlePageSpeed($url) {
        $googleUrl  = 'http://developers.google.com/_apps/pagespeed/run_pagespeed?url='.$url.'&format=json';
        $str  = externalContent::get($googleUrl);

        $data = json_decode($str);
        return intval($data->results->score);
	}
}

?>
