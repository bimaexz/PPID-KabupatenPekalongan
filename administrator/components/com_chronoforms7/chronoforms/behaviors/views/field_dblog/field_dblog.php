<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_dblog",
		'title' => rl3("DB Log"),
		'desc' => rl3("Log value to Database"),
		'icon' => 'database',
		'category' => rl3("Database"),
		'group' => 'data',
		'default' => true,
		'triggers' => ['event'],
		'order' => -8,
		"accept" => [
			"ugroups" => ['inputs'],
		],
	];