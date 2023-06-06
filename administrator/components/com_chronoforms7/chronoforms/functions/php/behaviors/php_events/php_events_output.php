<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['areas'])){
		foreach($unit['areas'] as $ak => $area){
			if(!empty($area['value']) AND ($this->get($unit['name']) == $area['value'])){
				$this->controller->Page->fevents[$unit['name']][$area['name']] = true;
			}
		}
	}