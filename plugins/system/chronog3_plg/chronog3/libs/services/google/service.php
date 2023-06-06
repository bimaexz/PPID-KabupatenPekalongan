<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\L\Services\Google;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Service {
	use \G3\L\T\GetSet;
	
	var $_vars = [];
	var $data = [];

	var $httpClient;
	var $errors = [];
	var $status = 0;
	var $msgs = [];
	
	function __construct($settings){
		if(empty($settings['scopes'])){
			$settings['scopes'] = $this->scopes;
		}
		$this->httpClient = \G3\L\Services\Google\Auth::httpClient($settings);
		return $this;
	}
	
}