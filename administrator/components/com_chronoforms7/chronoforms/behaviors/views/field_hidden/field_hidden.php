<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_hidden",
		'title' => rl3("Hidden"),
		'desc' => rl3("Load this unit in hidden state"),
		'group' => 'html',
		'category' => rl3("Advanced"),
		'icon' => 'eye-slash',
		'triggers' => ['before_view'],
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
				'header',
				'html_code',
			]
		],
	];