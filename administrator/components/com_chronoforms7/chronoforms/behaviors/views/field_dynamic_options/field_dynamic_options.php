<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_dynamic_options",
		'title' => rl3("Dynamic Options"),
		'icon' => 'database',
		'desc' => rl3("Load options from a Data Source"),
		'group' => 'configs',
		'category' => rl3("Database"),
		'triggers' => ['before_view'],
		'order' => 0,
		"accept" => [
			"views" => [
				"field_checkboxes",
				"field_radios",
				"field_select",
			],
		],
		"paid" => 1,
	];