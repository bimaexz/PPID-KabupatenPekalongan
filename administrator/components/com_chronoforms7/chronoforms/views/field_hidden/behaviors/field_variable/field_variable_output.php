<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if($trigger == 'event'){
		$unit['nodes']['main']['active'] = false;
	}else{
		foreach($unit['datapath'] as $keysData => $dataname){
			$this->data($dataname, $this->controller->Parser->parse($unit['variable']['value']), true);
		}
	}