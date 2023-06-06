<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/

//global namespace for the global helper function p3()
namespace {
	/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
	defined('GCORE_SITE') or die;
	//multi purpose function
	if(!function_exists('pr3')){
		function pr3($array = array(), $return = false, $class = ''){
			if(is_array($array)){
				array_walk_recursive($array, function(&$v){
					if(is_string($v)){
						$v = htmlspecialchars($v);
					}else if(is_bool($v)){
						$v = '<span class="ui text blue">'.json_encode($v).'</span>';
					}else if(is_int($v) or is_float($v)){
						$v = '<span class="ui text red">'.json_encode($v).'</span>';
					}else if(is_null($v)){
						$v = '<span class="ui text blue">NULL</span>';
					}
				});
			}else if(is_string($array)){
				$array = htmlspecialchars($array);
			}else if(is_bool($array)){
				$array = '<span class="ui text blue">'.json_encode($array).'</span>';
			}else if(is_int($array) or is_float($array)){
				$v = '<span class="ui text red">'.json_encode($array).'</span>';
			}else if(is_null($array)){
				$v = '<span class="ui text blue">NULL</span>';
			}

			if($return){
				return '<pre style="word-wrap:break-word; white-space:pre-wrap;" class="'.$class.'">'.print_r($array, $return).'</pre>';
			}else{
				echo '<pre style="word-wrap:break-word; white-space:pre-wrap;" class="'.$class.'">';
				print_r($array, $return);
				echo '</pre>';
			}
		}
	}
	
	function rl3($text, $data = [], $id = false){
		return \G3\L\Lang::_($text, $data, $id);
	}
	
	function el3($text, $data = [], $id = false){
		echo \G3\L\Lang::_($text, $data, $id);
	}
	
	function rp3($name, $data){
		return \G3\L\Url::appendParam($name, $data);
	}
	/* 
	function geta($array, $path, $default = null){
		return \G3\L\Arr::getVal($array, $path, $default);
	}
	
	function seta($array, $path, $value){
		return \G3\L\Arr::setVal($array, $path, $value);
	} */
	
	//if(!function_exists('r2')){
	function r3($url, $params = []){
		// $router = \G3\Globals::getClass('route');

		// $xhtml = $params['xhtml'] ?? false;
		// $absolute = $params['absolute'] ?? $params['full'] ?? false;
		// $ssl = $params['ssl'] ?? null;

		return \G3\L\Route::_($url, $params);
	}
	//}

	// if(get_magic_quotes_gpc()){
	// 	function stripslashes_gpc(&$value){
	// 		$value = stripslashes($value);
	// 	}
	// 	array_walk_recursive($_GET, 'stripslashes_gpc');
	// 	array_walk_recursive($_POST, 'stripslashes_gpc');
	// 	array_walk_recursive($_COOKIE, 'stripslashes_gpc');
	// 	array_walk_recursive($_REQUEST, 'stripslashes_gpc');
	// }
}
//G3 namespace for the loader
namespace G3{
	if(!defined('DS')){
		define('DS', DIRECTORY_SEPARATOR);
	}

	class Globals {
		static $settings = array();

		public static function site($area){
			return (GCORE_SITE == $area);
		}

		public static function get($key, $default = null){
			if(isset(self::$settings[$key])){
				return self::$settings[$key];
			}else{
				return $default;
			}
		}

		public static function set($key, $value){
			self::$settings[$key] = $value;
		}
		
		public static function ready(){
			if(!class_exists('GApp3', false)){
				class_alias(\G3\Globals::getClass('app'), 'GApp3');
			}
		}
		
		public static function getClass($name){
			$parts = [];
			if(self::get('app')){
				$parts[] = \G3\L\Str::camilize(self::get('app'));
			}
			
			$parts[] = \G3\L\Str::camilize($name);
			
			return '\G3\L\\'.implode('\\', $parts);
		}

		public static function ext_path($ext, $area = 'admin'){
			return \GApp3::extension($ext)->path($area);
		}
		/*public static function ext_path($ext, $area = 'admin'){
			$path = '';
			if($area == 'admin'){
				$path .= self::get('ADMIN_PATH');
			}else{
				$path .= self::get('FRONT_PATH');
			}
			$path .= 'extensions'.DS.$ext.DS;
			$path = self::fix_path($path);
			return $path;
		}*/
		public static function ext_url($ext, $area = 'admin'){
			return \GApp3::extension($ext)->url($area);
		}
		/*public static function ext_url($ext, $area = 'admin'){
			$path = '';
			if($area == 'admin'){
				$path .= self::get('ADMIN_URL');
			}else{
				$path .= self::get('FRONT_URL');
			}
			$path .= 'extensions/'.$ext.'/';
			$path = self::fix_urls($path);
			return $path;
		}*/
		
