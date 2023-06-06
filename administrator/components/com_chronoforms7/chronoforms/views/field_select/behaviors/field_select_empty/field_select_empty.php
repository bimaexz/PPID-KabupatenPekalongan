<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_select_empty",
		'title' => rl3("Empty Selectable"),
		'icon' => 'minus',
		'desc' => rl3("Enable reselection of Empty value"),
		'group' => 'field_select',
		'category' => rl3("Dropdown Settings"),
		'triggers' => ['before_view'],
		'order' => -9,
		"accept" => [
			"views" => [
				"field_select",
			],
		],
	];