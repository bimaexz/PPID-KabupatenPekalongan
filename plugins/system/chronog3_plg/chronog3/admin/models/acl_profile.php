<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\A\M;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class AclProfile extends \G3\L\Model {
	var $tablename = '#ce__acl_profiles';
	
	public function validate($data = array(), $new = false, $list = []){
		$return = true;
		if(empty($data['title'])){
			$return = false;
			$this->errors['title'] = rl3('ACL Profile title is required.');
		}
		
		return $return;
	}
}