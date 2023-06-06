<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['icon_options'])){
		$icons = $this->controller->Parser->options($unit['icon_options'], 'data-icon');
		$unit['foptions'] = array_replace_recursive($unit['foptions'] ?? [], $icons);

		$unit['nodes']['main']['attrs']['data-rich'] = '1';
	}