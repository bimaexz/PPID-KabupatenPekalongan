<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "list_table_styles",
		'title' => rl3("Table Styles"),
		'icon' => 'brush',
		'desc' => rl3("Special styles for Listing Table"),
		'group' => 'list_table',
		'category' => rl3("Style"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"views" => [
				"list_table",
			],
		],
	];