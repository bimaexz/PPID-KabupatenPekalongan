<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_calendar_date_limits",
		'title' => rl3("Date Limits"),
		'icon' => 'stopwatch',
		'desc' => rl3("Set Start & End Dates"),
		'group' => 'field_calendar',
		'category' => rl3("Calendar Settings"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"views" => [
				"field_calendar",
			],
		],
	];