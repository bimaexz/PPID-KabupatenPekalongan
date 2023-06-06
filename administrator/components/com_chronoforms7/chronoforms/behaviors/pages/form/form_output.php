<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$pid = $page['pageid'];
	
	if(empty($this->controller->FData->cdata('pages.'.$pid.'.form.disabled'))){
		if(strpos($output, '<form') === false){
			$form = [
				'type' => 'area_form',
				'content' => $output,
			];
			$form = array_merge(($unit['form'] ?? []), $form);
			
			$output = $this->controller->viewer->Parser->view($form);
		}
	}
	
	if(empty($unit['layout']) AND empty($this->controller->FData->cdata('pages.'.$pid.'.chronopage.disabled'))){
		$Html = new \G3\H\Html();
		$output = $Html->node([
			'active' => true, 
			'tag' => 'div',
			'content' => $output,
			'attrs' => [
				'id' => $this->controller->FData->cdata('alias').'_'.$this->controller->FData->cdata('pages.'.$pid.'.fullname'),
				'class' => 'ui container fluid form chronopage',
			]
		]);
	}