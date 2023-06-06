<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "view_reload",
		'title' => rl3("Reload"),
		'icon' => 'sync',
		'desc' => rl3("Configure the element reload settings"),
		'group' => 'html',
		'category' => rl3("Advanced"),
		'triggers' => ['before_view_build'],
		'order' => 0,
		"accept" => [
			"views" => true,
		],
		"not_accept" => [
			"ugroups" => ['hidden'],
			"views" => [
				'unit_reference',
				'area_group',
				'area_form',
			]
		],
	];