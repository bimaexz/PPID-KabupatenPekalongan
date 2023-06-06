<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(empty($this->controller->Page->stopped)){
		$security_actions = [
			'field_honeypot' => 'check_honeypot',
			'field_secicon' => 'secicon',
			'gcaptcha' => 'gcaptcha',
		];

		$scinputs = $this->controller->FData->cdata('pages.'.$previous_page['pageid'].'.security', []);
		foreach($scinputs as $view_name){
			$view = $this->controller->FData->cdata('views.'.$view_name);
			
			if($this->controller->FData->valid($view)){
				$vdata = [
					'type' => $security_actions[$view['type']],
					'page' => $previous_page['pageid'],
					'label' => $view['nodes']['label']['content'] ?? '',
					'field_name' => !empty($view['nodes']['main']['attrs']['name']) ? $view['nodes']['main']['attrs']['name'] : '',
					'failed_error' => !empty($view['failed_error']) ? $view['failed_error'] : $this->get('cf_settings.'.$security_actions[$view['type']].'.error'),
				];
				
				$vdata = $vdata + ['name' => $page['fullname'].'_'.$vdata['type']];
				$output .= $this->controller->Page->event_function($page['pageid'], $vdata);
				if(!empty($this->controller->Page->stopped)){
					break;
				}
			}
		}
	}