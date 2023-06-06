<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($function['form_page'])){
		$this->event($this->controller->FData->cdata('pages.'.$function['form_page'].'.pageid'));
	}
	
	if(!empty($function['stop'])){
		$this->stopped = true;
	}