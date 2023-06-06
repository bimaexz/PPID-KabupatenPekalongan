<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "sql_data",
		"title" => rl3("SQL Data"),
		"icon" => "server",
		"desc" => rl3(""),
		"group" => "Database",
		"ugroups" => ['dsources'],
		"order" => 0,
		"areas" => ["success" => "green","fail" => "red",],
		"apps" => ["form", "connectivity","contact"],
		"paid" => 1,
	];