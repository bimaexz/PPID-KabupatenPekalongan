<?php
/**
* COMPONENT FILE HEADER
**/
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or define("GCORE_SITE", "front");
if(!defined('DS')){
	define('DS', DIRECTORY_SEPARATOR);
}
require_once(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'chronog3_plg'.DS.'chronog3'.DS.'g3_loader.php');
if(!class_exists('G3Loader')){
	JError::raiseWarning(100, "Please download the ChronoG3 framework from www.chronoengine.com then install it using the 'Extensions Manager'");
	return;
}

$app = \JFactory::getApplication();
//$mparams = $mainframe->getPageParameters('com_chronoforms7');

$menu = $app->getMenu();
$active = $menu->getActive();

if(!empty($active->id)){
	$itemId = $active->id;
	$mparams = $menu->getParams($itemId);

	$connection = $mparams->get('form_name', '');
	$extra = $mparams->get('form_params', '');
	$params = [];
	if(!empty($connection)){
		if(!empty($extra)){
			parse_str($extra, $params);
			foreach($params as $pk => $pv){
				\G3\L\Request::set($pk, $pv);
			}
		}
		$vars = array_merge(array('chronoform' => $connection), $params);
	}
}

$output = new G3Loader([
	'site' => 'front',
	'alias' => 'chronoforms7',
	'extension' => 'chronoforms',
	'vars' => $vars ?? [],
]);