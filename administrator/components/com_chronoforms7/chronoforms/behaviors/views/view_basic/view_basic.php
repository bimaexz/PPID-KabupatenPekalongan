<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "view_basic",
		'title' => rl3("Basic"),
		'icon' => 'border-style',
		'desc' => rl3("Give the element a basic style"),
		'group' => 'html',
		'category' => rl3("Style"),
		'triggers' => ['before_view'],
		'order' => -9,
		"accept" => [
			"views" => [
				"area_segment",
				"area_modal",
				"area_popup",
			],
		],
	];