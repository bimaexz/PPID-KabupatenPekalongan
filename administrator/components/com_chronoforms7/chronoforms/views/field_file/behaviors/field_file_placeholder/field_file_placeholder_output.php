<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$unit['nodes']['main']['before'][] = '
		<div class="ui right labeled button fluid large vinput quti w-100">
			<div class="ui icon button">
				<i class="faicon upload"></i>
			</div>
			<div class="ui basic label fluid vfilename quti w-100" data-text="'.$this->controller->Parser->parse($unit['altfile']['text']).'">
				'.$this->controller->Parser->parse($unit['altfile']['text']).'
			</div>
		</div>
	';

	$unit['nodes']['main']['attrs']['class'][] = 'hidden vfile';
	
	foreach($unit['datapath'] as $keysData => $dataname){
		if(!empty($this->data($dataname))){
			$files = (array)$this->data($dataname);
	
			// $unit['nodes']['main']['attrs']['data-files'] = json_encode($files);
			
			// foreach($files as $file){
			// 	$unit['nodes']['main']['after'][] = '<input type="hidden" data-ghost="1" name="'.$unit['nodes']['main']['attrs']['name'].'" value="'.$file.'" />';
			// }
		}
	}