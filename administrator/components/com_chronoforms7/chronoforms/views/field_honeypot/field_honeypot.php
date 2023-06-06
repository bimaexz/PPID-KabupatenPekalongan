<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "field_honeypot",
		"title" => rl3("Honeypot"),
		"icon" => "bar yellow",
		"desc" => rl3(""),
		"group" => "Security Fields",
		"ugroups" => ['security'],
		"order" => 0,
		"areas" => [],
		"apps" => ["xforms"],
	];