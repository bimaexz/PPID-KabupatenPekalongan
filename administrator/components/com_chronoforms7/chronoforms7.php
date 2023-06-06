<?php
/**
* COMPONENT FILE HEADER
**/
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or define("GCORE_SITE", "admin");
if(!defined('DS')){
	define('DS', DIRECTORY_SEPARATOR);
}
// jimport('chronog3.joomla_chrono_g3');
require_once(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'chronog3_plg'.DS.'chronog3'.DS.'g3_loader.php');
if(!class_exists('G3Loader')){
	JError::raiseWarning(100, "Please download the ChronoG3 framework from www.chronoengine.com then install it using the 'Extensions Manager'");
	return;
}
if(!JFactory::getUser()->authorise('core.admin', 'com_chronoforms7')){
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}
$output = new G3Loader([
	'site' => 'admin',
	'alias' => 'chronoforms7',
	'extension' => 'chronoforms',
]);