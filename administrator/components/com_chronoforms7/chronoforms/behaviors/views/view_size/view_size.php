<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "view_size",
		'title' => rl3("Size"),
		'icon' => 'box',
		'desc' => rl3("Change the element size"),
		'group' => 'html',
		'category' => rl3("Style"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"views" => [
				"area_message",
				"area_modal",
				"area_partitions",
				"field_button",
				"field_calendar",
				"wfield_rating",
				"list_table",
				"text_node",
				"icon_node",
				"area_popup",
				"area_form",
				"menu",
				"progress",
			],
		],
	];