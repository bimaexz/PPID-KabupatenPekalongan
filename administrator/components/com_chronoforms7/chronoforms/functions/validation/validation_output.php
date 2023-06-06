<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	
	$_result = true;
	$_fail_event = true;
	
	if(empty($function['data_provider'])){
		$function['data_provider'] = '{data:}';
	}
	$data = (array)$this->Parser->parse($function['data_provider']);
	
	$rulesMap = [
		'empty' => 'required',
		'checked' => 'required',
		'integer' => 'is_integer',
		'regExp' => 'regex',
		'minChecked' => 'minCount',
		'maxChecked' => 'maxCount',
		'exactChecked' => 'exactCount',
	];
	
	$validator = new \G3\L\Validate();
	
	$validate_fields_check = function($fname, $rule, $ruledata) use ($validator, $data){
		if(!is_null($ruledata)){
			if(in_array($rule, ['match', 'different'])){
				$ruledata = \G3\L\Arr::getVal($data, $ruledata);
			}
			$condition = (bool)$validator::$rule(\G3\L\Arr::getVal($data, $fname), $ruledata);
		}else{
			$condition = (bool)$validator::$rule(\G3\L\Arr::getVal($data, $fname));
		}
		
		return $condition;
	};
	
	$validate_fields_error = function($unit, $fname, $rule, $error, $replacements) use ($function, &$_result, &$_fail_event){
		$_result = false;
		
		$error_message = $error ?? $unit['fns']['validation']['fields'][$unit['uid']]['server_error'];
		$this->controller->FData->cdata('errors.'.$unit['uid'], true, true);
		// $grules = $this->get('cf_settings.validation.errors', []);
		// if(!empty($grules[$rule])){
		// 	$error_message = $grules[$rule];
		// }

		$error_message = $this->Parser->parse($error_message);
		// $error_message = str_replace('-N-', $counter, $error_message);
		$_fail_event = $unit['_page'];

		$error_message = str_replace(array_keys($replacements), array_values($replacements), $error_message);

		// if(!empty($unit['_repeaters'])){
		// 	foreach($unit['_repeaters'] as $ruid){
		// 		$repeater = $this->controller->FData->cdata('views.'.$ruid);
		// 		$error_message = str_replace('#'.$repeater['name'].'.index#', $counter, $error_message);
		// 	}
		// }
		
		$errors[] = $error_message;
		//$_result = false;
		
		if(!empty($function['list_errors'])){
			$this->errors = \G3\L\Arr::setVal($this->errors, $fname, $error_message);
			//break;
		}
	};
	
	$this->debug[$function['name']]['log'] = rl3('Automatic validation enabled.');
	
	$fields = $function['fields'] ?? [];
	
	if(!empty($fields)){
		foreach($fields as $vuid => $vsettings){
			if(empty($vsettings['name'])){
				continue;
			}
			$field = $this->controller->FData->cdata('views.'.$vuid);
			
			$fname = $vsettings['name'];

			if(!empty($vsettings['server_disabled'])){
				continue;
			}

			foreach($field['datapath'] as $keysData => $dataname){
				if(!empty($vsettings['optional']) AND strlen(\G3\L\Arr::getVal($data, $dataname)) == 0){
					continue;
				}
				
				$field_rules = !empty($vsettings['rules']) ? array_filter($vsettings['rules']) : [];
				if(!empty($field_rules)){
					foreach($field_rules as $rule => $ruledata){

						if(in_array($rule, ['match', 'different'])){
							$ruledata = $this->controller->FData->cdata('views.'.$ruledata.'.datapath')[0];
						}
						
						if(!empty($rulesMap[$rule])){
							$rule = $rulesMap[$rule];
						}
						
						if(!method_exists($validator, $rule)){
							continue;
						}
						// pr($fname);
						// if(strpos($fname, '.#') !== false){
						// 	pr($this->controller->Parser->getNames($fname));
						// }
						// foreach($eunit['datapath'] as $keysData => $dataname){
						$condition = $validate_fields_check($dataname, $rule, $ruledata);
						if($condition !== true){
							$validate_fields_error($field, $dataname, $rule, null, (is_numeric($keysData) ? [] : json_decode($keysData, true)));
						}
						// }

						// if(strpos($fname, '.#') !== false){
						// 	$mfnames = $this->controller->Parser->getNames($fname);
						// 	foreach($mfnames as $mfname){
						// 		$condition = $validate_fields_check($mfname['name'], $rule, $ruledata);
								
						// 		if($condition !== true){
						// 			$validate_fields_error($field, $mfname['name'], $rule, $mfname['index']);
						// 		}
						// 	}
						// }else{
						// 	if(in_array($rule, ['match', 'different'])){
						// 		$ruledata = $this->controller->FData->cdata('views.'.$this->controller->FData->cdata('views.'.$ruledata).'.datapath');
						// 	}
						// 	$condition = $validate_fields_check($fname, $rule, $ruledata);
						// 	if($condition !== true){
						// 		$validate_fields_error($field, $fname, $rule, []);
						// 	}
						// }
						
					}
				}

				$field_crules = !empty($vsettings['crules']) ? array_filter($vsettings['crules']) : [];
				if(!empty($field_crules)){
					foreach($field_crules as $rule => $ruledata){
						
						if(!empty($ruledata['name']) AND !empty($ruledata['phpdef'])){
							$value = \G3\L\Arr::getVal($data, $dataname);
							$condition = eval($ruledata['phpdef']);
							
							if($condition !== true){
								$validate_fields_error($field, $dataname, $rule, (!empty($ruledata['error']) ? $ruledata['error'] : null), (is_numeric($keysData) ? [] : json_decode($keysData, true)));
							}
						}
					}
				}
			}
		}
	}
	
	$this->set($function['name'], $_result);
	
	if(empty($_result)){
		$this->fevents[$function['name']]['fail'] = $_fail_event;//true;
	}else{
		$this->fevents[$function['name']]['success'] = true;
	}