<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	\GApp3::document()->addJsFile('https://js.stripe.com/v3/');

	try {
		// Use Stripe's library to make requests...
		require_once(\G3\Globals::get('FRONT_PATH').'vendors'.DS.'payments'.DS.'stripe'.DS.'init.php');

		if(!empty($function['successUrl'])){
			if(is_numeric($function['successUrl'])){
				$function['successUrl'] = r3(\G3\L\Url::build($this->Parser->_url(), ['gpage' => $this->controller->FData->cdata('pages.'.$function['successUrl'].'.urlname')]), ['full' => true]);
			}
		}

		if(!empty($function['cancelUrl'])){
			if(is_numeric($function['cancelUrl'])){
				$function['cancelUrl'] = r3(\G3\L\Url::build($this->Parser->_url(), ['gpage' => $this->controller->FData->cdata('pages.'.$function['cancelUrl'].'.urlname')]), ['full' => true]);
			}
		}

		$stripe = new \Stripe\StripeClient($function['key']['secret']);

		if(!empty($function['products_provider']) AND is_numeric($function['products_provider'])){
			$function['products_provider'] = '{session:'.$this->controller->FData->cdata('functions.'.$function['products_provider'].'.cart.id').'.products}';
		}
		
		$products = $this->Parser->parse($function['products_provider']);

		$this->debug[$function['name']]['products'] = $products;

		if(empty($products) OR !is_array($products)){
			$this->errors[$function['name']] = rl3('Error getting the products list.');
			$this->set($function['name'], false);
	
			return;
		}

		$line_items = [];
		foreach($products as $product){
			$line_items[] = [
				'price_data' => [
					'currency' => $function['currency'] ?? 'USD',
					'product_data' => [
						'name' => $product['name'],
					],
					'unit_amount' => $product['price'] * 100,
				],
				'quantity' => $product['quantity'],
			];
		}

		$vars = [
			'payment_method_types' => ['card'],
			'line_items' => $line_items,
			'mode' => 'payment',
			'success_url' => $function['successUrl'],
			'cancel_url' => $function['cancelUrl'],
		];

		if(!empty($function['parameters'])){
			foreach($function['parameters'] as $parameter){
				$vars[$parameter['name']] = $this->Parser->parse($parameter['value']);
			}
		}
		
		$checkout = $stripe->checkout->sessions->create($vars);

		$this->debug[$function['name']]['checkout']['session'] = $checkout->toArray();
		$this->set($function['name'], $checkout->toArray());

		\GApp3::document()->addJsCode('
			jQuery(document).ready(function($){
				var stripe = Stripe("'.$function['key']['publishable'].'");
				jQuery("[data-uid='.$function['redirect_button'].']").find("button").first().on("click", function(e) {
					e.preventDefault();
					stripe.redirectToCheckout({ sessionId: "'.$checkout->toArray()['id'].'" });
				});
			});
		');

	} catch(\Stripe\Exception\CardException $e) {
		// Since it's a decline, \Stripe\Exception\CardException will be caught
		echo 'Status is:' . $e->getHttpStatus() . '\n';
		echo 'Type is:' . $e->getError()->type . '\n';
		echo 'Code is:' . $e->getError()->code . '\n';
		// param is '' in this case
		echo 'Param is:' . $e->getError()->param . '\n';
		echo 'Message is:' . $e->getError()->message . '\n';
	} catch (\Stripe\Exception\RateLimitException $e) {
		// Too many requests made to the API too quickly
		echo 1;
		pr3($e);
	} catch (\Stripe\Exception\InvalidRequestException $e) {
		// Invalid parameters were supplied to Stripe's API
		echo 2;
		pr3($e);
	} catch (\Stripe\Exception\AuthenticationException $e) {
		// Authentication with Stripe's API failed
		// (maybe you changed API keys recently)
		echo 3;
		pr3($e);
	} catch (\Stripe\Exception\ApiConnectionException $e) {
		// Network communication with Stripe failed
		echo 4;
		pr3($e);
	} catch (\Stripe\Exception\ApiErrorException $e) {
		// Display a very generic error to the user, and maybe send
		// yourself an email
		echo 5;
		pr3($e);
	} catch (Exception $e) {
		// Something else happened, completely unrelated to Stripe
		echo 6;
		pr3($e);
	}