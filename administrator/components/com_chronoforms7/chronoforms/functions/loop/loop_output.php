<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$items = $this->Parser->parse($function['data_provider']);
	// $keys = $this->Parser->parse($function['keys_provider']);
	
	if(is_numeric($items)){
		$items = range(0, (int)$items);
	}
	
	$return = '';
	
	if(is_array($items)){
		foreach($items as $key => $item){
			// if(is_array($keys) AND !in_array($key, $keys)){
			// 	continue;
			// }

			$this->set($function['name'].'.value', $item);
			$this->set($function['name'].'.key', $key);
			
			echo $this->event($function['uid'].'/body', true);
		}
	}