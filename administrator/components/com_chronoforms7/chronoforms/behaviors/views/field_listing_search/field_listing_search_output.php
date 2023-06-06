<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['units']['search_list']['uid'])){
		$ounit = $this->controller->FData->cdata('functions.'.$unit['units']['search_list']['uid']);

		$unit['units']['search_list']['settings']['models']['data']['search'][$unit['uid']]['fieldname'] = $unit['nodes']['main']['attrs']['name'];

		$request_search_term = \G3\L\Request::post($unit['nodes']['main']['attrs']['name'], \G3\L\Request::get($unit['nodes']['main']['attrs']['name']));

		if(!is_null($request_search_term)){
			\G3\L\Request::set('startat', 0);
		}

		$ounit = array_replace_recursive($ounit, $unit['units']['search_list']['settings']);
		$this->controller->FData->cdata('functions.'.$unit['units']['search_list']['uid'], $ounit, true);
	}