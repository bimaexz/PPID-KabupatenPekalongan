<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "field_textarea",
		"title" => rl3("Textarea"),
		"icon" => "align-justify",
		"desc" => rl3(""),
		"group" => "Fields",
		"ugroups" => ['inputs'],
		"order" => 0,
		"areas" => [],
		"apps" => ["form", "connectivity","contact"],
		"config" => ["basics" => true],
	];