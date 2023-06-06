<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_disabled",
		'title' => rl3("Disabled"),
		'desc' => rl3("Load this field in disabled state"),
		'group' => 'html',
		'category' => rl3("Advanced"),
		'icon' => 'lock',
		'triggers' => ['initialize_event'],
		'order' => 0,
		"accept" => [
			"ugroups" => ['inputs'],
		],
		"not_accept" => [
			"ugroups" => ['hidden'],
		],
	];