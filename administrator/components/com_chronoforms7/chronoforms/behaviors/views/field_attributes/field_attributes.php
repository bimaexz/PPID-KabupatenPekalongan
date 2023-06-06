<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_attributes",
		'title' => rl3("HTML Tag Attributes"),
		'icon' => 'screwdriver',
		'desc' => rl3("Add, Modify or Override the HTML tag attributes"),
		'group' => 'html',
		'category' => rl3("Advanced"),
		'triggers' => [],
		'order' => 0,
		"accept" => [
			"views" => [
				true
			],
		],
		"not_accept" => [
			"views" => [
				'unit_reference',
				'area_group',
				// 'area_form',
			]
		],
	];