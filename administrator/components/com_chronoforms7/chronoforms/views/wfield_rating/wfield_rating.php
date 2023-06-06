<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "wfield_rating",
		"title" => rl3("Rating"),
		"icon" => "star",
		"desc" => rl3(""),
		"group" => "Fields",
		"ugroups" => ['inputs'],
		"order" => 0,
		"areas" => [],
		"apps" => ["formx","contactx"],
		"config" => ["basics" => true],
		"paid" => 1,
	];