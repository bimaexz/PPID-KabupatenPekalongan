<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "area_partitions",
		"title" => rl3("Partitions"),
		"icon" => "clone blue",
		"desc" => rl3(""),
		"group" => "Areas",
		"ugroups" => ['areas'],
		"order" => 0,
		"areas" => ["part1" => "blue","part2" => "blue",],
		"apps" => ["xforms"],
	];