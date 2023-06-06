<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['ajax']['page'])){
		$params = [];
		$params['gact'] = 'ajax';
		$params['tvout'] = 'view';

		if(is_numeric($unit['ajax']['page'])){
			$url = $this->controller->Parser->_url();
			$params['gpage'] = $this->controller->FData->cdata('pages.'.$unit['ajax']['page'].'.urlname');
		}else{
			$url = $this->controller->Parser->parse($unit['ajax']['page']);
		}

		if(!empty($unit['ajax']['params'])){
			foreach($unit['ajax']['params'] as $parameter){
				$params[$parameter['name']] = $this->controller->Parser->parse($parameter['value']);
			}
		}
		
		$url = \G3\L\Url::build($url, $params);

		$scope = '';
		if(!empty($unit['ajax']['scope'])){
			$unit['ajax']['scope'] = $this->controller->FData->updateUid($unit['ajax']['scope'], $unit);
			$scope = '[data-uid="'.$unit['ajax']['scope'].'"]';
		}

		$unit['nodes'][$container]['attrs']['data-ajax'] = json_encode(['response' => $unit['ajax']['response'], 'scope' => $scope, 'url' => r3($url)]);
	}