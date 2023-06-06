<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($this->get($unit['name']))){
		if($unit['type'] == 'read_data'){
			if($unit['models']['data']['select'] == 'first'){
				$output = $this->controller->Parser->dataLoad($output, $this->get($unit['name']));
			}else if($unit['models']['data']['select'] == 'all'){
				$list = [];
				foreach($this->get($unit['name']) as $k => $result){
					foreach($result as $model => $mdata){
						$list[$model][$k] = $mdata;
					}
				}
				
				$output = $this->controller->Parser->dataLoad($output, $list);
			}
		}else{
			$output = $this->controller->Parser->dataLoad($output, $this->get($unit['name']));
		}
	}