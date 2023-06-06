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
class Behaviors extends \G3\L\Component{
	var $behaviors = [];
	var $system = [];
	var $_bconfigs = [];

	function bconfigs($unit, $order = 'order'){
		$behaviors_info = [];
		if(in_array($unit['utype'], ['views', 'functions'])){
			if(file_exists(\G3\Globals::ext_path('chronoforms', 'admin').$unit['utype'].DS.$unit['type'].DS.'behaviors'.DS)){
				if(!isset($this->_bconfigs[$unit['utype']][$unit['type']])){
					$behaviors = \G3\L\Folder::getFolders(\G3\Globals::ext_path('chronoforms', 'admin').$unit['utype'].DS.$unit['type'].DS.'behaviors'.DS);
					foreach($behaviors as $behavior){
						$name = basename($behavior);
						$info = require($behavior.DS.$name.'.php');
						$config = $behavior.DS.$name.'_config.php';

						$info['has_config'] = file_exists($config);
						
						$behaviors_info[$name] = $info;
					}

					usort($behaviors_info, function ($a, $b) use($order){
						$a_order = isset($a[$order]) ? $a[$order] : $a['order'];
						$b_order = isset($b[$order]) ? $b[$order] : $b['order'];
						return $a_order <=> $b_order;
					});

					foreach($behaviors_info as $behavior){
						$this->_bconfigs[$unit['utype']][$unit['type']][$behavior['name']] = $behavior;
					}
				}
				
				$behaviors_info = $this->_bconfigs[$unit['utype']][$unit['type']];
			}
		}

		return $behaviors_info;
	}

	function getInfo($utype, $behavior, $unit_type = ''){
		static $cached = [];
		$id = $utype.$behavior.$unit_type;
		if(!empty($cached[$id])){
			return $cached[$id];
		}else{
			$cached[$id] = [];
		}

		$behavior_file = \G3\Globals::ext_path('chronoforms', 'admin').'behaviors'.DS.$utype.DS.$behavior.DS.$behavior.'.php';

		if(file_exists($behavior_file)){
			$cached[$id] = require($behavior_file);
		}

		if(!empty($unit_type)){
			$behavior_file = \G3\Globals::ext_path('chronoforms', 'admin').$utype.DS.$unit_type.DS.'behaviors'.DS.$behavior.DS.$behavior.'.php';
			if(file_exists($behavior_file)){
				$cached[$id] = require($behavior_file);
			}
		}

		return $cached[$id];
	}

	function getSystem(){
		if(empty($this->system)){
			foreach(['views', 'functions', 'pages', 'settings'] as $utype){
				$behaviors_info = [];

				$behaviors = \G3\L\Folder::getFolders(\G3\Globals::ext_path('chronoforms', 'admin').'behaviors'.DS.'system'.DS.$utype);

				foreach($behaviors as $behavior){
					$name = basename($behavior);
					$info = require($behavior.DS.$name.'.php');
					
					$behaviors_info[$name] = $info;
				}

				usort($behaviors_info, function ($a, $b){
					return $a['order'] <=> $b['order'];
				});

				foreach($behaviors_info as $behavior){
					$this->system[$utype][$behavior['name']] = $behavior;
				}
			}
		}

		return $this->system;
	}

	function list($order = 'order'){
		$mode = 'flat';
		if(empty($this->behaviors[$mode])){
			foreach(['views', 'functions', 'pages', 'settings'] as $utype){
				$behaviors_info = [];

				$behaviors = \G3\L\Folder::getFolders(\G3\Globals::ext_path('chronoforms', 'admin').'behaviors'.DS.$utype.DS);
				foreach($behaviors as $behavior){
					$name = basename($behavior);
					$info = require($behavior.DS.$name.'.php');
					$config = $behavior.DS.$name.'_config.php';

					$info['has_config'] = file_exists($config);
					
					$behaviors_info[$name] = $info;
				}

				usort($behaviors_info, function ($a, $b) use($order){
					$a_order = isset($a[$order]) ? $a[$order] : $a['order'];
					$b_order = isset($b[$order]) ? $b[$order] : $b['order'];
					return $a_order <=> $b_order;
				});

				foreach($behaviors_info as $behavior){
					if(!empty($behavior['system'])){
						foreach($behavior['system'] as $utype){
							$this->system[$utype][$behavior['name']] = $behavior;
						}
						// $this->system[$behavior['name']] = $behavior;
					}
					if($mode == 'flat'){
						$this->behaviors[$mode][$utype][$behavior['name']] = $behavior;
					}else{
						$this->behaviors[$mode][$utype][$behavior['category']][$behavior['name']] = $behavior;
					}
				}
			}
			
			return $this->behaviors[$mode];
		}else{
			return $this->behaviors[$mode];
		}
	}

