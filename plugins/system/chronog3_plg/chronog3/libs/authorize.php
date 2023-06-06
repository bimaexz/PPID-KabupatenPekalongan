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
class Authorize {
	static $lookups = array();

	static $groupsMap = [];
	
	function __construct(){
		
	}

	public static function permitted($rules, $owner_id = null, $user_id = null){
		$user = \GApp3::user();
		
		if(empty(self::$groupsMap)){
			self::$groupsMap['owner'] = [];
			$groupsModel = new \G3\A\M\Group();
			$_groups = $groupsModel->select('flat');
			foreach($_groups as $_g){
				self::$groupsMap[$_g['Group']['id']] = $_g['Group']['_parents'];
			}
		}

		if(count($rules) != count(self::$groupsMap)){
			foreach(self::$groupsMap as $gid => $gp){
				if(!isset($rules[$gid])){
					$rules[$gid] = 0;
				}
			}
		}

		foreach($rules as $rk => &$rv){
			if(empty($rv)){
				foreach(self::$groupsMap[$rk] as $pg){
					if(!empty($rules[$pg])){
						$rv = $rules[$pg];
					}
				}
			}
		}
		
		$userGroups = $user->get('groups');
		if(!empty($owner_id) AND ($user->get('id') == $owner_id)){
			$userGroups[] = 'owner';
		}
		
		foreach($userGroups as $gid){
			if((int)$rules[$gid] === -1){
				return false;
			}
		}
		foreach($userGroups as $gid){
			if((int)$rules[$gid] === 1){
				return true;
			}
		}

		return false;
	}
	
	public static function authorized($path, $action = 'access', $owner_id = null, $user_id = null){
		$user = \GApp3::user();
		//owner admin access
		if((int)$user->get('id') === 1){
			//return true;
		}
		//login/logout can be always accessed
		if(($path == '\G3\A\C\Users' OR $path == '\G3\C\Users') AND ($action == 'login' OR $action == 'logout')){
			return true;
		}
		
		$groups = Authenticate::get_user_groups($user_id);
		if(!empty($owner_id) AND $owner_id == $user->get('id')){
			$groups['owner'] = 1;
		}
		$return = false;
		//build search branches based on current loaded class
		if(is_array($path)){
			if(Arr::is_assoc($path) !== true){
				$tests = $path;
			}else{
				$rules = $path;
				return self::check_rules(!empty($rules[$action]) ? $rules[$action] : [], $groups, $owner_id, $user_id);
			}
		}else{
			$branches = explode('&', $path);
			$tests = array();
			for($i = 0; $i = count($branches); $i++){
				$tests[] = implode('&', $branches);
				array_pop($branches);
			}
		}
		//check cache
		$cache = (bool)\GApp3::config()->get('cache.permissions');
		/*if($cache === true){
			$session = \GApp3::session();
			$cached_permissions = $session->get('acos_permissions.'.$user->get('id'), array());
			if(in_array('owner', array_keys($groups))){
				$cache_key = md5(serialize($tests).$action.$owner_id);
			}else{
				$cache_key = md5(serialize($tests).$action);
			}
			//uncomment the following lines to store permissions info in session.
			if(array_key_exists($cache_key, $cached_permissions)){
				$return = $cached_permissions[$cache_key];
				goto end;
			}
		}*/
		
		$paths_key = md5(serialize($tests));
		if(!isset(self::$lookups[$paths_key])){
			$Acl_model = new \G3\A\M\Acl();
			$acls = $Acl_model->where('aco', $tests, 'in')->where('enabled', 1)->order(['Acl.aco' => 'desc'])->select('all', ['json' => ['rules']]);
			self::$lookups[$paths_key] = $acls;
		}else{
			$acls = self::$lookups[$paths_key];
		}
		
		if(empty($acls)){
			//no ACL results found matching this ACO
			$return = false;
			//goto end;
			return $return;
		}
		foreach($acls as $k => $acl){
			$p_action = $action;
			$rules = $acl['Acl']['rules'];
			
			if(!empty($rules[$p_action])){
				//main action rules found, goto permissions check
			}elseif(!empty($rules['access'])){
				//main action not found, but access action found, let's use it
				//$p_action = 'access';
			}else{
				//neither the main action nor the default one found under this path, or maybe no permissions set, go to the next one.
				continue;
			}
			//check groups action's rules
			$result = self::check_rules($rules[$p_action], $groups, $owner_id, $user_id);
			if(!is_null($result)){
				$return = $result;
				//goto end;
				return $return;
			}
			//looks like all permissions in this path are not set or inheriting, go to next path
			continue;			
		}
		//we looped all pathes with no matches, return denied
		$return = false;
		end:
		//store into cache
		/*if($cache === true){
			$session = \GApp3::session();
			$cached_permissions = $session->get('acos_permissions.'.$user->get('id'), array());
			if(in_array('owner', array_keys($groups))){
				$cache_key = md5(serialize($tests).$action.$owner_id);
			}else{
				$cache_key = md5(serialize($tests).$action);
			}
			$cached_permissions[$cache_key] = $return;
			$session->set('acos_permissions.'.$user->get('id'), $cached_permissions);
		}else{
			$session = \GApp3::session();
			$session->set('acos_permissions.'.$user->get('id'), array());
		}*/
		return $return;
	}
	
	public static function check_rules($rules, $groups = array(), $owner_id = null, $user_id = null){
		$user = \GApp3::user();
		/*
		if(empty($groups)){
			$groups = Authenticate::get_user_groups($user_id);
		}
		if(!empty($owner_id) AND $owner_id == $user->get('id')){
			$groups['owner'] = 1;
		}
		*/
		if(!is_array($rules)){
			$rules = (array)$rules;
		}
		
		$usergroups = array_keys($groups, 1);
		$inherited = array_keys($groups, 0);
		
		//check if any banned groups match user's groups
		$banned = array_keys($rules, -2);
		if(count(array_intersect($banned, $usergroups)) > 0){
			//one or more of the user's groups is banned, return false
			return false;
		}
		//check if any allowed groups match user's groups
		$allowed = array_keys($rules, 1);
		if(count(array_intersect($allowed, $usergroups)) > 0){
			//one or more of the user's groups is allowed, return true
			return true;
		}
		//check if any denied groups match user's groups
		$denied = array_keys($rules, -1);
		if(count(array_intersect($denied, $usergroups)) > 0){
			//one or more of the user's groups is denied, return false
			return false;
		}
		/*
		//check if any not set groups match user's groups
		$not_set = array_keys($rules, '');
		if(count(array_intersect($not_set, $groups)) > 0){
			//one or more of the user's groups is denied, return false
			return 0;
		}
		*/
		
		//check the inherited groups
		
		foreach($inherited as $g){
			if(in_array($g, $allowed, true) !== false){
				return true;
			}
			if(in_array($g, $denied, true) !== false){
				return false;
			}
		}
		
		//no matches was found
		return null;
	}
	
}