<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['reload'])){
		$page = $this->controller->FData->cdata('pages.'.$unit['reload']['page'].'.urlname');

		$scope = '';
		if(!empty($unit['reload']['scope'])){
			$unit['reload']['scope'] = $this->controller->FData->updateUid($unit['reload']['scope'], $unit);
			$scope = '[data-uid="'.$unit['reload']['scope'].'"]';
		}

		$unit['nodes'][$container]['attrs']['data-reload'] = json_encode(['scope' => $scope, 'url' => r3($this->controller->Parser->_url().rp3('gpage', $page).rp3('uid', $unit['uid']).rp3('gact', 'reload').rp3('tvout', 'view'))]);
	}