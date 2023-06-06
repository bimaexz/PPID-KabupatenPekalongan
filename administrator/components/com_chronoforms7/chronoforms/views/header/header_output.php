<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$_map = [
		'icon' => ['active' => !empty($view['nodes']['icon']['attrs']['class']['icon'])],
		'subheader' => ['active' => !empty($view['nodes']['subheader']['content']), 'attrs' => ['class' => ['sub header']]],
		'content' => ['active' => true, 'children' => ['icon', '__CONTENT__', 'subheader'], 'attrs' => ['class' => ['content']]],
		'main' => ['children' => ['content'], 'attrs' => ['class' => ['default' => 'ui header']]],
	];

	echo $this->Field->build($view, $_map);