<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_value_placeholder",
		'title' => rl3("Value & Placeholder"),
		'icon' => 'edit',
		'desc' => rl3("Value and Placeholder Settings"),
		'group' => 'configs',
		'category' => rl3("Settings"),
		'triggers' => [],
		'order' => -10,
		"accept" => [
			"views" => [
				"field_password",
				"field_text",
				"field_textarea",
				"field_calendar",
			],
		],
	];