<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	// $function['models']['data']['settings']['duplicate_update'] = true;
	
	$result = $this->controller->Models->save($function['models']['data']);

	if($result){
		$this->set($function['name'], $result);
		$this->fevents[$function['name']]['success'] = true;
		$this->debug[$function['name']]['result'] = rl3('Data saved successfully!');
	}else{
		$this->set($function['name'], $result);
		$this->fevents[$function['name']]['fail'] = true;
		$this->debug[$function['name']]['result'] = rl3('Data save failed!');
	}

	$this->debug[$function['name']]['dataset'] = $this->controller->Models->dataset;
	$this->debug[$function['name']]['log'] = $this->controller->Models->log;