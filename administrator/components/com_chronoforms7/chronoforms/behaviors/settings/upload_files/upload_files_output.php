<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(empty($this->controller->Page->stopped)){
		$upload_files = [
			'type' => 'upload',
			'name' => $this->controller->FData->cdata('pages.'.$this->controller->FData->sessiondata('pages.this').'.fullname').'_upload',//$previous_page.'_upload',
			//'autofields' => '1',
			'past_events' => [$previous_page['pageid']],
			'path' => !empty($unit['upload']['path']) ? $unit['upload']['path'] : '',
		];
		
		$output .= $this->controller->Page->event_function($page['pageid'], $upload_files);
	}