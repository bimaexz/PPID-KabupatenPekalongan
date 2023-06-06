<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_select_autocomplete",
		'title' => rl3("Auto Complete"),
		'icon' => 'keyboard',
		'desc' => rl3("Enable Option text auto completion"),
		'group' => 'field_select',
		'category' => rl3("Dropdown Settings"),
		'triggers' => ['before_view_build'],
		'order' => 0,
		"accept" => [
			"views" => [
				"field_select",
			],
		],
		"paid" => 1,
	];