<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	try {
		require_once(\G3\Globals::get('FRONT_PATH').'vendors'.DS.'payments'.DS.'mollie'.DS.'vendor'.DS.'autoload.php');

		$mollie = new \Mollie\Api\MollieApiClient();
		if(empty($function['live'])){
			$mollie->setApiKey($function['api_test']);
		}else{
			$mollie->setApiKey($function['api_live']);
		}

		$payment = $mollie->payments->get($this->data('id'));

		$this->set($function['name'], $payment);
	
		if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
			/*
			 * The payment is paid and isn't refunded or charged back.
			 * At this point you'd probably want to start the process of delivering the product to the customer.
			 */
			$this->fevents[$function['name']]['complete'] = 1;
		} elseif ($payment->isOpen()) {
			/*
			 * The payment is open.
			 */
			$this->fevents[$function['name']]['open'] = 1;
		} elseif ($payment->isPending()) {
			/*
			 * The payment is pending.
			 */
			$this->fevents[$function['name']]['pending'] = 1;
		} elseif ($payment->isFailed()) {
			/*
			 * The payment has failed.
			 */
			$this->fevents[$function['name']]['failed'] = 1;
		} elseif ($payment->isExpired()) {
			/*
			 * The payment is expired.
			 */
			$this->fevents[$function['name']]['expired'] = 1;
		} elseif ($payment->isCanceled()) {
			/*
			 * The payment has been canceled.
			 */
			$this->fevents[$function['name']]['canceled'] = 1;
		} elseif ($payment->hasRefunds()) {
			/*
			 * The payment has been (partially) refunded.
			 * The status of the payment is still "paid"
			 */
			$this->fevents[$function['name']]['refunds'] = 1;
		} elseif ($payment->hasChargebacks()) {
			/*
			 * The payment has been (partially) charged back.
			 * The status of the payment is still "paid"
			 */
			$this->fevents[$function['name']]['chargebacks'] = 1;
		}
	} catch (\Mollie\Api\Exceptions\ApiException $e) {
		echo '<div class="ui message red">API call failed: '.htmlspecialchars($e->getMessage()).'</div>';
	}