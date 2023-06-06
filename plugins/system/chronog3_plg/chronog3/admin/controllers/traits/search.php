<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\C\T;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
trait Search {
	
	function Search($Model, $fields, $fieldname = '_search'){
		$signesmap = [
			'equal' => '=',
			'notequal' => '!=',
			'larger' => '>',
			'largerequal' => '>=',
			'smaller' => '<',
			'smallerequal' => '<=',
			'like' => 'LIKE',
			'likepart' => 'LIKE',
			'notlike' => 'NOT LIKE',
			'in' => 'IN',
			'notin' => 'NOT IN',
			'between' => 'BETWEEN',
			'notbetween' => 'NOT BETWEEN',
			'null' => 'IS NULL',
			'notnull' => 'IS NOT NULL',
		];
		if(!is_null($this->data($fieldname))){
			if(is_string($this->data($fieldname)) AND strlen($this->data($fieldname)) > 0){
				$Model->where('(');
				foreach($fields as $k => $field){
					$Model->where($field, '%'.$this->data($fieldname).'%', 'LIKE');
					
					if($k < count($fields) - 1){
						$Model->where('OR');
					}
				}
				$Model->where(')');
			}else if(is_array($this->data($fieldname))){
				$fields_length = count($this->data($fieldname));
				$counter = 0;

				$Model->where('(');
				foreach($this->data($fieldname) as $field => $fdata){
					$counter++;
					if(is_array($fdata)){
						foreach($fdata as $fop => $fvalue){
							if($fop == 'likepart'){
								$fvalue = '%'.$fvalue.'%';
							}
							$Model->where($field, $fvalue, $signesmap[$fop] ?? '=');
						}
					}else{
						$Model->where($field, '%'.$fdata.'%', 'LIKE');
					}

					if($counter < $fields_length){
						$Model->where('OR');
					}
				}
				$Model->where(')');
			}
		}
	}
	
}
?>