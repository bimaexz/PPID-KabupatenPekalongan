<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "tcpdf",
		"title" => rl3("TCPDF Export"),
		"icon" => "regular:file-pdf",
		"desc" => rl3(""),
		"group" => "Advanced",
		"order" => 0,
		"areas" => [],
		"apps" => ["form", "connectivity"],
		"paid" => 1,
		"dependencies" => [
			\G3\Globals::get('FRONT_PATH').'vendors'.DS.'tcpdf'.DS.'tcpdf.php' => rl3("ChronoForms TCPDF Lib is required"),
		]
	];