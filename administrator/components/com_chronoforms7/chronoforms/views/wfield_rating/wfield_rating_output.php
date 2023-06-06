<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$view['nodes']['main']['attrs']['data-icon'] = $view['nodes']['icon']['attrs']['class']['icon'] ?? '';

	$view['nodes']['hidden']['attrs']['name'] = $view['nodes']['main']['attrs']['name'];

	$_map = [
		'hidden' => ['active' => true, 'tag' => 'input', 'attrs' => ['type' => 'hidden']],
		'main' => ['tag' => 'div', 'attrs' => ['class' => ['default' => 'ui rating']]],
		'container' => ['children' => ['label', 'main', 'hidden']],
	];

	echo $this->Field->build($view, $_map, 'hidden');