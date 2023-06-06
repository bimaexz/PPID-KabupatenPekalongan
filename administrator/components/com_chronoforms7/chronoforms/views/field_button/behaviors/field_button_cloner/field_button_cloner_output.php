<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['repeater']['uid'])){
		$repeater = $this->controller->FData->cdata('views.'.$unit['repeater']['uid']);

		if(!empty($repeater['name'])){
			if($unit['repeater']['action'] == 'add'){
				$unit['nodes']['main']['attrs']['type'] = 'button';
				$unit['nodes']['main']['attrs']['class']['repeater'] = 'add_clone';
				$unit['nodes']['main']['attrs']['data-cloning'] = 'copy';
				$unit['nodes']['main']['attrs']['data-group'] = $repeater['name'];
			}else if($unit['repeater']['action'] == 'remove'){
				$unit['nodes']['main']['attrs']['type'] = 'button';
				$unit['nodes']['main']['attrs']['class']['repeater'] = 'delete_clone';
				$unit['nodes']['main']['attrs']['data-group'] = $repeater['name'];
			}else if($unit['repeater']['action'] == 'sort'){
				$unit['nodes']['main']['tag'] = 'div';
				$unit['nodes']['main']['attrs']['type'] = null;
				$unit['nodes']['main']['attrs']['class']['repeater'] = 'sort_clone';
				$unit['nodes']['main']['attrs']['data-group'] = $repeater['name'];
			}
		}
	}