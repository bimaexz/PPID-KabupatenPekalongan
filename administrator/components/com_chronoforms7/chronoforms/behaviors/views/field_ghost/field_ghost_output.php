<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(in_array($unit['type'], $behavior["accept"][$unit['utype']])){
		if(!isset($unit['ghost']['value'])){
			$unit['ghost']['value'] = '';
		}
		
		foreach($unit['datapath'] as $keysData => $dataname){
			if(is_null($this->data($dataname))){
				$array = (
					in_array($unit['type'], ['field_checkboxes']) OR 
					(
						!empty($unit['behaviors']['html']) AND 
						in_array('field_multiple', $unit['behaviors']['html'])
					)
				);
				if($array){
					if(strlen($unit['ghost']['value']) == 0){
						$this->controller->Parser->pdata($dataname, []);
					}else{
						$this->controller->Parser->pdata($dataname, [$unit['ghost']['value']]);
					}
				}else{
					$this->controller->Parser->pdata($dataname, $unit['ghost']['value']);
				}
			}
		}
		// if(is_null($this->data($unit['datapath']))){
		// 	$array = (in_array($unit['type'], ['field_checkboxes']) OR !empty($unit['nodes']['main']['attrs']['multiple']));
		// 	if($array){
		// 		if(strlen($unit['ghost']['value']) == 0){
		// 			$this->data($unit['datapath'], [], true);
		// 		}else{
		// 			$this->data($unit['datapath'], [$unit['ghost']['value']], true);
		// 		}
		// 	}else{
		// 		$this->data($unit['datapath'], $unit['ghost']['value'], true);
		// 	}
		// }
	}