<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['data_source'])){
		$results = $this->controller->FData->dsources($unit['data_source']);
		foreach($results as $result){
			foreach($result as $mkey => $mdata){
				$this->set($mkey, $result[$mkey]);
			}
			$option = [];
			$value = '';
			foreach($unit['dynamic_options']['option_data'] as $opdata){
				if($opdata['type'] == 'value'){
					$value = $this->controller->Parser->parse($opdata['value']);
				}
				$option[$opdata['type']] = $this->controller->Parser->parse($opdata['value']);
			}
			
			$unit['foptions'][$value] = $option;
		}
	}