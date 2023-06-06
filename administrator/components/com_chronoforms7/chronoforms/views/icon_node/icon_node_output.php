<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$_map = [
		'main' => [
			'active' => true, 
			'tag' => 'i', 
			// 'children' => ['__CONTENT__'], 
			'attrs' => [
				'class' => [
					'default' => 'faicon',
					'icon' => $view['nodes']['icon']['attrs']['class']['icon'] ?? '',
				]
			]
		],
		// 'container' => ['active' => true, 'children' => ['main'], 'attrs' => ['class' => '']]
	];

	echo $this->Field->build($view, $_map);