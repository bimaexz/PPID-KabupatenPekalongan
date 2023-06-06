<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "2co_listener",
		"title" => rl3("2Checkout Listener"),
		"icon" => "credit-card",
		"desc" => rl3(""),
		"group" => "Integrations",
		"order" => 0,
		"areas" => ["order_created" => "green","fraud_status_changed" => "red","invoice_status_changed" => "red","ship_status_changed" => "red","refund_issued" => "red","recurring_stopped" => "red","recurring_restarted" => "red","recurring_installment_success" => "red","recurring_installment_failed" => "red","recurring_complete" => "red","fail" => "red",],
		"apps" => ["form", "connectivity"],
		"dependencies" => [
			\G3\Globals::get('FRONT_PATH').'vendors'.DS.'payments'.DS.'2checkout'.DS.'Twocheckout.php' => rl3("ChronoForms Payments Lib is required"),
		]
	];