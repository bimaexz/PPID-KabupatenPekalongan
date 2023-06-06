<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$process = function($result, $special){
		$type = $special['type'];
		$value = \G3\L\Arr::getVaL($result, $special['field']);

		if($type == 'json_decode'){
			return json_decode($value, true);
		}else if($type == 'complex'){
			return $this->controller->Parser->parse($special['p1']);
		}

		return $value;
	};

	if(!empty($unit['models']['data']['specials']) AND !empty($this->get($unit['name']))){
		foreach($unit['models']['data']['specials'] as $special){
			if(!empty($special['field']) AND !empty($special['type'])){
				if($unit['models']['data']['select'] == 'first'){
					$result = $this->get($unit['name']);
					foreach($result as $model => $mdata){
						$this->set($model, $mdata);
					}

					$result = \G3\L\Arr::setVaL($result, $special['field'], $process($result, $special));

					$this->set($unit['name'], $result);
				}else{
					$results = $this->get($unit['name']);
					foreach($results as $rk => $result){
						foreach($result as $model => $mdata){
							$this->set($model, $mdata);
						}
						$value = \G3\L\Arr::getVaL($result, $special['field']);
						$results = \G3\L\Arr::setVaL($results, $rk.'.'.$special['field'], $process($result, $special));
						foreach($result as $model => $mdata){
							$this->set($model, null);
						}
					}

					$this->set($unit['name'], $results);
				}
			}
		}
	}