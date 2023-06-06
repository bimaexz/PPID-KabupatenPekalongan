<?php
namespace G3\L\T;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
trait GetSet{
	public function get($var, $default = null){
		$value = \G3\L\Arr::getVal($this->_vars, $var, $default);
		
		return $value;
	}
	
	public function set($var, $value){
		$this->_vars = \G3\L\Arr::setVal($this->_vars, $var, $value);
	}
	
	function data($key, $default = null, $setter = false){
		if($setter){
			$this->data = \G3\L\Arr::setVal($this->data, explode('.', $key), $default);
			return $default;
		}else{
			$value = \G3\L\Arr::getVal($this->data, explode('.', $key), $default);
			return $value;
		}
	}
}
?>