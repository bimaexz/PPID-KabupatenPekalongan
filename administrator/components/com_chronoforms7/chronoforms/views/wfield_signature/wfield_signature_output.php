<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$view['nodes']['icon']['active'] = true;
	$view['nodes']['icon']['attrs']['class']['icon'] = 'eraser';
	
	$_map = [
		'clear' => ['active' => true, 'tag' => 'button', 'children' => ['icon'], 'attrs' => ['class' => 'ui button compact tiny left labeled icon', 'data-action' => 'clear', 'type' => 'button']],
		'canvas' => ['active' => true, 'tag' => 'canvas', 'attrs' =>['width' => 100, 'data-signature' => 1]],
		'segment' => ['active' => true, 'children' => ['canvas'], 'attrs' =>['class' => 'quti segment rounded shadow mt-1 p-1']],
		'main' => ['attrs' => ['type' => 'hidden']],
		'container' => ['children' => ['label', 'segment', 'clear', 'main']],
	];

	echo $this->Field->build($view, $_map);