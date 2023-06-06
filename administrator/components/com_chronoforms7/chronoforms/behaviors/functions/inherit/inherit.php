<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "inherit",
		'title' => rl3("Inheritance"),
		'icon' => 'copy',
		'desc' => rl3("Copy settings from another unit"),
		'group' => 'data',
		'category' => rl3("Settings"),
		'triggers' => ['initialize'],
		'order' => -10000,
		'config_order' => 11,
		"accept" => [
			"functions" => true,
		],
		"not_accept" => [
			"functions" => [
				'unit_reference',
			]
		],
	];