		public static function url_to_path($url){
			return str_replace([\G3\Globals::get('FRONT_URL'), \G3\Globals::get('ROOT_URL')], [\G3\Globals::get('FRONT_PATH'), \G3\Globals::get('ROOT_PATH')], $url);
		}
		/*
		public static function fix_path($path){
			$extensions_paths = self::get('EXTENSIONS_PATHS', array());
			$extensions_names = self::get('EXTENSIONS_NAMES', array());
			if(!empty($extensions_paths) AND !empty($extensions_names)){
				foreach($extensions_paths as $int_path => $ext_path){
					foreach($extensions_names as $int_name => $ext_name){
						$path = str_replace($int_path.$int_name, $ext_path.$ext_name.DS.$int_name, $path);
					}
				}
			}
			return $path;
		}
		*/
		/*
		public static function fix_urls($output){
			$extensions_urls = self::get('EXTENSIONS_URLS', array());
			$extensions_names = self::get('EXTENSIONS_NAMES', array());
			if(!empty($extensions_urls) AND !empty($extensions_names)){
				foreach($extensions_urls as $int_url => $ext_url){
					foreach($extensions_names as $int_name => $ext_name){
						$output = str_replace($int_url.$int_name, $ext_url.$ext_name.'/'.$int_name, $output);
					}
				}
			}
			return $output;
		}
		*/
		
	}

	class Loader {
		static $classname = "";
		static $filepath = "";
		static $memory_usage = 0;
		static $start_time = 0;
		
		protected static function translate_path($segments){
			$classes_aliases = array('Libs' => 'L', 'Helpers' => 'H', 'Models' => 'M', 'Admin' => 'A', 'Extensions' => 'E', 'Controllers' => 'C', 'Traits' => 'T');//, 'Components' => 'Com', 'Plugins' => 'P');
			foreach($segments as $k => $dir){
				$class_match = array_search($dir, $classes_aliases);
				if($class_match !== false){
					$segments[$k] = $class_match;
				}
			}
			return $segments;
		}

		static public function register($name){
			if(empty(self::$start_time)){
				self::$start_time = microtime(true);
				self::$memory_usage = memory_get_usage();
			}
			if(strlen(trim($name)) > 0){
				$dirs = explode("\\", $name);
				$dirs = array_values(array_filter($dirs));
				//translate class names to path
				$dirs = self::translate_path($dirs);
				
				//if the class doesn't belong to the G3 then don't try to auto load it
				if($dirs[0] !== 'G3'){
					// $file = dirname(__FILE__).DS.'vendors'.DS.strtolower($name).'.php';
					// if(file_exists($file)){
					// 	$name_parts = explode('\\', $name);
					// 	if(file_exists(dirname(__FILE__).DS.'vendors'.DS.$name_parts[0].DS.'autoload.php')){
					// 		require_once(dirname(__FILE__).DS.'vendors'.DS.$name_parts[0].DS.'autoload.php');
					// 	}
					// 	require_once($file);
					// 	return true;
					// }
					return false;
				}
				//build the include file path
				$strings = array();
				$extension_next = false;
				foreach($dirs as $k => $dir){
					if($dir === 'G3'){
						//root dir
						$strings[] = dirname(__FILE__);
						continue;
					}
					if($k == (count($dirs) - 1)){
						//last dir (file name)
						$strings[] = strtolower(preg_replace('/([a-z]|[0-9])([A-Z])/', '$1_$2', $dir)).".php";
						continue;
					}
					if(empty($dirs[$k])){
						//empty value
						continue;
					}
					//otherwise, uncamilize the namespace name to get the directory name
					$string = strtolower(preg_replace('/([a-z]|[0-9])([A-Z])/', '$1_$2', $dir));
					
					if($extension_next){
						$string = rtrim(\G3\Globals::ext_path($string, (!in_array('Admin', $dirs) ? 'front' : 'admin')), DS);
						$strings = [];
						$extension_next = false;
					}
					
					if($string == 'extensions'){
						$extension_next = true;
					}
					
					$strings[] = $string;
				}
				//load the file if exists
				$file = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, implode(DIRECTORY_SEPARATOR, $strings));
				//$file = \G3\Globals::fix_path($file);
				//pr3($file);
				if(file_exists($file) AND substr($file, -4, 4) == ".php"){
					require_once($file);
					if(class_exists($name) OR trait_exists($name)){
						if($name == 'G3\L\App'){
							//class_alias($name, 'GApp3');
						}
						return true;
					}else{
						self::$filepath = $file;
						self::$classname = $name;
					}
				}else{
					self::$filepath = $file;
					self::$classname = $name;
				}
				/*if(L\Base::getConfig('debug', 0)){
					self::debug();
				}*/
			}
		}

		static public function debug(){
			if(!empty(self::$classname))
			echo nl2br("\nClass name: \"".self::$classname."\" could NOT be found, additionally, the file below does NOT exist: \n".self::$filepath);
		}
	}
	spl_autoload_register(__NAMESPACE__ .'\Loader::register');
}