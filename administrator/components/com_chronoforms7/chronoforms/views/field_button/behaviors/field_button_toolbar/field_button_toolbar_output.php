<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$unit['nodes']['main']['attrs']['class']['toolbar'] = 'toolbar-button';

	$unit['nodes']['main']['attrs']['type'] = 'button';

	if(!empty($unit['nodes']['main']['attrs']['data-url']) AND is_numeric($unit['nodes']['main']['attrs']['data-url'])){
		$unit['nodes']['main']['attrs']['data-url'] = $this->controller->FData->cdata('pages.'.$unit['nodes']['main']['attrs']['data-url'].'.urlname');
		$unit['nodes']['main']['attrs']['data-url'] = $this->controller->Parser->parse('{url:'.$unit['nodes']['main']['attrs']['data-url'].'}');
	}