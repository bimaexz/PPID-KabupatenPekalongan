<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "group",
		"title" => rl3("Group"),
		"icon" => "boxes",
		"desc" => rl3(""),
		"group" => "Basics",
		"ugroups" => [],
		"order" => 0,
		"areas" => ["actions" => "blue",],
		"apps" => ["form", "connectivity","contact"],
	];