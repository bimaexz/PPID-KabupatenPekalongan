<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "check_honeypot",
		"title" => rl3("Check Honeypot"),
		"icon" => "bar yellow",
		"desc" => rl3(""),
		"group" => "Security",
		"order" => 0,
		"areas" => ["success" => "green","fail" => "red",],
		"apps" => ["xforms"],
	];