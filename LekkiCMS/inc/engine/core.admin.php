<?php
	class core {

		var $pattern;
		var $language;
		var $stack = array(0 => array(), 1 => array());

		public function __construct() {
			//Set LCMS language
			$this->language = $this->getSettings('admin_lang');
			//Load LCMS definitions
			require_once('../inc/engine/defines.php');
			$this->pattern = $this->loadPattern();
			//Load LCMS modules
			$this->loadBasicModules();
			//Get LCMS module
			$this->getModule(@$_GET['go'], @$_GET['action']);
			//Create a navigation
			$this->createNavigation();
			//Add a notification
			$this->addNotify();
			//Logout
			$this->logout(@$_GET['logout']);
			//Load LCMS contnet
			$this->showPattern();
		}

		//Load Pattern
		private function loadPattern() {
			if(file_exists('../'.THEMES.'admin/template.html')) {
				return file_get_contents('../'.THEMES.'admin/template.html');
			} else echo "Template file not found!";
		} //End loadPattern();

		//Get settings from DB
		public function getSettings($what) {
			global $db;

			$query = $db->select('settings',array('field'=>$what));
			$result = $query[0];
			return $result['value'];
		} //End getSettings();

		//Load Basic Modules
		private function loadBasicModules() {
			global $lang, $db;
			$core = $this;
			
			if(is_dir('../'.MODULES.'_basic')) {
				foreach (glob('../'.MODULES.'_basic/*.php') as $filename)
					require_once($filename);
			}
		} //End loadModules();

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

		//Create admin navigation
		private function createNavigation() {
			global $db;

			$query = $db->select('modules');
			if($db->num_rows($query)>0) {
				$nav = '<ul>';
				foreach((array)$query as $module) {
					$moduleInfo = $this->getModuleInfo($module['dir']);
					if($moduleInfo['add2nav'] && $this->checkUserAllowed($module['dir'])) {
						$nav .= '<li><a href="?go='.$module['dir'].'" '.(@$_GET['go']==$module['dir']?'class="active"':'').'>'.$moduleInfo['name'].'</a></li>';
					}
				}
				$nav .= '</ul>';	
				$this->replace('{{navigation}}', $nav);
			}
		} //End createNavigation();

		//Get Module
		private function getModule($module, $function = NULL) {
			global $lang, $db, $core;
			$core = $this;

				if(!isset($module) || empty($module)) header('Location:index.php?go=pages');

				if(!empty($module)) { 
					$query = $db->select('modules', array('dir'=>$module));
					$file_info = '../'.MODULES.$module.'/'.$module.'.info.php';
					$file_admin = '../'.MODULES.$module.'/'.$module.'.admin.php';

					if(is_file($file_info) && is_file($file_admin) && $db->num_rows($query)>0 && $this->checkUserAllowed($module)) {
						//Get info and functions
						require_once($file_admin);
						require_once($file_info);
						$module_pages = call_user_func($module.'_pages');
						$module_info = call_user_func($module.'_info');
						$module_replace = array();

						if($function) {
							if(function_exists($function)) {
								$module_replace['current_page'] = NULL;
								foreach($module_pages as $i => $page) {
									if($page['func'] == $function) $module_replace['current_page'] = $page['title'];
								}
								if($module_replace['current_page']) $module_replace['content'] = $function();
								else exit;
							} else exit;
						}
						else {
							$page = reset($module_pages);
							$module_replace['content'] = $page['func']();
							$module_replace['current_page'] = $page['title'];
						}
						//Replace template by module
						$this->replace('{{module.name}}', $module_info['name'].'<span>'.$module_replace['current_page'].'</span>');
						$this->replace('{{module.content}}', $module_replace['content']);
						$this->replace('{{module.pages}}', $this->createModuleMenu($module_pages, $module));
					}
					else exit;		
				}
		} //End getModule();

		//Get Module Info - return: array or 0;
		public function getModuleInfo($dir) {
			global $lang;
			
			$file_info = '../'.MODULES.$dir.'/'.$dir.'.info.php';
			if(is_file($file_info)) {
				require_once($file_info);
				return call_user_func($dir.'_info');
			} else return 0;
		} //End getModuleInfo();

		//Create menu of module
		private function createModuleMenu(array $module_pages, $module_name) {
			$sidebar = '<ul>';
			foreach($module_pages as $i => $page) {
				$active = NULL;
				if(isset($_GET['action'])) {
					if($page['func'] == $_GET['action']) $active = 'class="active"';
				} else {
					if($i == 0) $active = 'class="active"';
				}
				$sidebar .= '<li '.$active.'><a href="?go='.$module_name.'&action='.$page['func'].'">'.$page['title'].'</a></li>';
			}
			$sidebar .= '</ul>';
			return $sidebar;
		} //End createModuleMenu();

		//Create a session notifiy
		public function notify($text, $type = 1) {
			switch($type) {
				case 1: $_SESSION['success'] = $text;
					break;
				case 2: $_SESSION['error'] = $text;
					break;
			}
		} //End createNotify();

		//Add a notification to template
		public function addNotify() {
			$types = array('success', 'error');
			$notify = NULL;
			foreach($types as $type) {
				if(isset($_SESSION[$type])) {
					$notify =  '<div class="notify '.$type.'">'.$_SESSION[$type].'</div>';
					unset($_SESSION[$type]);
				}
			}
			$this->replace('{{notify}}', $notify);
		} //End addNotify();

		//Manage GET parameters
	    public function fixGet($args) {
	        if(count($_GET) > 0) {
	            if(!empty($args)) {
	                $lastkey = "";
	                $pairs = explode("&",$args);
	                foreach($pairs as $pair) {
	                    if(strpos($pair,":") !== false) {
	                        list($key,$value) = explode(":",$pair);
	                        unset($_GET[$key]);
	                        $lastkey = "&$key$value";
	                    } elseif(strpos($pair,"=") === false)
	                        unset($_GET[$pair]);

	                    else {
	                        list($key, $value) = explode("=",$pair);
	                        $_GET[$key] = $value;
	                    }
	                }
	            }
	            return "?".((count($_GET) > 0)?http_build_query($_GET).$lastkey:"");
	        }
	    } //End fixGet();
		
		//Get user info
		public function getUserInfo($what) {
			global $db;
			$sessData = unserialize($_SESSION[md5($_SERVER['REMOTE_ADDR'].$this->getSettings('pepper'))]);
			if($query = $db->select('users', array('id'=>$sessData['lcms_user']))) {
				$record = $query[0];
				return $record[$what];
			}			
		} //End user();
		
		//Check for allowed module
		private function checkUserAllowed($module) {
			if($this->getUserInfo('id') != 1) {
				$allowed = explode(',',$this->getUserInfo('allowed'));
				if(in_array($module,$allowed)) return TRUE;
				else return FALSE;
			} else return TRUE;
		} //End checkUserAllowed();

	    //Logout
	    private function logout($get) {
	    	if(isset($get) && $get=='true') {
	    		unset($_SESSION[md5($_SERVER['REMOTE_ADDR'].$this->getSettings('pepper'))]);
				header('Location: login.php');
	    	}
	    } //End logout();

	}
?>