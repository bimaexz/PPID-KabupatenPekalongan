<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_ghost",
		'title' => rl3("Ghost Field"),
		'desc' => rl3("Control the no selection data value"),
		'group' => 'data',
		'category' => rl3("Settings"),
		//'default' => true,
		'system' => ['views'],
		'icon' => 'dot-circle',
		'triggers' => ['new_event_start'],
		'order' => 0,
		"accept" => [
			"views" => [
				"field_file",
				"field_radios",
				"field_checkbox",
				"field_checkboxes",
				"field_select",
			],
		],
	];