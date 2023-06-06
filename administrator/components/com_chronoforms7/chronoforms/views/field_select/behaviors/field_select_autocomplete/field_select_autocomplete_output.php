<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$unit['nodes']['main']['attrs']['class']['search'] = 'search selection';

	if(!empty($unit['complete']['page'])){
		$params = [];
		$params['gact'] = 'ajax';
		$params['tvout'] = 'view';

		if(is_numeric($unit['complete']['page'])){
			$url = $this->controller->Parser->_url();
			$params['gpage'] = $this->controller->FData->cdata('pages.'.$unit['complete']['page'].'.urlname');
		}else{
			$url = $this->controller->Parser->parse($unit['complete']['page']);
		}

		if(!empty($unit['complete']['params'])){
			foreach($unit['complete']['params'] as $parameter){
				$params[$parameter['name']] = $this->controller->Parser->parse($parameter['value']);
			}
		}
		
		$url = \G3\L\Url::build($url, $params);

		$scope = '';
		if(!empty($unit['complete']['scope'])){
			$unit['complete']['scope'] = $this->controller->FData->updateUid($unit['complete']['scope'], $unit);
			$scope = '[data-uid="'.$unit['complete']['scope'].'"]';
		}

		$unit['nodes'][$input]['attrs']['data-complete'] = json_encode(['scope' => $scope, 'url' => r3($url)]);
	}