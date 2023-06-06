<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "2co_redirect",
		"title" => rl3("2Checkout Redirect"),
		"icon" => "credit-card",
		"desc" => rl3(""),
		"group" => "Integrations",
		"order" => 0,
		"areas" => [],
		"apps" => ["form", "connectivity"],
		"paid" => 1,
		"dependencies" => [
			\G3\Globals::get('FRONT_PATH').'vendors'.DS.'payments'.DS.'2checkout'.DS.'Twocheckout.php' => rl3("ChronoForms Payments Lib is required"),
		]
	];