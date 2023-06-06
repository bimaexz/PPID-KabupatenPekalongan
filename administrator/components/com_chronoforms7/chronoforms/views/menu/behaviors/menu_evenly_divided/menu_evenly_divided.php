<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "menu_evenly_divided",
		'title' => rl3("Evenly Divided"),
		'icon' => 'ellipsis-h',
		'desc' => rl3("Item width is equal"),
		'group' => 'menu',
		'category' => rl3("Style"),
		'triggers' => ['before_view'],
		'order' => -7,
		"accept" => [
			"views" => [
				"menu",
			],
		],
	];