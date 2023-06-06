<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_button_toolbar",
		'title' => rl3("ToolBar Settings"),
		'icon' => 'ellipsis-h',
		'desc' => rl3("Configure settings for type TOOlBAR button"),
		'group' => 'field_button',
		'category' => rl3("Button Settings"),
		'triggers' => ['before_view'],
		'order' => -10,
		"accept" => [
			"views" => [
				"field_button",
			],
		],
	];