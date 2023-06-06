<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(strpos($unit['type'], 'area_') === 0){
		$unit['nodes']['main']['attrs']['class']['hidden'] = 'hidden';
	}else{
		$unit['nodes']['container']['attrs']['class']['hidden'] = 'hidden';
	}