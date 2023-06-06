<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "view_alignment",
		'title' => rl3("Text Alignment"),
		'icon' => 'align-center',
		'desc' => rl3("Set the text alignment of the element"),
		'group' => 'html',
		'category' => rl3("Style"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"views" => [
				"area_container",
				"header",
			],
		],
	];