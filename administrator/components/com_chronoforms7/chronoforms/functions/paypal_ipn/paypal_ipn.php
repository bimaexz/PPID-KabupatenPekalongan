<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "paypal_ipn",
		"title" => rl3("PayPal IPN"),
		"icon" => "paypal blue",
		"desc" => rl3(""),
		"group" => "Payments",
		"order" => 0,
		"areas" => ["success" => "green","pending" => "black","denied" => "black","expired" => "black","failed" => "black","refunded" => "black","reversed" => "black","fail" => "red",],
		"apps" => ["xforms"],
	];