<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "area_grid_settings",
		'title' => rl3("Grid Settings"),
		'icon' => 'table',
		'desc' => rl3("Customize the appearance of the grid area"),
		'group' => 'area_grid',
		'category' => rl3("Style"),
		'triggers' => [],
		'order' => -9,
		"accept" => [
			"views" => [
				"area_grid",
			],
		],
	];