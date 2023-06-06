<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "stripe",
		"title" => rl3("Stripe Checkout"),
		"icon" => "brands:stripe",
		"desc" => rl3(""),
		"group" => "Integrations",
		"order" => 0,
		"areas" => [],
		"apps" => ["form", "connectivity"],
		"paid" => 1,
		"dependencies" => [
			\G3\Globals::get('FRONT_PATH').'vendors'.DS.'payments'.DS.'stripe'.DS.'init.php' => rl3("ChronoForms Payments Lib is required"),
		]
	];