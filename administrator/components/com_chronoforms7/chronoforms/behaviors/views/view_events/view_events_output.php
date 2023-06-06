<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['vevents']) AND in_array($container, ['container', 'main'])){
		$events = $unit['vevents'];
		
		$valid_events = [];
		$sources = [];
		foreach($events as $k => $field_event){
			if(!empty($field_event['actions']) OR !empty($field_event['cactions'])){
				foreach($field_event['rules'] as $g => $group){
					if(!empty($group['source'])){
						// if(!empty($unit['inherits'])){
						// 	if($unit['inherits'] == $group['source']){
						// 		$group['source'] = $unit['uid'];
						// 	}
						// }
						$group['source'] = $this->controller->FData->updateUid($group['source'], $unit);
						$field_event['rules'][$g]['source'] = $group['source'];

						$sources[] = $group['source'];
					}
				}
				$valid_events[] = $field_event;
			}
		}

		if(!empty($valid_events)){
			$unit['nodes'][$container]['attrs']['data-vevents'] = json_encode($valid_events);
			$unit['nodes'][$container]['attrs']['data-evsources'] = json_encode(array_values(array_unique($sources)));
		}
	}