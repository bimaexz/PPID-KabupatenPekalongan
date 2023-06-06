<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_choices_style",
		'title' => rl3("Layout & Style"),
		'icon' => 'check-square',
		'desc' => rl3("Set the display layout and style"),
		'group' => 'configs',
		'category' => rl3("Settings"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"views" => [
				"field_checkboxes",
				"field_radios",
				"field_checkbox",
				"field_secicon",
			],
		],
	];