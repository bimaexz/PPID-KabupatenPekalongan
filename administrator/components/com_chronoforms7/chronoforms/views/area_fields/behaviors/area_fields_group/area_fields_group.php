<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "area_fields_group",
		'title' => rl3("Group Settings"),
		'icon' => 'font',
		'desc' => rl3("Customize the appearance of the fields group"),
		'group' => 'area_fields',
		'category' => rl3("Style"),
		'triggers' => ['before_view'],
		'order' => -9,
		"accept" => [
			"views" => [
				"area_fields",
			],
		],
	];