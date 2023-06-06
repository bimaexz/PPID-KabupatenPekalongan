<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['multiline_options'])){
		$lines = explode("\n", $unit['multiline_options']);
		$lines = array_map('trim', $lines);
		$lines = array_filter($lines, 'strlen');

		$selected = [];
		if(!empty($unit['multiline_selected'])){
			$selected = array_map('trim', explode("\n", $unit['multiline_selected']));
		}

		foreach($lines as $line){
			$option = [];
			$odata = explode('=', $line);

			if(count($odata) == 1 AND (is_array($this->controller->Parser->parse($odata[0])))){
				foreach($this->controller->Parser->parse($odata[0]) as $oval => $otext){
					$option = ['value' => $oval, 'content' => $otext];
					if(in_array($oval, $selected)){
						if($unit['type'] == 'field_select'){
							$option['selected'] = 'selected';
						}else{
							$option['checked'] = 'checked';
						}
					}
					
					$unit['foptions'][] = $option;
				}
				continue;
			}

			$option = [
				'value' => $odata[0],
				'content' => $this->controller->Parser->parse($odata[1] ?? $odata[0]),
			];

			if(in_array($option['value'], $selected)){
				if($unit['type'] == 'field_select'){
					$option['selected'] = 'selected';
				}else{
					$option['checked'] = 'checked';
				}
			}

			$unit['foptions'][] = $option;
		}
	}