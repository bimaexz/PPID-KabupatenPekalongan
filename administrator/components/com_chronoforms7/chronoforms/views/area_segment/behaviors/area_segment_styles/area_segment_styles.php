<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "area_segment_styles",
		'title' => rl3("Segment Styles"),
		'icon' => 'brush',
		'desc' => rl3("Special styles for Area Segment"),
		'group' => 'area_segment',
		'category' => rl3("Style"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"views" => [
				"area_segment",
			],
		],
	];