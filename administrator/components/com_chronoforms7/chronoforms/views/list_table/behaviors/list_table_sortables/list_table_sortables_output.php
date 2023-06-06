<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['sortables'])){
		if(!empty($unit['data_source'])){
			$this->controller->FData->cdata('functions.'.$unit['data_source'][1].'.models.data.sortable', $unit['sortables'], true);
		}
	}