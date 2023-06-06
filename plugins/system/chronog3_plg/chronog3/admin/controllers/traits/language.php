<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\C\T;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
trait Language {
	
	function Language($ext_name){
		if($this->data('lang')){
			\G3\L\Lang::read(\G3\Globals::ext_path($ext_name, 'admin'), $this->data('lang'));
		}
		
		if(isset($this->data['build']) OR isset($this->data['custom'])){
			if($this->data('lang')){
				$this->build();
			}
		}
		
		if((isset($this->data['save']) OR isset($this->data['update'])) AND $this->data('lang')){
			if(isset($this->data['save'])){
				$path = \G3\Globals::ext_path($ext_name, 'admin').'locales'.DS.$this->data('lang').'.custom.ini';
				$type = 'custom';
			}else{
				$path = \G3\Globals::ext_path($ext_name, 'admin').'locales'.DS.$this->data('lang').'.ini';
				$type = 'build';
			}
			//p3($path);die();
			$result = \G3\L\File::write($path, $this->data('language_strings'));
			
			if($result === true){
				return ['success' => rl3('The language file has been saved successfully'), 'redirect' => r3('index.php?ext='.$ext_name.'&cont=languages&lang='.$this->data('lang').rp3($type, 1))];
			}else{
				return ['error' => rl3('Error saving the language file.'), 'redirect' => r3('index.php?ext='.$ext_name.'&cont=languages&lang='.$this->data('lang').rp3($type, 1))];
			}
		}
		
		$this->set('ext_name', $ext_name);
		// $this->view = 'views.common.languages.index';
	}
	
	function buildLanguage($ext_name, $all = false){
		if(strpos($this->data('lang'), 'file:') === 0){
			$path = \G3\Globals::ext_path($ext_name, 'admin').'locales'.DS.str_replace('file:', '', $this->data('lang')).'.ini';
			
			$strings = '';
			if(file_exists($path)){
				$strings = file_get_contents($path);
			}
		}else{
			$path = \G3\Globals::ext_path($ext_name, 'admin');
			$files = \G3\L\Folder::getFiles($path, true);
			$path = \G3\Globals::ext_path($ext_name, 'front');
			$files = array_merge($files, \G3\L\Folder::getFiles($path, true));
			
			if($all){
				$path = \G3\Globals::ext_path('chronofc', 'admin');
				$files = array_merge($files, \G3\L\Folder::getFiles($path, true));
			}
			
			$strings = $this->_find_strings($files);
			foreach($strings as $k => $v){
				$strings[$k] = $k.' = '.$v;
			}

			// pr($strings);
			$strings = implode("\n", $strings);
		}
		
		$this->data['language_strings'] = $strings;
		$this->set('strings', $strings);
	}
	
	function _prepare_string(&$strings, $str, $val){
		$found = \G3\L\Lang::find($str, $this->data('lang'));
		$val = ($found === false) ? $val : $found;
		
		if(empty(trim($str))){
			$str = 'EMPTY';
		}

		$strings[trim($str)] = '"'.$val.'"';
		// return ''.trim($str).' = "'.$val.'"';//htmlspecialchars($val, ENT_COMPAT).'"';
	}
	
	function _find_strings($files){
		$strings = array();
		
		foreach($files as $file){
			if(substr($file, -4, 4) == '.php'){
				$file_code = file_get_contents($file);
				preg_match_all('/(rl3|el3)\(("|\')([^(\))]*?)\2[,)]/i', $file_code, $langs);
				if(!empty($langs[3])){
					//$strings[] = '; '.$file;
					foreach($langs[3] as $match){
						// $strings[] = $this->_prepare_string(\G3\L\Lang::build($match), $match);
						$this->_prepare_string($strings, \G3\L\Lang::build($match), $match);
					}
				}
			}
		}
		
		$strings = array_unique($strings);
		
		return $strings;
	}
}
?>