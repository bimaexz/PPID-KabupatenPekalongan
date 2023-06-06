<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$view['nodes']['checkbox']['active'] = true;

	if(strlen($view['nodes']['main']['attrs']['checked'])){
		if($view['nodes']['main']['attrs']['checked'] != 'checked'){
			$checked = $this->Parser->parse($view['nodes']['main']['attrs']['checked']);
			$value = $this->Parser->parse($view['nodes']['main']['attrs']['value']);

			if($checked !== $value){
				unset($view['nodes']['main']['attrs']['checked']);
			}
		}
	}
	
	echo $this->Field->build($view);