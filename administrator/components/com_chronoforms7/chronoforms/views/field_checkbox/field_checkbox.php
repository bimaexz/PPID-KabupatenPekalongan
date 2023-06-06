<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "field_checkbox",
		"title" => rl3("Checkbox"),
		"icon" => "check-square",
		"desc" => rl3(""),
		"group" => "Fields",
		"ugroups" => ['inputs'],
		"order" => 0,
		"areas" => [],
		"apps" => ["form", "connectivity","contact"],
		"config" => ["basics" => true],
	];