<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\A\E\Chronoforms\L;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Locales extends \G3\L\Component{
	var $locales = [];

	var $_models = ['\G3\A\E\Chronoforms\M\Locale'];

	function list(){
		if(empty($this->locales)){
			$this->locales = $this->Locale->fields(['id', 'title', 'alias', 'enabled'])->order(['id' => 'asc'])->where('enabled', 1)->select('all');
			
			return $this->locales;
		}else{
			return $this->locales;
		}
	}

}