	function apply($trigger, $unit, $params = []){
		$_params = &$params;
		$updated = false;
		if(empty($unit['utype'])){
			return $unit;
		}
		
		// if(empty($unit['behaviors'])){
		// 	$unit['behaviors'] = [];
		// }
		
		// $all_behaviors = [];
		// foreach($unit['behaviors'] as $group => $behaviors){
		// 	if(!empty($behaviors)){
		// 		$all_behaviors = array_merge($all_behaviors, $behaviors);
		// 	}
		// }

		// $unit_bconfigs = $this->bconfigs($unit);
		// $accepted_behaviors = array_merge($this->list()[$unit['utype']], $unit_bconfigs);

		// $unit_behaviors = array_intersect_key($accepted_behaviors, array_flip($all_behaviors));
		// $unit_behaviors = array_merge(($this->system[$unit['utype']] ?? []), $unit_behaviors);
		// // if($trigger == 'before_view' AND $unit['type'] == 'field_select'){
		// // pr($unit_behaviors);
		// // }
		if(empty($unit['behaviorsData'])){
			$unit['behaviorsData'] = [];
			if(!empty($unit['behaviors'])){
				foreach($unit['behaviors'] as $group => $bvs){
					if($group == $unit['type']){
						foreach($bvs as $bv){
							$unit['behaviorsData'][$bv] = $this->getInfo($unit['utype'], $bv, $unit['type']);
						}
					}else{
						foreach($bvs as $bv){
							$unit['behaviorsData'][$bv] = $this->getInfo($unit['utype'], $bv);
						}
					}
				}
			}
		}
		if(!empty($this->getSystem()[$unit['utype']])){
			$unit['behaviorsData'] = array_merge($this->getSystem()[$unit['utype']], $unit['behaviorsData']);
		}
		foreach($unit['behaviorsData'] as $behavior){
			if(in_array($trigger, $behavior['triggers'] ?? []) AND $this->controller->FData->valid($unit)){
				if($this->get('__invalid') AND !empty($behavior['paid'])){
					continue;
				}

				$path = !empty($behavior['system']) ? 'system'.DS.$unit['utype'] : $unit['utype'];
				$behavior_file = \G3\Globals::ext_path('chronoforms', 'admin').'behaviors'.DS.$path.DS.$behavior['name'].DS.$behavior['name'].'_output.php';
				
				// if(in_array($behavior['name'], \G3\L\Arr::getVal($unit_bconfigs, ['[n]', 'name'], []))){
				if(!empty($behavior['bconfig'])){
					$behavior_file = \G3\Globals::ext_path('chronoforms', 'admin').$unit['utype'].DS.$unit['type'].DS.'behaviors'.DS.$behavior['name'].DS.$behavior['name'].'_output.php';
				}

				if(file_exists($behavior_file)){
					$updated = true;
					$this->process($behavior_file, $unit, $behavior, $trigger, $_params);
					//$result = require $behavior_file;
				}
			}
		}

		if($updated AND !empty($unit['utype']) AND empty($params['_local'])){
			$this->controller->FData->cdata($unit['utype'].'.'.$unit['uid'], $unit, true);
		}
		
		return $unit;
	}

	function process($_file, &$unit, $behavior, $trigger, &$__params = []){
		if(!empty($__params)){
			foreach($__params as $__pkey => $__pval){
				$$__pkey = &$__params[$__pkey];
			}
		}
		$result = require $_file;
	}

}