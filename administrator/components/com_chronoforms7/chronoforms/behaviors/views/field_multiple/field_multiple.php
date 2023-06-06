<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_multiple",
		'title' => rl3("Multi Selection"),
		'desc' => rl3("Enable multiple selections"),
		'group' => 'configs',
		'category' => rl3("Settings"),
		'icon' => 'ellipsis-v',
		'triggers' => ['before_view'],
		'order' => -9,
		"accept" => [
			"views" => [
				"field_file",
				"field_select",
			],
		],
	];