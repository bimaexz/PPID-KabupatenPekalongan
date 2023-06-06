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
class Helper {
	use \G3\L\T\GetSet;
	
	var $controller = null;
	var $viewer = null;
	var $_vars = array();
	var $data = array();
	var $params = array();
	
	function __construct(&$viewer, $config = []){
		$this->viewer = &$viewer;
		$this->_vars = &$viewer->_vars;
		$this->data = &$viewer->data;
		
		if(!empty($config)){
			foreach($config as $k => $v){
				$this->$k = $v;
			}
		}
	}

	function initialize(){
		
	}
}