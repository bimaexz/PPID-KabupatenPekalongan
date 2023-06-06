<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\L;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Boot {
	
	function __construct(){
		self::initialize();
		
		\G3\Globals::set('FRONT_URL', \G3\L\Url::root());
		\G3\Globals::set('ADMIN_URL', \G3\L\Url::root().'admin/');
		\G3\Globals::set('ROOT_URL', \G3\Globals::get('FRONT_URL'));
		
		\G3\Globals::set('ROOT_PATH', dirname(dirname(__FILE__)).DS);
		
		\G3\Globals::set('CURRENT_PATH', \G3\Globals::get(''.strtoupper(GCORE_SITE).'_PATH'));
		\G3\Globals::set('CURRENT_URL', \G3\Globals::get(''.strtoupper(GCORE_SITE).'_URL'));
	}
	
	function initialize(){
		//CONSTANTS
		\G3\Globals::set('FRONT_PATH', dirname(dirname(__FILE__)).DS);
		\G3\Globals::set('ADMIN_PATH', dirname(dirname(__FILE__)).DS.'admin'.DS);
		//initialize language
		\G3\L\Lang::initialize();
		//SET ERROR CONFIG
		if((int)\G3\L\Config::get('error.reporting') != 1){
			error_reporting((int)\G3\L\Config::get('error.reporting'));
		}
		if((bool)\G3\L\Config::get('error.debug') === true){
			\G3\L\Error::initialize();
		}
		//timezone
		date_default_timezone_set(\G3\L\Config::get('site.timezone', 'UTC'));
	}
}