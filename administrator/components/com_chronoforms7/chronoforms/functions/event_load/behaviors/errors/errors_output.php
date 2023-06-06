<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['errors'])){
		foreach(array_reverse($unit['errors']) as $error){
			$this->controller->Page->errors[] = $error['text'];
		}
	}