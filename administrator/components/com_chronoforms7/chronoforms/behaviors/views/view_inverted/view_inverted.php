<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "view_inverted",
		'title' => rl3("Inverted"),
		'icon' => 'adjust',
		'desc' => rl3("Invert the element colors"),
		'group' => 'html',
		'category' => rl3("Style"),
		'triggers' => ['before_view'],
		'order' => -9,
		"accept" => [
			"views" => [
				"area_segment",
				"area_modal",
				"header",
				"list_table",
				"icon_node",
				"area_popup",
				"menu",
				"progress",
			],
		],
	];