<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "google_sheets_write",
		"title" => rl3("Google Sheets Write"),
		"icon" => "brands:google",
		"desc" => rl3(""),
		"group" => "Integrations",
		"order" => 0,
		"areas" => ["success" => "green","fail" => "red",],
		"apps" => ["form", "connectivity"],
		"paid" => 1,
		"dependencies" => [
			\G3\Globals::get('FRONT_PATH').'vendors'.DS.'google'.DS.'vendor'.DS.'autoload.php' => rl3("ChronoForms Google API Lib is required"),
		]
	];