<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "gcaptcha",
		"title" => rl3("ReCaptcha"),
		"icon" => "brands:google",
		"desc" => rl3(""),
		"group" => "Security",
		"ugroups" => ['security'],
		"order" => 0,
		"areas" => [],
		"apps" => ["form", "connectivity","contact"],
		"paid" => 1,
	];