<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_columns_count",
		'title' => rl3("Columns Count"),
		'icon' => 'columns',
		'desc' => rl3("Divide the options list in multiple columns"),
		'group' => 'configs',
		'category' => rl3("Settings"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"views" => [
				"field_checkboxes",
				"field_radios",
				"field_select",
			],
		],
	];