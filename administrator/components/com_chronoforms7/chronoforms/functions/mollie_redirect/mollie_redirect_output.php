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

		if(!empty($function['parameters'])){
			foreach($function['parameters'] as $parameter){
				$function['payment']['metadata'][$parameter['name']] = $parameter['value'];
			}
		}

		array_walk_recursive($function['payment'], function(&$item, $key){
			$item = $this->Parser->parse($item);
		});

		if(!empty($function['payment']['amount']['value'])){
			$function['payment']['amount']['value'] = number_format((float)$function['payment']['amount']['value'], 2);
		}

		if(!empty($function['payment']['redirectUrl'])){
			if(is_numeric($function['payment']['redirectUrl'])){
				$function['payment']['redirectUrl'] = r3(\G3\L\Url::build($this->Parser->_url(), ['gpage' => $this->controller->FData->cdata('pages.'.$function['payment']['redirectUrl'].'.urlname')]), ['full' => true]);
			}
		}

		if(!empty($function['payment']['webhookUrl'])){
			if(is_numeric($function['payment']['webhookUrl'])){
				$function['payment']['webhookUrl'] = r3(\G3\L\Url::build($this->Parser->_url(), ['gpage' => $this->controller->FData->cdata('pages.'.$function['payment']['webhookUrl'].'.urlname')]), ['full' => true, 'ssl' => true]);
			}
		}

		$vars = $function['payment'];

		if(!empty($function['parameters'])){
			foreach($function['parameters'] as $parameter){
				$vars[$parameter['name']] = $this->Parser->parse($parameter['value']);
			}
		}

		$this->debug[$function['name']]['vars'] = $vars;

		$payment = $mollie->payments->create($vars);

		$url = $payment->getCheckoutUrl();

		if(!empty($function['debug'])){
			echo $url;
			$this->debug[$function['name']]['data'] = $function['payment'];
		}else{
			$this->Parser->end();

			if(empty($function['form_end_behavior'])){
				$active_page = $this->controller->FData->sessiondata('pages.active');
				$this->controller->Page->event_finish($active_page);
			}
			
			if(empty(\GApp3::instance()->tvout)){
				\G3\L\Env::redirect($url);
			}else{
				echo '
				<script type="text/javascript">
					jQuery(document).ready(function($){
						window.location = "'.r3($url, false, true).'";
					});
				</script>';
			}
		}
	} catch (\Mollie\Api\Exceptions\ApiException $e) {
		echo '<div class="ui message red">API call failed: '.htmlspecialchars($e->getMessage()).'</div>';
	}