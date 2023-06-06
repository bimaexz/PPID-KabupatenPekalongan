<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "field_secicon",
		"title" => rl3("Security Image"),
		"icon" => "image",
		"desc" => rl3(""),
		"group" => "Security",
		"ugroups" => ['security'],
		"order" => 0,
		"areas" => [],
		"apps" => ["form", "connectivity","contact"],
		"config" => ["basics" => ['label' => rl3('Select image of %s', ['%s'])]],
	];