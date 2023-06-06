<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['css']['files'])){
		if(!empty($unit['css']['files'])){
			foreach($unit['css']['files'] as $file){
				\GApp3::document()->addCssFile($file['url']);
			}
		}
	}

	$css = $this->controller->Parser->parse($unit['css']['content']);
	\GApp3::document()->addCssCode($css);