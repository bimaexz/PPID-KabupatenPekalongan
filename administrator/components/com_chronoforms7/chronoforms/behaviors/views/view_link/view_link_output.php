<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$node = $input;
	if($unit['type'] != 'field_button'){
		$node = 'container';
	}

	$unit['nodes'][$node]['tag'] = 'a';

	if(!empty($unit['nodes']['main']['attrs']['target'])){
		$unit['nodes'][$node]['attrs']['target'] = $unit['nodes']['main']['attrs']['target'];
	}
	// unset($unit['nodes'][$node]['attrs']['type']);

	if(!empty($unit['link_settings']['page'])){

		$params = [];

		if(is_numeric($unit['link_settings']['page'])){
			$url = $this->controller->Parser->_url();
			$params['gpage'] = $this->controller->FData->cdata('pages.'.$unit['link_settings']['page'].'.urlname');
		}else{
			$url = $this->controller->Parser->parse($unit['link_settings']['page']);
		}

		if(!empty($unit['link_settings']['params'])){
			foreach($unit['link_settings']['params'] as $parameter){
				$params[$parameter['name']] = $this->controller->Parser->parse($parameter['value']);
			}
		}
		
		$url = \G3\L\Url::build($url, $params);

		$unit['nodes'][$node]['attrs']['href'] = r3($url);
	}