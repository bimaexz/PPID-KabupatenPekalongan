<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "list_table_sortables",
		'title' => rl3("Sortables"),
		'icon' => 'sort',
		'desc' => rl3("Choose sortable fields"),
		'group' => 'list_table',
		'category' => rl3("Advanced"),
		'triggers' => ['event'],
		'order' => -1,
		"accept" => [
			"views" => [
				"list_table",
			],
		],
	];