<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "view_color",
		'title' => rl3("Color"),
		'icon' => 'brush',
		'desc' => rl3("Set the element color"),
		'group' => 'html',
		'category' => rl3("Style"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"views" => [
				"area_message",
				"area_segment",
				"area_partitions",
				"field_button",
				"wfield_rating",
				"header",
				"list_table",
				"text_node",
				"icon_node",
				"menu",
				"progress",
			],
		],
	];