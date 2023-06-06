<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_variable",
		'title' => rl3("Variable Field"),
		'desc' => rl3("Override the field value and disable it"),
		'group' => 'field_hidden',
		'category' => rl3("Advanced"),
		'icon' => 'terminal',
		'triggers' => ['event', 'new_event_start'],
		'order' => 0,
		"accept" => [
			"views" => [
				"field_hidden",
			],
		],
		"paid" => 1,
	];