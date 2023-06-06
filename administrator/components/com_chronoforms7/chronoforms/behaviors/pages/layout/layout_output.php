<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['layout'])){
		$layout_page = $unit['layout']['page'];//$this->controller->FData->cdata('pids.'.$unit['layout']['page']);
		
		if($trigger == 'section_finish'){
			$this->controller->FData->cdata('pages.'.$layout_page.'.form.disabled', true, true);

			$layout_output = $this->controller->viewer->Parser->section($layout_page);
			
			$output = str_replace('{page}', $output, $layout_output);
		}else{
			$event_output = $this->controller->Page->event($layout_page, ['layout' => true]);

			$output = $event_output.$output;
		}
	}