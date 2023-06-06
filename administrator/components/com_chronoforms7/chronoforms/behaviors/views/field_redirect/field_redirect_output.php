<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$paths = [];
	foreach($unit['datapath'] as $keysData => $dataname){
		if(is_array($this->data($dataname))){
			$unit['fns']['redirect']['parameters'][$unit['uid']]['name'] = $dataname;
			$unit['fns']['redirect']['parameters'][$unit['uid']]['value'] = $this->data($dataname);
		}else{
			$unit['fns']['redirect']['parameters'][$unit['uid']]['name'] = $dataname;
			$unit['fns']['redirect']['parameters'][$unit['uid']]['value'] = $this->data($dataname);
		}
	}