<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "joomla_user",
		"title" => rl3("Save User"),
		"icon" => "user-plus",
		"desc" => rl3(""),
		"group" => "Joomla",
		"order" => 0,
		"areas" => ["success" => "green","fail" => "red","user_exists" => "red",],
		"apps" => ["form", "connectivity"],
		"paid" => 1,
	];