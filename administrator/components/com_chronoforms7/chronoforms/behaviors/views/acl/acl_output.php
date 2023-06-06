<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!$this->controller->FData->acl($unit)){
		// $this->controller->FData->deny($unit);
		$unit['invalid'] = true;
	}