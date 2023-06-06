<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "secicon",
		"title" => rl3("Security Image"),
		"icon" => "image",
		"desc" => rl3(""),
		"group" => "Security",
		"order" => 0,
		"areas" => ["success" => "green","fail" => "red",],
		"apps" => ["xforms"],
	];