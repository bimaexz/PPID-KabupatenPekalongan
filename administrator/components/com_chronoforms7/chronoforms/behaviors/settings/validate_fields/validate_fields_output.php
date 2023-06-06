<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(empty($this->controller->Page->stopped)){
		$validate_fields = [
			'type' => 'validation',
			'name' => $page['fullname'].'_validation',
			'error_message' => 'Missing form data',
			'data_provider' => '{data:}',
			'list_errors' => true,
			'past_events' => [$previous_page['pageid']],//validate fields from all previous pages, but not the current one
		];
		
		$output .= $this->controller->Page->event_function($page['pageid'], $validate_fields);
	}