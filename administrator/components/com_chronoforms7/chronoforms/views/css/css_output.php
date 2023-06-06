<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($view['files'])){
		if(!empty($view['files'])){
			foreach($view['files'] as $file){
				\GApp3::document()->addCssFile($file['url']);
			}
		}
	}

	$css = $this->Parser->parse($view['content']);
	\GApp3::document()->addCssCode($css);