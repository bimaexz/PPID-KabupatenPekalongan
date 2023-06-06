<?php
namespace G3\L\T;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
trait Model{
	public function Model($alias){
		static $models;
		if(isset($this->_models[$alias])){
			if(isset($models[$alias])){
				return $models[$alias];
			}else{
				if(!is_array($this->_models[$alias])){
					return $models[$alias] = new $this->_models[$alias];
				}else{
					if(!empty($this->_models[$alias]['name'])){
						return $models[$alias] = new $this->_models[$alias]['name'];
					}else if(!empty($this->_models[$alias]['table'])){
						return $models[$alias] = new \G3\L\Model(['name' => $alias, 'table' => $this->_models[$alias]['table']]);
					}
				}
			}
		}
	}
	
}
?>