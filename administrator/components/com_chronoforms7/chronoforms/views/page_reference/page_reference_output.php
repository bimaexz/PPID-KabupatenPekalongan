<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$page = $view['page_uid'];//$this->controller->FData->cdata('pids.'.$view['page_uid']);
	
	$this->controller->Page->stopped = false;//if the stopped flag is on then turn it off to allow this page to be processed

	echo $this->controller->Page->event($page, ['inline' => true]);
	$this->controller->FData->cdata('pages.'.$page.'.chronopage.disabled', true, true);
	echo $this->controller->viewer->Parser->section($page);