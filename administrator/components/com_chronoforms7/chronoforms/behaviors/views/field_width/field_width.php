<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_width",
		'title' => rl3("Field Width"),
		'icon' => 'columns',
		'desc' => rl3("The width of the field"),
		'group' => 'html',
		'category' => rl3("Settings"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"ugroups" => ['inputs','actions'],
		],
	];