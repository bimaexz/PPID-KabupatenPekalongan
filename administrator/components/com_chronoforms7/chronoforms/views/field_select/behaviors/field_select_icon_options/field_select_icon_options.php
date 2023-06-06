<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_select_icon_options",
		'title' => rl3("Icon Options"),
		'icon' => 'adjust',
		'desc' => rl3("Enable options icons"),
		'group' => 'field_select',
		'category' => rl3("Dropdown Settings"),
		'triggers' => ['before_view'],
		'order' => 0,
		"accept" => [
			"views" => [
				"field_select",
			],
		],
		"paid" => 1,
	];