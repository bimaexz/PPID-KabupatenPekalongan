<?php
/**
* COMPONENT FILE HEADER
**/
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
//basic checks
$success = array();
$fails = array();
if(version_compare(PHP_VERSION, '7.0.0') >= 0){
	$success[] = "PHP 7.0.0 or later found.";
}else{
	$fails[] = "Your PHP version is outdated: ".PHP_VERSION;
}

if(!empty($fails)){
	JError::raiseWarning(100, "Your PHP version should be 7.0 or later.");
	return;
}
//end basic checks
if(empty($fails)){
	
	require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'gcloader.php');
	
	class G3Loader extends \G3\L\AppLoader{
		
	}
}