<?php /*windu.org core*/
class generate
{
    public static function sqlDatetime($timestemp = null)
	{
		if(is_null($timestemp)){$timestemp = @strtotime('now');}
	    $time = @date('Y-m-d H:i:s',$timestemp);
	    return $time; 
	}
	public static function sqlDate($timestemp = null) {
		if(is_null($timestemp)){$timestemp = strtotime('now');}
	    $time = date('Y-m-d',$timestemp);
	    return $time; 
	}
	public static function showDatatime($datatime, $addDecorators = true, $onlyStringShow = false) {
		$time = date('d.m.Y H:i',strtotime($datatime));
		$now = strtotime('now');
		$nowDiff = $now - strtotime($datatime);
		
		if ($addDecorators) {
			if ($nowDiff<=60) {
				$timeAddon = '<span class="badge badge-important transparent-md">'.$nowDiff.' s</span>';
			}elseif ($nowDiff<=3600){
				$timeAddon = '<span class="badge badge-warning transparent-md">'.intval(($nowDiff/60)).' min</span>';
			}elseif ($nowDiff<=(24*3600)){
				$timeAddon = '<span class="badge badge-info transparent-md">'.intval(($nowDiff/(3600))).' h</span>';
			}else{
				$timeAddon = '<span class="badge">'.intval(($nowDiff/(24*3600))).' d</span>';
			}
			
			$time = explode(' ',$time);
			if ($onlyStringShow) {
				$time = '<span class="silver">'.$timeAddon.'</span> ';
			}else{
				$time = $time[0].' <span class="silver">'.$time[1].' '.$timeAddon.'</span> ';
			}
	
		}
		return $time; 
	}
    public static function showDate($datatime) {
		$time = date('d.m.Y',strtotime($datatime));
	    return $time; 
	}	
	public static function ip(){
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];} 
		else {$ip = $_SERVER['REMOTE_ADDR'];} 

		return $ip; 
	}		
	public static function randomCode($length=8,$level=3){
	   list($usec, $sec) = explode(' ', microtime());
	   srand((float) $sec + ((float) $usec * 100000));
	
	   $validchars[1] = "0123456789";
	   $validchars[2] = "abcdfghjkmnpqrstvwxyz";
	   $validchars[3] = "0123456789abcdfghjkmnpqrstvwxyz";
	   $validchars[4] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	   $validchars[5] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";
	
	   $code  = "";
	   $counter = 0;
	
	   while ($counter < $length)
	   {
	     $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level])-1), 1);
	     $code .= $actChar;
	     $counter++;
	   }
	   return $code;	
	}
	public static function ekey($table,$colum = 'ekey',$length=12,$level=2){
		$db = new $table();
		$ekey = null;
	
		while ($db->fetchCount("{$colum}='{$ekey}'") > 0 or $ekey == null) {
			$ekey = self::randomCode($length,$level);
		}
		return $ekey;
	}

	public static function urlKey($baseString,$table,$colum = 'urlKey',$length=50){
		$db = new $table();
		$forbiddenValues=array('admin','do','order','payment');

		$urlKeyWork = self::prepareUrlKey($baseString);
		$counter = 0;
	
		while ($db->fetchRow("{$colum} = '{$urlKeyWork}'") != null or in_array($urlKeyWork, $forbiddenValues)) {
			$addonLenght = 1;
			$counter = $counter+1;
			
			if($counter>=12){
				$addonLenght=$addonLenght+1;
				$counter=0;
			}
			$urlKeyWork =$urlKeyWork.'-'.self::randomCode($addonLenght,1);
		}
		$urlKeyWork = substr($urlKeyWork, 0, $length);
		$urlKeyWork = rtrim($urlKeyWork,'-');
		return $urlKeyWork;
	}	
	public static function prepareUrlKey($baseString){
		$urlKey = self::clean($baseString);
		$urlKey = strtolower($urlKey);
		
		if ($urlKey==null) {
			$urlKey=self::randomCode(12,2);
		}
		$urlKeyWork = str_replace(' ', '-', $urlKey);
		$urlKeyWork = str_replace('.', '-', $urlKeyWork);
		$urlKeyWork = str_replace(',', '-', $urlKeyWork);
		$urlKeyWork = str_replace('@', '-', $urlKeyWork);
		$urlKeyWork = str_replace('---', '-', $urlKeyWork);
		$urlKeyWork = str_replace('--', '-', $urlKeyWork);
		
		return $urlKeyWork;
	}

	public static function replaceChars($data) {
		$needles = array("ó", "ą", "ę", "ś", "ć", "ń", "ż", "ź", "ł", "Ó", "Ą", "Ę", "Ś", "Ć", "Ń", "Ż", "Ź", "Ł");
		$replace = array("o", "a", "e", "s", "c", "n", "z", "z", "l", "O", "A", "E", "S", "C", "N", "Z", "Z", "L");
		$data = str_replace($needles,$replace,$data);
		return $data;
	}	
	public static function clean($data) {
		$data = self::replaceChars($data);
		$data =  preg_replace("/([^a-zA-Z0-9\ \.\-\_])/i","", $data);
		return trim($data," ,;");
	}
    public static function cleanUrl($data) {
        $data = self::replaceChars($data);
        $data =  preg_replace("/([^a-zA-Z0-9\ \.\-\_\&\?\=\/])/i","", $data);
        return trim($data," ,;");
    }
	public static function cleanFileName($data) {
		$data = self::replaceChars($data);
		$data = str_replace(' ', '_', $data);
		$data = preg_replace("/([^a-zA-Z0-9\.\_\-])/i","", $data);
		$data = strtolower($data);
		return trim($data," ,;");
	}
	public static function cleanLinkKey($data) {
		$data = self::replaceChars($data);
		$data = str_replace(' ', '-', $data);
		$data = preg_replace("/([^a-zA-Z0-9\.\_\-\,])/i","", $data);
		$data = strtolower($data);
		return trim($data," ,;");
	}
	public static function cleanClassName($data) {
		$data = self::replaceChars($data);
		$data =  preg_replace("/([^a-zA-Z0-9])/i","", $data);
		
		return trim($data," ,;");
	}
	public static function cleanSQLColumnName($data) {
		$data = self::replaceChars($data);
		$data =  preg_replace("/([^a-zA-Z0-9\_])/i","", $data);
		
		return trim($data," ,;");
	}	
	public static function cleanMessageKey($data) {
		$data = self::replaceChars($data);
		$data =  preg_replace("/([^a-zA-Z0-9\.])/i","", $data);
		return trim($data," ,;");
	}
	public static function prepareGet($value) {
		$value = self::clean($value);
		$value = addslashes($value); 
		return $value;
	}	
	public static function sqlInjesctionStringSecure($value) {
		$value = addslashes($value); 
		return $value;
	}	
	public static function subvalArraySort($a,$subkey,$sort = 'asort') {
		$c = array();
		if (is_array($a)) {
			foreach($a as $k=>$v) {
				$b[$k] = strtolower($v[$subkey]);
			}
			$sort($b);
			foreach($b as $key=>$val) {
				$c[$key] = $a[$key];
			}
		}
		return $c;
	}
	public static function subvalArrayObjectsSort($a,$subkey,$sort = 'asort',$dataTime = FALSE) {
		foreach($a as $k=>$v) {
			$b[$k] = strtolower($v->$subkey);
			if ($dataTime) {
				$b[$k] = strtotime($b[$k]);
			}
		}
		$sort($b);
		foreach($b as $key=>$val) {
			$c[$key] = $a[$key];
		}
		return $c;
	}
			
	public static function compressCSS($css){
		return str_replace('; ',';',str_replace(' }','}',str_replace('{ ','{',str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),"",preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!','',$css)))));
	}
    //TODO
    public static function compressJS($js){
        return $js;
    }
	public static function clearHtml($data){
		$data = strip_tags($data); 
		return $data;
	}
	public static function clearHtmlNl2Br($data) {
		$data = self::clearHtml($data);
		$data = nl2br($data);

		return $data;		
	}
	public static function returnBytes($val) {
	    $val = trim($val);
	    $last = strtolower($val[strlen($val)-1]);
	    switch($last) {
	        case 'g':
	            $val *= 1024;
	        case 'm':
	            $val *= 1024;
	        case 'k':
	            $val *= 1024;
	    }
	    return $val;
	}	
	public static function getColorsOption() {
	    $cs = array('00', '33', '66', '99', 'CC', 'FF');
	
	    for($i=0; $i<6; $i++) {
	        for($j=0; $j<6; $j++) {
	            for($k=0; $k<6; $k++) {
	                $c = $cs[$i] .$cs[$j] .$cs[$k];
	                $finalArray[] = $c;
	            }
	        }
	    }
	    return $finalArray;
	}
	public static function migrateSQLiteToMySQL($sourceFile,$targetFile,$optionalTableName = '') {
		$sqlite = baseFile::readFile($sourceFile);
		$search  = array('AUTOINCREMENT' ,'DEFAULT CURRENT_TIMESTAMP','DEFAULT (CURRENT_TIMESTAMP)',"'",'"','varchar','null','VARCHAR ','VARCHAR,',     '(NULL)','(`0000-00-00 00:00:00`)','`0000-00-00 00:00:00`','VARCHAR,)',    "VARCHAR)","`,`",",`","`)","`,","(`","from VARCHAR(255)"," lock INTEGER","return VARCHAR(255)"   		,"VARCHAR DEFAULT (0)","datetime DEFAULT NULL",'datatime','NOT NULL','INTEGER PRIMARY KEY ,');
		$replace = array('AUTO_INCREMENT','','',  "`",'' ,'VARCHAR','NULL','VARCHAR(255) ','VARCHAR(255),','NULL',  '',       ''   ,'VARCHAR(255))',"VARCHAR(255))","','",",'","')","',","('","`from` VARCHAR(255)"," `lock` INTEGER","`return` VARCHAR(255)","VARCHAR(255) DEFAULT 0","datetime DEFAULT NULL",'datetime ','','INTEGER PRIMARY KEY AUTO_INCREMENT ,');
		$finalString = str_replace($search, $replace, $sqlite);

		$search  = array('DEFAULT ,','DEFAULT  ,','DEFAULT (0)','DEFAULT,');
		$replace = array(',',',','DEFAULT 0',',');
		$finalString2 = str_replace($search, $replace, $finalString);		
		
		if ($optionalTableName!='') {
			$search  = array('DROP TABLE IF EXISTS ','CREATE TABLE ');
			$replace = array('DROP TABLE IF EXISTS '.$optionalTableName.'.','CREATE TABLE '.$optionalTableName.'.');
			$finalString3 = str_replace($search, $replace, $finalString2);
		}

		baseFile::saveFile($targetFile, $finalString3);
	}
	//add empty rows for charts
	public static function appendChartArrayEmptyRows($objectToAppend,$datatimeKey,$valueKey,$dateDiv,$limit = 0,$defaultValue = 0){
		$cacheKey = md5(serialize($objectToAppend));
		if (cache::fileIsCached('generator', $cacheKey)) {
			return cache::fileRead('generator', $cacheKey);
		}else{
			$oldDivResult = 0;
			foreach ($objectToAppend as $row){
				$actualDivResult = floor(strtotime($row->$datatimeKey)/$dateDiv);
				if ($oldDivResult!=0){
					$subtractionResoult = $actualDivResult-$oldDivResult;
	
					if ($subtractionResoult>1) {
						for ($i = 1; $i < $subtractionResoult; $i++) {
							$newEmptyObject = new stdClass(); 
							$newEmptyObject->$datatimeKey = generate::sqlDatetime(($oldDivResult+$i)*$dateDiv);
							$newEmptyObject->$valueKey = $defaultValue;
							$finalArray[] = $newEmptyObject;
						}
					}
				}	
				$oldDivResult = $actualDivResult;
				$finalArray[] = $row;
	
			}
			if ($limit!=0) {
				$finalArray = array_slice($finalArray,-$limit);
			}
			cache::fileWrite('generator', $cacheKey, $finalArray);
		}	
		
		return $finalArray;
	}
	public static function languagesArray(){
		return array(
				'aa' => 'Afar',
				'ab' => 'Abkhaz',
				'ae' => 'Avestan',
				'af' => 'Afrikaans',
				'ak' => 'Akan',
				'am' => 'Amharic',
				'an' => 'Aragonese',
				'ar' => 'Arabic',
				'as' => 'Assamese',
				'av' => 'Avaric',
				'ay' => 'Aymara',
				'az' => 'Azerbaijani',
				'ba' => 'Bashkir',
				'be' => 'Belarusian',
				'bg' => 'Bulgarian',
				'bh' => 'Bihari',
				'bi' => 'Bislama',
				'bm' => 'Bambara',
				'bn' => 'Bengali',
				'bo' => 'Tibetan Standard, Tibetan, Central',
				'br' => 'Breton',
				'bs' => 'Bosnian',
				'ca' => 'Catalan; Valencian',
				'ce' => 'Chechen',
				'ch' => 'Chamorro',
				'co' => 'Corsican',
				'cr' => 'Cree',
				'cs' => 'Czech',
				'cu' => 'Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic',
				'cv' => 'Chuvash',
				'cy' => 'Welsh',
				'da' => 'Danish',
				'de' => 'German',
				'dv' => 'Divehi; Dhivehi; Maldivian;',
				'dz' => 'Dzongkha',
				'ee' => 'Ewe',
				'el' => 'Greek, Modern',
				'en' => 'English',
				'eo' => 'Esperanto',
				'es' => 'Spanish; Castilian',
				'et' => 'Estonian',
				'eu' => 'Basque',
				'fa' => 'Persian',
				'ff' => 'Fula; Fulah; Pulaar; Pular',
				'fi' => 'Finnish',
				'fj' => 'Fijian',
				'fo' => 'Faroese',
				'fr' => 'French',
				'fy' => 'Western Frisian',
				'ga' => 'Irish',
				'gd' => 'Scottish Gaelic; Gaelic',
				'gl' => 'Galician',
				'gn' => 'GuaranÃ­',
				'gu' => 'Gujarati',
				'gv' => 'Manx',
				'ha' => 'Hausa',
				'he' => 'Hebrew (modern)',
				'hi' => 'Hindi',
				'ho' => 'Hiri Motu',
				'hr' => 'Croatian',
				'ht' => 'Haitian; Haitian Creole',
				'hu' => 'Hungarian',
				'hy' => 'Armenian',
				'hz' => 'Herero',
				'ia' => 'Interlingua',
				'id' => 'Indonesian',
				'ie' => 'Interlingue',
				'ig' => 'Igbo',
				'ii' => 'Nuosu',
				'ik' => 'Inupiaq',
				'io' => 'Ido',
				'is' => 'Icelandic',
				'it' => 'Italian',
				'iu' => 'Inuktitut',
				'ja' => 'Japanese (ja)',
				'jv' => 'Javanese (jv)',
				'ka' => 'Georgian',
				'kg' => 'Kongo',
				'ki' => 'Kikuyu, Gikuyu',
				'kj' => 'Kwanyama, Kuanyama',
				'kk' => 'Kazakh',
				'kl' => 'Kalaallisut, Greenlandic',
				'km' => 'Khmer',
				'kn' => 'Kannada',
				'ko' => 'Korean',
				'kr' => 'Kanuri',
				'ks' => 'Kashmiri',
				'ku' => 'Kurdish',
				'kv' => 'Komi',
				'kw' => 'Cornish',
				'ky' => 'Kirghiz, Kyrgyz',
				'la' => 'Latin',
				'lb' => 'Luxembourgish, Letzeburgesch',
				'lg' => 'Luganda',
				'li' => 'Limburgish, Limburgan, Limburger',
				'ln' => 'Lingala',
				'lo' => 'Lao',
				'lt' => 'Lithuanian',
				'lu' => 'Luba-Katanga',
				'lv' => 'Latvian',
				'mg' => 'Malagasy',
				'mh' => 'Marshallese',
				'mi' => 'Maori',
				'mk' => 'Macedonian',
				'ml' => 'Malayalam',
				'mn' => 'Mongolian',
				'mr' => 'Marathi (Mara?hi)',
				'ms' => 'Malay',
				'mt' => 'Maltese',
				'my' => 'Burmese',
				'na' => 'Nauru',
				'nb' => 'Norwegian BokmÃ¥l',
				'nd' => 'North Ndebele',
				'ne' => 'Nepali',
				'ng' => 'Ndonga',
				'nl' => 'Dutch',
				'nn' => 'Norwegian Nynorsk',
				'no' => 'Norwegian',
				'nr' => 'South Ndebele',
				'nv' => 'Navajo, Navaho',
				'ny' => 'Chichewa; Chewa; Nyanja',
				'oc' => 'Occitan',
				'oj' => 'Ojibwe, Ojibwa',
				'om' => 'Oromo',
				'or' => 'Oriya',
				'os' => 'Ossetian, Ossetic',
				'pa' => 'Panjabi, Punjabi',
				'pi' => 'Pali',
				'pl' => 'Polish',
				'ps' => 'Pashto, Pushto',
				'pt' => 'Portuguese',
				'qu' => 'Quechua',
				'rm' => 'Romansh',
				'rn' => 'Kirundi',
				'ro' => 'Romanian, Moldavian, Moldovan',
				'ru' => 'Russian',
				'rw' => 'Kinyarwanda',
				'sa' => 'Sanskrit (Sa?sk?ta)',
				'sc' => 'Sardinian',
				'sd' => 'Sindhi',
				'se' => 'Northern Sami',
				'sg' => 'Sango',
				'si' => 'Sinhala, Sinhalese',
				'sk' => 'Slovak',
				'sl' => 'Slovene',
				'sm' => 'Samoan',
				'sn' => 'Shona',
				'so' => 'Somali',
				'sq' => 'Albanian',
				'sr' => 'Serbian',
				'ss' => 'Swati',
				'st' => 'Southern Sotho',
				'su' => 'Sundanese',
				'sv' => 'Swedish',
				'sw' => 'Swahili',
				'ta' => 'Tamil',
				'te' => 'Telugu',
				'tg' => 'Tajik',
				'th' => 'Thai',
				'ti' => 'Tigrinya',
				'tk' => 'Turkmen',
				'tl' => 'Tagalog',
				'tn' => 'Tswana',
				'to' => 'Tonga (Tonga Islands)',
				'tr' => 'Turkish',
				'ts' => 'Tsonga',
				'tt' => 'Tatar',
				'tw' => 'Twi',
				'ty' => 'Tahitian',
				'ug' => 'Uighur, Uyghur',
				'uk' => 'Ukrainian',
				'ur' => 'Urdu',
				'uz' => 'Uzbek',
				've' => 'Venda',
				'vi' => 'Vietnamese',
				'vo' => 'VolapÃ¼k',
				'wa' => 'Walloon',
				'wo' => 'Wolof',
				'xh' => 'Xhosa',
				'yi' => 'Yiddish',
				'yo' => 'Yoruba',
				'za' => 'Zhuang, Chuang',
				'zh' => 'Chinese',
				'zu' => 'Zulu',
		);		
	}
	public static function timezonesArray() {
		return array(
				"Pacific/Midway"=>"(GMT-11:00) Midway Island, Samoa",
				"America/Adak"=>"(GMT-10:00) Hawaii-Aleutian",
				"Etc/GMT+10"=>"(GMT-10:00) Hawaii",
				"Pacific/Marquesas"=>"(GMT-09:30) Marquesas Islands",
				"Pacific/Gambier"=>"(GMT-09:00) Gambier Islands",
				"America/Anchorage"=>"(GMT-09:00) Alaska",
				"America/Ensenada"=>"(GMT-08:00) Tijuana, Baja California",
				"Etc/GMT+8"=>"(GMT-08:00) Pitcairn Islands",
				"America/Los_Angeles"=>"(GMT-08:00) Pacific Time (US & Canada)",
				"America/Denver"=>"(GMT-07:00) Mountain Time (US & Canada)",
				"America/Chihuahua"=>"(GMT-07:00) Chihuahua, La Paz, Mazatlan",
				"America/Dawson_Creek"=>"(GMT-07:00) Arizona",
				"America/Belize"=>"(GMT-06:00) Saskatchewan, Central America",
				"America/Cancun"=>"(GMT-06:00) Guadalajara, Mexico City, Monterrey",
				"Chile/EasterIsland"=>"(GMT-06:00) Easter Island",
				"America/Chicago"=>"(GMT-06:00) Central Time (US & Canada)",
				"America/New_York"=>"(GMT-05:00) Eastern Time (US & Canada)",
				"America/Havana"=>"(GMT-05:00) Cuba",
				"America/Bogota"=>"(GMT-05:00) Bogota, Lima, Quito, Rio Branco",
				"America/Caracas"=>"(GMT-04:30) Caracas",
				"America/Santiago"=>"(GMT-04:00) Santiago",
				"America/La_Paz"=>"(GMT-04:00) La Paz",
				"Atlantic/Stanley"=>"(GMT-04:00) Faukland Islands",
				"America/Campo_Grande"=>"(GMT-04:00) Brazil",
				"America/Goose_Bay"=>"(GMT-04:00) Atlantic Time (Goose Bay)",
				"America/Glace_Bay"=>"(GMT-04:00) Atlantic Time (Canada)",
				"America/St_Johns"=>"(GMT-03:30) Newfoundland",
				"America/Araguaina"=>"(GMT-03:00) UTC-3",
				"America/Montevideo"=>"(GMT-03:00) Montevideo",
				"America/Miquelon"=>"(GMT-03:00) Miquelon, St. Pierre",
				"America/Godthab"=>"(GMT-03:00) Greenland",
				"America/Argentina/Buenos_Aires"=>"(GMT-03:00) Buenos Aires",
				"America/Sao_Paulo"=>"(GMT-03:00) Brasilia",
				"America/Noronha"=>"(GMT-02:00) Mid-Atlantic",
				"Atlantic/Cape_Verde"=>"(GMT-01:00) Cape Verde Is.",
				"Atlantic/Azores"=>"(GMT-01:00) Azores",
				"Europe/Belfast"=>"(GMT) Greenwich Mean Time : Belfast",
				"Europe/Dublin"=>"(GMT) Greenwich Mean Time : Dublin",
				"Europe/Lisbon"=>"(GMT) Greenwich Mean Time : Lisbon",
				"Europe/London"=>"(GMT) Greenwich Mean Time : London",
				"Africa/Abidjan"=>"(GMT) Monrovia, Reykjavik",
				"Europe/Amsterdam"=>"(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna, Warsaw",
				"Europe/Belgrade"=>"(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague",
				"Europe/Brussels"=>"(GMT+01:00) Brussels, Copenhagen, Madrid, Paris",
				"Africa/Algiers"=>"(GMT+01:00) West Central Africa",
				"Africa/Windhoek"=>"(GMT+01:00) Windhoek",
				"Asia/Beirut"=>"(GMT+02:00) Beirut",
				"Africa/Cairo"=>"(GMT+02:00) Cairo",
				"Asia/Gaza"=>"(GMT+02:00) Gaza",
				"Africa/Blantyre"=>"(GMT+02:00) Harare, Pretoria",
				"Asia/Jerusalem"=>"(GMT+02:00) Jerusalem",
				"Europe/Minsk"=>"(GMT+02:00) Minsk",
				"Asia/Damascus"=>"(GMT+02:00) Syria",
				"Europe/Moscow"=>"(GMT+03:00) Moscow, St. Petersburg, Volgograd",
				"Africa/Addis_Ababa"=>"(GMT+03:00) Nairobi",
				"Asia/Tehran"=>"(GMT+03:30) Tehran",
				"Asia/Dubai"=>"(GMT+04:00) Abu Dhabi, Muscat",
				"Asia/Yerevan"=>"(GMT+04:00) Yerevan",
				"Asia/Kabul"=>"(GMT+04:30) Kabul",
				"Asia/Yekaterinburg"=>"(GMT+05:00) Ekaterinburg",
				"Asia/Tashkent"=>"(GMT+05:00) Tashkent",
				"Asia/Kolkata"=>"(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi",
				"Asia/Katmandu"=>"(GMT+05:45) Kathmandu",
				"Asia/Dhaka"=>"(GMT+06:00) Astana, Dhaka",
				"Asia/Novosibirsk"=>"(GMT+06:00) Novosibirsk",
				"Asia/Rangoon"=>"(GMT+06:30) Yangon (Rangoon)",
				"Asia/Bangkok"=>"(GMT+07:00) Bangkok, Hanoi, Jakarta",
				"Asia/Krasnoyarsk"=>"(GMT+07:00) Krasnoyarsk",
				"Asia/Hong_Kong"=>"(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi",
				"Asia/Irkutsk"=>"(GMT+08:00) Irkutsk, Ulaan Bataar",
				"Australia/Perth"=>"(GMT+08:00) Perth",
				"Australia/Eucla"=>"(GMT+08:45) Eucla",
				"Asia/Tokyo"=>"(GMT+09:00) Osaka, Sapporo, Tokyo",
				"Asia/Seoul"=>"(GMT+09:00) Seoul",
				"Asia/Yakutsk"=>"(GMT+09:00) Yakutsk",
				"Australia/Adelaide"=>"(GMT+09:30) Adelaide",
				"Australia/Darwin"=>"(GMT+09:30) Darwin",
				"Australia/Brisbane"=>"(GMT+10:00) Brisbane",
				"Australia/Hobart"=>"(GMT+10:00) Hobart",
				"Asia/Vladivostok"=>"(GMT+10:00) Vladivostok",
				"Australia/Lord_Howe"=>"(GMT+10:30) Lord Howe Island",
				"Etc/GMT-11"=>"(GMT+11:00) Solomon Is., New Caledonia",
				"Asia/Magadan"=>"(GMT+11:00) Magadan",
				"Pacific/Norfolk"=>"(GMT+11:30) Norfolk Island",
				"Asia/Anadyr"=>"(GMT+12:00) Anadyr, Kamchatka",
				"Pacific/Auckland"=>"(GMT+12:00) Auckland, Wellington",
				"Etc/GMT-12"=>"(GMT+12:00) Fiji, Kamchatka, Marshall Is.",
				"Pacific/Chatham"=>"(GMT+12:45) Chatham Islands",
				"Pacific/Tongatapu"=>"(GMT+13:00) Nuku'alofa",
				"Pacific/Kiritimati"=>"(GMT+14:00) Kiritimati");
	}
}
?>