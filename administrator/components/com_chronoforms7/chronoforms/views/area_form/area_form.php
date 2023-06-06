<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "area_form",
		"title" => rl3("Form"),
		"icon" => "box",
		"desc" => rl3(""),
		"group" => "Areas",
		"ugroups" => ['areas'],
		"order" => 0,
		"areas" => ["body" => "blue"],
		"apps" => ["form", "connectivity","contact"],
	];