<?php /*windu.org rss*/
class rss
{
	public static function read($url){
		$feedString = externalContent::get($url);
		$feedXml = xml::xml2array($feedString);
		return $feedXml['rss']['channel'];
    }  
    public static function addContent(array $feedLine, $parentId, $author, $type = pagesDB::TYPE_NEWS) {
		$data['name'] = $feedLine['title'];
		$data['content'] = $feedLine['description'];
		$data['rssSource'] = $feedLine['link'];
		$data['date'] = generate::sqlDatetime();
		
    	$pagesDB = new pagesDB();
		$data = array_merge($data,array('parentId'=>$parentId,'type' => $type));
		$pagesDB->insert($data);
    }
    public static function addAllActualFeeds($type = pagesDB::TYPE_NEWS) {
    	$feedsUrls = unserialize(config::get('rssUrls'));
    	$parentId = config::get('rssParentId');
    	
    	if (is_array($feedsUrls)) {
    		$lastCheckDate = config::get('rssLastCheckDate');
	    	foreach ($feedsUrls as $url){
	    		$url = explode('|', $url);
	    		$feedArray = self::read($url[0]);
	    		foreach ($feedArray['item'] as $feedLine){
	    			if (strtotime($lastCheckDate) < strtotime($feedLine['pubDate'])) {
	    				if ($url[1]==null) {
	    					$parentId = config::get('rssParentId');
	    				}else{
	    					$parentId = $url[1];
	    				}
	    				self::addContent($feedLine, $parentId, $author, $type);
	    			}
	    		}
	    	}
	    	$date = generate::sqlDate();
	    	config::set('rssLastCheckDate',$date);
	    	return 'rss.class.update_'.$date;
    	}
	   	return 'rss.class.empty';
    }    
}
?>
