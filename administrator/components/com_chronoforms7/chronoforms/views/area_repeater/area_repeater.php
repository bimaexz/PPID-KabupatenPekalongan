<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "area_repeater",
		"title" => rl3("Repeater"),
		"icon" => "th-list",
		"desc" => rl3(""),
		"group" => "Areas",
		"ugroups" => ['areas'],
		"order" => 0,
		"areas" => ["loop" => "blue"],
		"apps" => ["form", "connectivity","contact"],
	];