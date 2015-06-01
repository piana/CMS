<?php
	class core {

		var $pattern;
		var $language;
		var $stack = array(0 => array(), 1 => array());

		public function __construct() {
			//Set LCMS language
			$this->language = $this->loadLanguage(@$_GET['lang']);
			//Load LCMS definitions
			require_once('inc/engine/defines.php');
			//Load LCMS modules
			$this->loadModules();
			//Load LCMS content
			$this->showPattern();
		}

		//Load Language
		private function loadLanguage($get) {
		    $globArray = glob('inc/lang/'.htmlspecialchars($get).'_*');
			if(!isset($get) || empty($get) || empty($globArray)) {
				return $this->getSettings('site_lang');
			} else {
				$dir = explode('/', current($globArray));
				return end($dir);
			}
		} //End loadLanguage();

		//Load Modules
		private function loadModules() {
			global $lang, $db, $core;
			$core = $this; $lang = array();

			$query = $db->select('modules');
		    foreach ($query as $module)
			{
				if(file_exists(MODULES.$module['dir'].'/'.$module['dir'].'.site.php')) {
			    	require_once(MODULES.$module['dir'].'/'.$module['dir'].'.site.php');
				}
			}
		} //End loadModules();

		//Load Pattern
		public function loadPattern($tpl) {
			$theme = $this->getSettings('theme');
			$tpl = THEMES.$theme.'/'.$tpl;
			if(file_exists($tpl)) {
				$pattern = file_get_contents($tpl);
				$strpos = strpos($pattern, '{{lcms.footer}}');
				if($strpos===false) $pattern = 'LCMS footer is missing';
				return $pattern;
			} else echo "Template file not found!";
		} //End loadPattern();

		//Get settings from DB
		public function getSettings($what) {
			global $db;

			$query = $db->select('settings',array('field'=>$what));
			$result = $query[0];
			return $result['value'];
		} //End getSettings();

		//Add replaces to stack
		public function replace($search, $replacement) {
				array_push($this->stack[0], '/'.$search.'/D');
				array_push($this->stack[1], $replacement);
		} //End replace();

		//Replace theme's pattern
		private function showPattern() {
			$this->stack[1] = preg_replace($this->stack[0], $this->stack[1], $this->stack[1]);
			$this->pattern = preg_replace($this->stack[0], $this->stack[1], $this->pattern);
			echo $this->pattern;
		} //End replaces();

		//Add something inside HTML <$tag $extra>
		public function append($replacement, $tag, $extra = NULL) {
			if($extra) $extra = addslashes(' '.$extra);
			$this->pattern = preg_replace('/(<'.$tag.$extra.'>)(.*?)(<\/'.$tag.'>)/s', '$1$2'.$replacement."\n".'$3', $this->pattern);
		} //End append();

	}
?>