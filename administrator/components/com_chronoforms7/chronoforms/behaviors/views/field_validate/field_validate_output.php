<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['datapath'])){
		$unit['fns']['validation']['fields'][$unit['uid']]['name'] = $unit['datapath'];
		if(empty($unit['fns']['validation']['fields'][$unit['uid']]['error'])){
			$unit['fns']['validation']['fields'][$unit['uid']]['server_error'] = $unit['nodes']['label']['content'];
		}else{
			$unit['fns']['validation']['fields'][$unit['uid']]['server_error'] = $unit['fns']['validation']['fields'][$unit['uid']]['error'];
		}
	}