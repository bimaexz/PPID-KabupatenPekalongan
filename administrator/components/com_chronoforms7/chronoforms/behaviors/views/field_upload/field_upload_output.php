<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$unit['fns']['upload']['fields'][$unit['uid']]['fieldname'] = $unit['datapath'];
	$unit['fns']['upload']['fields'][$unit['uid']]['page'] = $this->controller->FData->sessiondata('pages.this');//$unit['_page'];

	// if(!empty($unit['multiple'])){
	// 	$unit['fns']['upload']['fields'][$unit['uid']]['multiple'] = true;
	// 	$unit['fns']['upload']['fields'][$unit['uid']]['fieldname'] = $unit['datapath'].'[n]';
	// }