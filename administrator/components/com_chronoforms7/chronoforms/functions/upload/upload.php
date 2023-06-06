<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "upload",
		"title" => rl3("Upload"),
		"icon" => "upload",
		"desc" => rl3(""),
		"group" => "Advanced",
		"order" => 0,
		"areas" => ["success" => "green","fail" => "red",],
		"apps" => ["form", "connectivity"],
	];