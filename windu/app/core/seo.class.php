<?php /*windu.org core*/

class seo
{
	private static $alexaArray;
	
	public static function sitemap() {
		if (LANG_BY_DOMAIN!='') {
			$arrayPom = unserialize(LANG_BY_DOMAIN);
			if (is_array($arrayPom)){
				$langsArray = array_flip(unserialize(LANG_BY_DOMAIN));
			}
		}
		
		$pagesDB = new pagesDB();
		$pages = $pagesDB->fetchAll('status='.pagesDB::STATUS_ACTIVE);
		
		$sitemapContent = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
		$sitemapContent .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'."\n";
		foreach ($pages as $page){
			$sitemapContent .="<url>\n";	
			if (LANG_BY_DOMAIN!='' and $page->langId!=0 and $page->parentId!=0) {
				$sitemapContent .="<loc>http://".$langsArray[$page->langId].'/'.$page->urlKey."</loc>\n";	
			}elseif(LANG_BY_DOMAIN!='' and $page->parentId==0){
				$sitemapContent .="<loc>http://".$langsArray[$page->id]."</loc>\n";
			}else{	
				$sitemapContent .="<loc>".HOME.$page->urlKey."</loc>\n";	
			}
			$date = explode(' ',$page->updateTime);
			$sitemapContent .="<lastmod>".$date[0]."</lastmod>\n";
			if (is_numeric($page->priority)) {
				$sitemapContent .="<priority>".$page->priority."</priority>\n";	
			}
			$sitemapContent .="</url>\n";			
		}
		$sitemapContent .= '</urlset>';
		
		return $sitemapContent;
	}
	public static function googlePr($url) {
        $googleUrl  = 'http://toolbarqueries.google.com/tbr?features=Rank&sourceid=navclient-ff&client=navclient-auto-ff';
        $googleUrl .= '&googleip=O;66.249.81.104;104&ch='.self::CheckHash(self::HashURL($url)).'&q=info:'.urlencode($url);		

	    $data = externalContent::get($googleUrl);
    
	    return intval(trim(substr($data, 9)));
	}
    public static function prepareAlexa($url)
	{
		$str = externalContent::get('http://data.alexa.com/data?cli=10&dat=sbamz&url='.$url);
		$xml = xml::xml2array($str);
		
		if (!is_array(self::$alexaArray['url'])) {
			self::$alexaArray['url'] = $xml;
		}
    }	
    
    public static function alexaCountryRank($url)
	{
		self::prepareAlexa($url);
		$alexaArray = self::$alexaArray['url'];
		return intval($alexaArray['ALEXA']['SD'][1]['COUNTRY_attr']['RANK']);
    }
    public static function alexaGlobalRank($url)
	{
		self::prepareAlexa($url);
		$alexaArray = self::$alexaArray['url'];
		return intval($alexaArray['ALEXA']['SD'][1]['POPULARITY_attr']['TEXT']);
    }
    public static function alexaLink($url)
	{
		self::prepareAlexa($url);
		$alexaArray = self::$alexaArray['url'];
		return intval($alexaArray['ALEXA']['SD'][0]['LINKSIN_attr']['NUM']);
    }
    public static function alexaSpeed($url)
	{
		self::prepareAlexa($url);
		$alexaArray = self::$alexaArray['url'];
		return intval($alexaArray['ALEXA']['SD'][0]['SPEED_attr']['TEXT']);
    }
    
	public static function StrToNum($Str, $Check, $Magic)
	{
	    $Int32Unit = 4294967296;
	 
	    $length = strlen($Str);
	    for ($i = 0; $i < $length; $i++) {
	        $Check *= $Magic;
	        if ($Check >= $Int32Unit) {
	            $Check = ($Check - $Int32Unit * (int) ($Check / $Int32Unit));
	            $Check = ($Check < -2147483648) ? ($Check + $Int32Unit) : $Check;
	        }
	        $Check += ord($Str{$i});
	    }
	    return $Check;
	}
	
	//////////////////////////////////////////////////////////////////////////
	//HASH////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	public static function HashURL($String)
	{
	    $Check1 = self::StrToNum($String, 0x1505, 0x21);
	    $Check2 = self::StrToNum($String, 0, 0x1003F);
	 
	    $Check1 >>= 2;
	    $Check1 = (($Check1 >> 4) & 0x3FFFFC0 ) | ($Check1 & 0x3F);
	    $Check1 = (($Check1 >> 4) & 0x3FFC00 ) | ($Check1 & 0x3FF);
	    $Check1 = (($Check1 >> 4) & 0x3C000 ) | ($Check1 & 0x3FFF);
	 
	    $T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) <<2 ) | ($Check2 & 0xF0F );
	    $T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 & 0xF0F0000 );
	 
	    return ($T1 | $T2);
	}
	public static function CheckHash($Hashnum)
	{
	    $CheckByte = 0;
	    $Flag = 0;
	 
	    $HashStr = sprintf('%u', $Hashnum) ;
	    $length = strlen($HashStr);
	 
	    for ($i = $length - 1;  $i >= 0;  $i --) {
	        $Re = $HashStr{$i};
	        if (1 === ($Flag % 2)) {
	            $Re += $Re;
	            $Re = (int)($Re / 10) + ($Re % 10);
	        }
	        $CheckByte += $Re;
	        $Flag ++;
	    }
	 
	    $CheckByte %= 10;
	    if (0 !== $CheckByte) {
	        $CheckByte = 10 - $CheckByte;
	        if (1 === ($Flag % 2) ) {
	            if (1 === ($CheckByte % 2)) {
	                $CheckByte += 9;
	            }
	            $CheckByte >>= 1;
	        }
	    }
	 
	    return '7'.$CheckByte.$HashStr;
	}		
}
?>