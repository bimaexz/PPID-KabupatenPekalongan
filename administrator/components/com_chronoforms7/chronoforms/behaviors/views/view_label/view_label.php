<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "view_label",
		'title' => rl3("Label"),
		'icon' => 'font',
		'desc' => rl3("Add Label to this Unit"),
		'group' => 'configs',
		'category' => rl3("Settings"),
		'triggers' => [],
		'order' => 0,
		"accept" => [
			"views" => [
				'html_code',
				'field_button',
				"progress",
			],
		],
	];