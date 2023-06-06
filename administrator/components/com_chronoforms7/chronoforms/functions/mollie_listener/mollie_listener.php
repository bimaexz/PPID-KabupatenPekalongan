<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "mollie_listener",
		"title" => rl3("Mollie Listener"),
		"icon" => "credit-card",
		"desc" => rl3(""),
		"group" => "Integrations",
		"order" => 0,
		"areas" => ["complete" => "green","open" => "red","pending" => "red","failed" => "red","expired" => "red","canceled" => "red","refunds" => "red","chargebacks" => "red"],
		"apps" => ["form", "connectivity"],
		"dependencies" => [
			\G3\Globals::get('FRONT_PATH').'vendors'.DS.'payments'.DS.'mollie'.DS.'vendor'.DS.'autoload.php' => rl3("ChronoForms Payments Lib is required"),
		]
	];