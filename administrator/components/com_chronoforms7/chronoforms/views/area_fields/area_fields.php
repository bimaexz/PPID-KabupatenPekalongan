<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "area_fields",
		"title" => rl3("Multi Field"),
		"icon" => "ellipsis-h",
		"desc" => rl3(""),
		"group" => "Areas",
		"ugroups" => ['areas'],
		"order" => 0,
		"areas" => ["body" => "blue",],
		"apps" => ["form", "connectivity","contact"],
		"paid" => 1,
	];