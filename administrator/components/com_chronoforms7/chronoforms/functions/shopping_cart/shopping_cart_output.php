<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$cart = [];
	$products = \GApp3::session()->get($function['cart']['id'].'.products', []);

	$new_products = [];
	if(!empty($function['products'])){
		foreach($function['products'] as $sk => $pdata){
			$product = [];
			foreach($pdata as $pk => $pval){
				if($pk == 'pairs'){
					if(!empty($pdata['pairs'])){
						foreach($pdata['pairs'] as $pk => $pair){
							$product = \G3\L\Arr::setVal($product, $pair['key'], $this->controller->Parser->parse($pair[$pair['type']]));
						}
					}
				}else{
					if($pk == 'quantity'){
						$pval = (int)$pval;
					}else if($pk == 'price'){
						$pval = $pval;
					}
					
					$product = \G3\L\Arr::setVal($product, $pk, $this->controller->Parser->parse($pval));
				}
			}

			$new_products[$product['id']] = $product;
		}
	}

	if(!empty($function['cart']['mode']) AND $function['cart']['mode'] == 'clear'){
		$products = [];
	}else{
		if(!empty($new_products)){
			foreach($new_products as $pid => $product){
				if(empty($product['quantity'])){
					if(isset($products[$product['id']])){
						unset($products[$product['id']]);
					}
				}else{
					$products[$product['id']] = $product;
				}
			}
		}
	}

	$total = 0;
	if(!empty($products)){
		foreach($products as $pid => $product){
			$total += (int)$product['quantity'] * (float)$product['price'];
		}
	}

	$cart['products'] = $products;
	$cart['total'] = $total;

	$this->set($function['name'], $cart);

	\GApp3::session()->set($function['cart']['id'], $cart);