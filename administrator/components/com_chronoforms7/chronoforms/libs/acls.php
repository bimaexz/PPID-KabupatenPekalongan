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
class Acls extends \G3\L\Component{
	var $acls = [];

	var $_models = ['\G3\A\M\AclProfile'];

	function list(){
		if(empty($this->acls)){
			$this->acls = $this->AclProfile->fields(['id', 'title', 'alias', 'enabled'])->order(['id' => 'asc'])->where('enabled', 1)->select('all');
			
			return $this->acls;
		}else{
			return $this->acls;
		}
	}

}