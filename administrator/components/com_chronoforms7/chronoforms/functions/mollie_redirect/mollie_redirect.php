<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "mollie_redirect",
		"title" => rl3("Mollie Redirect"),
		"icon" => "credit-card",
		"desc" => rl3(""),
		"group" => "Integrations",
		"order" => 0,
		"areas" => [],
		"apps" => ["form", "connectivity"],
		"paid" => 1,
		"dependencies" => [
			\G3\Globals::get('FRONT_PATH').'vendors'.DS.'payments'.DS.'mollie'.DS.'vendor'.DS.'autoload.php' => rl3("ChronoForms Payments Lib is required"),
		]
	];