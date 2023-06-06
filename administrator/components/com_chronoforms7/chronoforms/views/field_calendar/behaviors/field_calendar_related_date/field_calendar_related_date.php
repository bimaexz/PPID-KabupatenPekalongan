<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_calendar_related_date",
		'title' => rl3("Related Calendar"),
		'icon' => 'calendar',
		'desc' => rl3("Connect to another Calendar"),
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