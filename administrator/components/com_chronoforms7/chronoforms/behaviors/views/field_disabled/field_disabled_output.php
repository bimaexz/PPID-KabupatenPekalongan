<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$unit['nodes']['container']['attrs']['class']['disabled'] = 'disabled';
	$unit['nodes']['main']['attrs']['disabled'] = 'disabled';

	if(!empty($unit['fns']['validation']['fields'][$unit['uid']])){
		$unit['fns']['validation']['fields'][$unit['uid']]['server_disabled'] = true;
	}