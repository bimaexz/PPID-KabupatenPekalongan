<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(in_array($container, ['container', 'main'])){
		if(!empty($unit['fns']['validation']['fields'][$unit['uid']])){
			$validations = $unit['fns']['validation']['fields'][$unit['uid']];
			$field_id = $unit['nodes'][$input]['attrs']['id'];
			
			$field_vrules = [];
			$validate_tag = ['identifier' => $field_id];
			if(in_array($unit['type'], ['field_checkboxes', 'field_radios'])){
				$validate_tag = ['identifier' => $field_id.'_1'];
			}
			
			$optional = true;
			//unset($validations['crules']);
			//other rules
			if(!empty($validations)){
				if(!empty($validations['disabled'])){
					$validate_tag['disabled'] = 'true';
					unset($validations['disabled']);
				}
				
				if(empty($validations['rules']['required']) AND empty($validations['rules']['minChecked']) AND $optional){
					$validate_tag['optional'] = true;
					if(isset($validations['optional'])){
						if(empty($validations['optional'])){
							$validate_tag['optional'] = false;
						}
						unset($validations['optional']);
					}
				}
				
				$gprompt = false;
				if(!empty($validations['error'])){
					$gprompt = $validations['error'];
				}

				$grules = $this->get('cf_settings.validation.errors', []);
				
				if(!empty($validations['rules'])){
					foreach($validations['rules'] as $rule => $value){
						$prompt = !empty($gprompt) ? $gprompt: (!empty($grules[$rule]) ? $grules[$rule]: $unit['nodes']['label']['content']);

						$value = $this->controller->Parser->parse($value);
						$param = $value;

						if(in_array($rule, ['match', 'different']) AND is_numeric($value)){
							$other_unit = $this->controller->FData->cdata('views.'.$value);
							$param = $other_unit['nodes']['label']['content'];
							$value = $other_unit['nodes']['main']['attrs']['name'];
						}

						$prompt = str_replace('#value#', $param, $prompt);

						if(!empty($value)){
							if($value == 'true' OR $value === true){
								if(in_array($unit['type'], ['field_checkbox', 'field_radios', 'field_secicon', 'field_checkboxes']) AND $rule == 'required'){
									if($unit['type'] == 'field_checkbox'){
										$rule = 'checked';
									}else{
										$rule = 'minChecked[1]';
									}
								}
								$field_vrules[] = ['type' => $rule, 'prompt' => $prompt];
							}else{
								$field_vrules[] = ['type' => $rule.'['.$value.']', 'prompt' => $prompt];
							}
						}
					}
				}

				if(!empty($validations['crules'])){
					$crules = $validations['crules'];
					
					foreach($crules as $k => $vrule){
						if(!empty($vrule['name'])){
							$vrule['name'] = str_replace(' ', '', $vrule['name']);
							$jsdef = '
							jQuery.fn.form.settings.rules.'.$vrule['name'].' = function(value){
								return true;
							};
							';
							if(!empty($vrule['jsdef'])){
								//$vrule['jsdef'] = $this->viewer->Parser->parse($vrule['jsdef']);
								$vrule['jsdef'] = str_replace('$(', 'jQuery(', $vrule['jsdef']);
								$jsdef = 'jQuery.fn.form.settings.rules.'.$vrule['name'].' = '.$vrule['jsdef'].';';
							}
							\GApp3::document()->addJsCode($jsdef);

							$field_vrules[] = ['type' => $this->controller->Parser->parse($vrule['name']), 'prompt' => $this->controller->Parser->parse($vrule['error'])];
						}
					}
				}
			}
			
			if(!empty($field_vrules)){
				$validate_tag['rules'] = array_values($field_vrules);
				
				// $this->viewer->Html->attr('data-validationrules', json_encode($validate_tag));
				// $this->viewer->Html->attr('data-validate', $field_id.'-main');
				// foreach($field_vrules as $rule){
				// 	$this->viewer->Html->errors[] = $rule['prompt'];
				// }
				//$unit['nodes']['main']['attrs']['data-validate'] = $field_id.'_input';
				$unit['nodes'][$container]['attrs']['data-validationrules'] = json_encode($validate_tag);
			}

			if(!empty($validate_tag['rules']) AND empty($validate_tag['disabled'])){
				foreach($validate_tag['rules'] as $r => $rule){
					$rtype = explode('[', $rule['type'])[0];
					if(in_array($rtype, ['empty', 'required', 'checked', 'minChecked', 'maxChecked', 'exactChecked'])){
						$unit['nodes'][$container]['attrs']['class']['required'] = 'required';
					}
				}
			}

			if($this->controller->FData->cdata('errors.'.$unit['uid'])){
				$unit['nodes'][$container]['attrs']['class']['error'] = 'error';
			}
		}
	}