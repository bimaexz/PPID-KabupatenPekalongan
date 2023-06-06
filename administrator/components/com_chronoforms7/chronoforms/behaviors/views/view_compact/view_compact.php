<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "view_compact",
		'title' => rl3("Compact"),
		'icon' => 'compress-alt',
		'desc' => rl3("Element takes just the size on its contents"),
		'group' => 'html',
		'category' => rl3("Style"),
		'triggers' => ['before_view'],
		'order' => -9,
		"accept" => [
			"views" => [
				"area_message",
				"area_segment",
				"field_button",
				"menu",
			],
		],
	];