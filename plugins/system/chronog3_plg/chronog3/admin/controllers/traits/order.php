<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\C\T;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
trait Order {
	
	function Order($Model, $fields){
		$this->_helpers[] = '\G3\H\Sorter';
		$return = [];
		
		$this->set('_helpers.sorter.fields', $fields);
		
		foreach($fields as $name){
			$alias = \G3\L\Str::slug($name, '_');
			if($this->data('orderfld') == $alias OR $this->data('orderfld') == $name){
				$direction = $this->data('orderdir', 'asc');
				
				if($direction == 'clear'){
					\GApp3::session()->clear('helpers.sorter.'.$alias);
				}else{
					$return[$name] = $direction;
					\GApp3::session()->set('helpers.sorter.'.$alias, array('fld' => $name, 'dir' => $return[$name]));
				}
			}
		}
		//if no order is set in url then try to find one in session
		$saved = \GApp3::session()->get('helpers.sorter', array());
		if(count($saved)){
			foreach($fields as $name){
				$alias = \G3\L\Str::slug($name, '_');
				if(isset($saved[$alias])){
					$return[$saved[$alias]['fld']] = $saved[$alias]['dir'];
				}
			}
		}
		$Model->order($return);
	}
	
}
?>