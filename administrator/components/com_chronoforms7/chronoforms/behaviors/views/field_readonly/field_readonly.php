<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_readonly",
		'title' => rl3("Read Only"),
		'desc' => rl3("Set this field read only"),
		'group' => 'configs',
		'category' => rl3("Settings"),
		'icon' => 'keyboard',
		'triggers' => ['before_view'],
		'order' => 9,
		"accept" => [
			"views" => [
				"field_text",
				"field_textarea",
			],
		],
	];