<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$matching_value = function($dval, $values){
		foreach($values as $value){
			$svalue = str_replace('#value#', $dval, $value['svalue']);

			if(empty($value['rule']) OR $value['rule'] == '=='){
				if($dval == $value['value']){
					return $this->controller->Parser->parse($svalue);
				}
			}else if($value['rule'] == '!='){
				if($dval != $value['value']){
					return $this->controller->Parser->parse($svalue);
				}
			}else if($value['rule'] == '>'){
				if($dval > $value['value']){
					return $this->controller->Parser->parse($svalue);
				}
			}else if($value['rule'] == '>='){
				if($dval >= $value['value']){
					return $this->controller->Parser->parse($svalue);
				}
			}else if($value['rule'] == '<'){
				if($dval < $value['value']){
					return $this->controller->Parser->parse($svalue);
				}
			}else if($value['rule'] == '<='){
				if($dval <= $value['value']){
					return $this->controller->Parser->parse($svalue);
				}
			}else if($value['rule'] == 'regex'){
				if($dval <= $value['value']){
					return $this->controller->Parser->parse($svalue);
				}
			}else if($value['rule'] == 'in'){
				if(!empty($value['mvalue']) AND in_array($dval, $value['mvalue'])){
					return $this->controller->Parser->parse($svalue);
				}
			}else if($value['rule'] == '!in'){
				if(!empty($value['mvalue']) AND !in_array($dval, $value['mvalue'])){
					return $this->controller->Parser->parse($svalue);
				}
			}else if($value['rule'] == 'any'){
				return $this->controller->Parser->parse($svalue);
			}
		}

		return $dval;
	};

	$update_data = function($datapath, $values, $type) use($matching_value){
		if(strpos($type, '_action_') === 0){
			$rtype = $datapath.'_'.str_replace('_action_', '', $type);
		}else if($type == '_data_'){
			$rtype = $datapath;
		}else{
			$rtype = $datapath.'_'.$type;
		}

		if(is_array($this->data($datapath))){
			foreach($this->data($datapath) as $k => $value){
				$this->controller->Parser->pdata($rtype.'.'.$k, $matching_value($value, $values));
			}
		}else{
			$this->controller->Parser->pdata($rtype, $matching_value($this->data($datapath), $values));
		}
	};

	foreach($unit['datapath'] as $keysData => $dataname){
		if(!is_null($this->data($dataname)) AND !empty($unit['altdata'])){
			foreach($unit['altdata'] as $ak => $set){
				if(!empty($set['types']) AND !empty($set['values'])){
					foreach($set['types'] as $type){
						
						$update_data($dataname, $set['values'], $type);
						// if(strpos($unit['datapath'], '.#') !== false){
						// 	$mfnames = $this->controller->Parser->getNames($unit['datapath']);
						// 	foreach($mfnames as $mfname){
						// 		$update_data($mfname['name'], $set['values'], $type);
						// 	}
						// }else{
						// 	$update_data($unit['datapath'], $set['values'], $type);
						// }
					}
				}
			}
		}
	}