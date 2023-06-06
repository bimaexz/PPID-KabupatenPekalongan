<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['localvars'])){
		foreach($unit['localvars'] as $local){
			$this->set('_localvars_.'.$local['name'], $this->controller->Parser->parse($local['value']));
		}
	}