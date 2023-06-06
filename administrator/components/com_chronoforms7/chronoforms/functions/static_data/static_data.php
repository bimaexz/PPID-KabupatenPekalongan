<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "static_data",
		"title" => rl3("Static Data"),
		"icon" => "table",
		"desc" => rl3(""),
		"group" => "Database",
		"ugroups" => ['dsources'],
		"order" => 0,
		// "areas" => ["found" => "green", "not_found" => "red"],
		"apps" => ["form", "connectivity","contact"],
	];