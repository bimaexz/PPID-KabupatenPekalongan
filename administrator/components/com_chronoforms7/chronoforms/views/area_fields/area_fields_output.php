<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$view['nodes']['main']['attrs']['id'] = $view['name'];

	$grid_classes = [
		1 => 'one',
		2 => 'two',
		3 => 'three',
		4 => 'four',
		5 => 'five',
		6 => 'six',
		7 => 'seven',
		8 => 'eight',
		9 => 'nine',
		10 => 'ten',
		11 => 'eleven',
		12 => 'twelve',
		13 => 'thirteen',
		14 => 'fourteen',
		15 => 'fifteen',
	];

	$view['nodes']['main']['attrs']['class']['number'] = $view['nodes']['main']['attrs']['class']['number'] ?? 'equal width fields';
	
	if(!empty($view['nodes']['label_field']['content'])){
		$label_width = $view['nodes']['label_field']['width'];
		$view['nodes']['label_field']['attrs']['class']['width'] = $grid_classes[$view['nodes']['label_field']['width']].' wide';
		$view['nodes']['fields_field']['attrs']['class']['width'] = $grid_classes[16 - (int)$view['nodes']['label_field']['width']].' wide';
	}

	$_map = [
		'label_field' => ['tag' => 'div', 'active' => !empty($view['nodes']['label_field']['content']), 'content' => '<label>'.($view['nodes']['label_field']['content'] ?? '').'</label>', 'attrs' => ['class' => ['field']]],
		'fields_area' => ['tag' => 'div', 'active' => !empty($view['nodes']['label_field']['content']), 'children' => [$this->Parser->section($view['uid'].'/body')], 'attrs' => ['class' => ['']]],
		'fields_field' => ['tag' => 'div', 'active' => !empty($view['nodes']['label_field']['content']), 'children' => ['fields_area'], 'attrs' => ['class' => ['field']]],
		'main' => ['tag' => 'div', 'children' => ['label_field', 'fields_field'], 'attrs' => ['class' => ['']]],
	];

	echo $this->Field->build($view, $_map);