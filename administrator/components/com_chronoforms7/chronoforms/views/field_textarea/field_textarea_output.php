<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($view['nodes']['main']['attrs']['data-editor'])){
		\GApp3::document()->_('tinymce');
	}

	$view['nodes']['main']['tag'] = 'textarea';

	echo $this->Field->build($view);