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
class Fdata extends \G3\L\Component{

	var $_models = array(
		'\G3\A\M\AclProfile',
	);

	function cdata($group = '', $value = null, $set = false){
		$path = '__cdata';
		if($group){
			$path .= '.'.$group;
		}
		
		if($set){
			$this->set($path, $value);
		}else{
			return $this->get($path, $value);
		}
	}

	function sessiondata($group = '', $value = null, $set = false){
		$path = $this->cdata('alias', '___');

		if($group === false){
			\GApp3::session()->clear($path);
		}

		if($group){
			$path .= '.'.$group;
		}
		
		if($set){
			\GApp3::session()->set($path, $value);
			\GApp3::session()->set($this->cdata('alias', '___').'.__lastsave', time());
		}else{
			return \GApp3::session()->get($path, $value);
		}
	}

	function acl($unit){
		if(!empty($unit['acl']['profile'])){
			$acl = $this->cdata('acls.'.$unit['acl']['profile'], []);

			$owner_id = !empty($unit['acl']['owner_id']) ? $this->controller->Parser->parse($unit['acl']['owner_id']) : null;

			if(\GApp3::permitted($acl['rules'] ?? [], $owner_id) !== true){
				return false;
			}

			// if(!empty(array_filter($acl['rules'])) AND \GApp3::access($acl['rules'], 'access', $owner_id) !== true){
			// 	return false;
			// }
		}
		return true;
	}

	function conditions($conditions){
		$ifrules_test_option = function($rule){
			$first = $this->controller->Parser->parse($rule['first']);
			$second = isset($rule['second']) ? $this->controller->Parser->parse($rule['second']) : $rule['msecond'] ?? [];
			$sign = $rule['sign'];
			
			if($sign == '=='){
				return ($first == $second);
			}elseif($sign == '!='){
				return ($first != $second);
			}elseif($sign == '>'){
				return ($first > $second);
			}elseif($sign == '<'){
				return ($first < $second);
			}elseif($sign == '>='){
				return ($first >= $second);
			}elseif($sign == '<='){
				return ($first <= $second);
			}elseif($sign == 'regex'){
				return preg_match($second, $first);
			}elseif($sign == '!regex'){
				return !preg_match($second, $first);
			}elseif($sign == 'in'){
				if(!is_array($second)){
					$second = array_filter(array_map('trim', explode("\n", $second)), 'strlen');
				}
				return in_array($first, $second);
			}elseif($sign == '!in'){
				if(!is_array($second)){
					$second = array_filter(array_map('trim', explode("\n", $second)), 'strlen');
				}
				return !in_array($first, $second);
			}elseif($sign == 'empty'){
				return empty($first);
			}elseif($sign == '!empty'){
				return !empty($first);
			}elseif($sign == 'null'){
				return is_null($first);
			}elseif($sign == '!null'){
				return !is_null($first);
			}elseif($sign == 'numeric'){
				return is_numeric($first);
			}elseif($sign == 'bool'){
				return is_bool($first);
			}elseif($sign == 'integer'){
				return is_integer($first);
			}elseif($sign == 'string'){
				return is_string($first);
			}else{
				return false;
			}
		};
		
		if(!empty($conditions) AND is_array($conditions)){
			foreach($conditions as $condition){
				$condition_result = true;
				
				if(!empty($condition['rules'])){
					foreach($condition['rules'] as $rule){
						if(empty($condition['logic']) OR $condition['logic'] == 'and'){
							$condition_result = ($condition_result AND $ifrules_test_option($rule));
						}elseif(!empty($condition['logic']) AND $condition['logic'] == 'or'){
							$condition_result = $ifrules_test_option($rule);
							if($condition_result){
								break;
							}
						}
					}
					
					if($condition_result){
						return true;
					}
				}
			}

			return false;
		}else{
			return true;
		}
	}

	function dsources($sources){
		$results = [];
		$sources = (array)$sources;
		foreach($sources as $source){
			if(is_numeric($source)){
				$source_fn = $this->cdata('functions.'.$source);
				if($source_fn['type'] == 'read_data'){
					$read_data = is_array($this->get($source_fn['name'], [])) ? $this->get($source_fn['name'], []) : [];
					$results = array_merge($results, $read_data);
				}else if($source_fn['type'] == 'static_data'){
					$results = array_merge($results, $this->get($source_fn['name'], []));
				}else if($source_fn['type'] == 'shopping_cart'){
					$results = array_merge($results, \GApp3::session()->get($source_fn['cart']['id'].'.products', []));
				}
			}else{
				$results = array_merge($results, (array)$this->controller->Parser->parse($source));
			}
		}

		return $results;
	}

	function inputs($pageids = [], $parent_uid = false){
		if(empty($pageids)){
			$pid = $this->sessiondata('pages.active');
			$pageids = array_intersect(array_keys($this->cdata('pgroups.'.$this->cdata('pages.'.$pid.'.pgid').'.pages')), array_keys($this->sessiondata('pages.accepted')));
			//$pages = array_keys($this->sessiondata('pages.accepted.'.$this->cdata('pages.'.$pid.'.pgroup'), []));
		}
		
		$list = [];
		foreach($pageids as $pageid){
			$inputs = $this->cdata('pages.'.$pageid.'.inputs', []);
			foreach($inputs as $vuid){
				$list[$vuid] = $this->cdata('views.'.$vuid);

				if(!empty($parent_uid)){
					if(!in_array($parent_uid, $list[$vuid]['_parents'])){
						unset($list[$vuid]);
					}
				}
			}
		}

		return $list;
	}

	function units($utype, $pageids = []){
		if(empty($pageids)){
			$pid = $this->sessiondata('pages.active');
			$pageids = array_intersect(array_keys($this->cdata('pgroups.'.$this->cdata('pages.'.$pid.'.pgid').'.pages')), array_keys($this->sessiondata('pages.accepted')));
			// $pages = array_keys($this->sessiondata('pages.accepted.'.$this->cdata('pages.'.$pid.'.pgroup'), []));
		}
		
		$list = [];
		foreach($pageids as $pageid){
			$units = $this->cdata('pages.'.$pageid.'.'.$utype, []);
			foreach($units as $uid){
				$list[$uid] = $this->cdata($utype.'.'.$uid);
			}
		}

		return $list;
	}

	function valid($unit){
		if(!isset($unit['uid'])){
			return true;
		}

		$unit['_page'] = $unit['_page'] ?? '0'; //for admin preview

		if(isset($unit['invalid']) AND is_array($unit['invalid'])){
			$result = true;
			if(isset($unit['invalid']['conditions'])){
				$result = ($result AND $this->conditions($unit['invalid']['conditions']));
			}
			return $result;
		}else{
			if(!empty($unit['invalid'])){
				return false;
			}else{
				//check parents
				if(!empty($unit['_parents'])){
					foreach($unit['_parents'] as $puid){
						if(!$this->valid($this->cdata($unit['utype'].'.'.$puid))){
							return false;
						}
					}
				}
			}
		}

		return true;
	}

	function deny($unit, $value = true){
		// this function is not used anywhere at the moment
		$this->cdata($unit['utype'].'.'.$unit['uid'].'.invalid', true, true);
		// $this->sessiondata('_invalid.'.$this->cdata('pages.'.$unit['page'].'.pgroup').'.'.$unit['uid'], $value, true);
	}

	function updateUid($uid, $unit){
		if(!empty($unit['inherits'])){
			if($unit['inherits'] == $uid){
				return $unit['uid'];
			}
		}
		
		if(!empty($unit['_referenced_by']) and !empty($this->cdata('views.'.$unit['_referenced_by'].':'.$uid))){
			return $unit['_referenced_by'].':'.$uid;
		}

		return $uid;
	}
	
	function build($connection){
		$this->_vars['__cdata'] = [];
		$cdata = &$this->_vars['__cdata'];
		$cdata['id'] = $connection['id'];
		$cdata['alias'] = $connection['alias'];
		$cdata['title'] = $connection['title'];
		$cdata['apptype'] = $connection['apptype'];
		$cdata['settings'] = $connection['settings'];
		$cdata['acls'] = [];

		if(!empty($cdata['settings']['form']['behaviors'])){
			foreach($cdata['settings']['form']['behaviors'] as $group => $bvs){
				foreach($bvs as $bv){
					// if(isset($_behaviors['list']['settings'][$bv])){
						// $cdata['settings']['form']['behaviorsData'][$bv] = $_behaviors['list']['settings'][$bv];
						$cdata['settings']['form']['behaviorsData'][$bv] = $this->controller->Behaviors->getInfo('settings', $bv);
					// }
				}
			}
			usort($cdata['settings']['form']['behaviorsData'], function ($a, $b){
				return $a['order'] <=> $b['order'];
			});
		}

		//Load ACL data
		$acls = $this->AclProfile
		->where('enabled', 1)
		->select('all', ['json' => ['rules']]);

		if(!empty($acls)){
			foreach($acls as $acl){
				$cdata['acls'][$acl['AclProfile']['alias']] = $acl['AclProfile'];
			}
		}

		$this->controller->Behaviors->apply('startup', $cdata['settings']['form']);
		//find if blocks are needed
		$view_blocks = \G3\L\Arr::getVal($connection, 'Connection.views.[n].type', []);
		$fn_blocks = \G3\L\Arr::getVal($connection, 'Connection.functions.[n].type', []);
		$blocks_ids = [];
		
		foreach($view_blocks as $k => $view_block){
			if($view_block == 'stored_block'){
				$blocks_ids[] = $connection['views'][$k]['block_id'];
			}
		}
		
		foreach($fn_blocks as $k => $fn_block){
			if($fn_block == 'stored_block'){
				$blocks_ids[] = $connection['functions'][$k]['block_id'];
			}
		}
		
		$blocks_ids = array_unique($blocks_ids);
		
		$cdata['blocks'] = [];
		if(!empty($blocks_ids)){
			$blocks = $this->Block
			->where('block_id', $blocks_ids, 'in')
			->select('all', ['json' => ['content']]);
			
			if(!empty($blocks)){
				foreach($blocks as $key => $block){
					$cdata['blocks'][$block['Block']['block_id']] = $block['Block']['content'];
				}
			}
		}

		$cdata['pgroups'] = [];
		$cdata['pids'] = [];

		foreach($connection['pgroups'] as $pgid => $pgroup){
			$counter = 0;
			$cdata['pgroups'][$pgid] = $pgroup;
			$cdata['pgids'][$pgroup['name']] = $pgid;
			$cdata['pgroups'][$pgid]['pages'] = [];

			foreach($connection['pages'] as $pid => $page){
				if($page['pgroup'] == $pgid){
					$pagename = $page['name'];
					$cdata['pids'][$pagename] = $pid;

					$cdata['pages'][$pid] = $page;
					$cdata['pages'][$pid]['pageid'] = $pid;
					$cdata['pages'][$pid]['fullname'] = $pagename;
					$cdata['pages'][$pid]['urlname'] = $pagename;//$pgroup['name'].'.'.$pagename;
					
					$cdata['pgroups'][$pgid]['pages'][$pid] = $pagename;
					$cdata['pages'][$pid]['pgroup'] = $pgroup['name'];
					$cdata['pages'][$pid]['pgid'] = $pgid;
					$cdata['pages'][$pid]['index'] = $counter + 1;

					$cdata['pages'][$pid]['utype'] = 'pages';
					$cdata['pages'][$pid]['uid'] = $pid;//$pagename;

					$cdata['pages'][$pid]['types'] = [];

					$cdata['pages'][$pid]['site'] = $pgroup['site'] ?? '';

					$cdata['pages'][$pid]['next_page'] = [$pid];
					if(!empty($page['next_pages'])){
						$cdata['pages'][$pid]['next_page'] = array_merge($cdata['pages'][$pid]['next_page'], $page['next_pages']);
					}
					
					if(!empty($pgroup['type'])){
						$cdata['pages'][$pid]['types'][] = $pgroup['type'];
						// $cdata['pages'][$pid]['next_page'][] = $pid;
					}else{
						if($counter == 0){
							$cdata['pages'][$pid]['types'][] = 'start';
						}
					}
					$counter++;
				}
			}
		}

		foreach($cdata['pgroups'] as $pgid => $pgroup){
			if(!empty($pgroup['pages'])){
				$prev = '';
				foreach(array_reverse($pgroup['pages'], true) as $pid => $pagename){
					if(empty($pgroup['type'])){
						$cdata['pages'][$pid]['next_page'][0] = ($prev ? $prev : $pid);
						$prev = $pid;
						if(empty($cdata['pages'][$pid]['types'])){
							$cdata['pages'][$pid]['types'][] = 'middle';
						}
					}else{
						// $cdata['pages'][$page]['next_page'] = $page;
						// $cdata['pages'][$page]['types'][] = $pgroup['type'];
					}
				}
				if(empty($pgroup['type'])){// AND count($pgroup['pages']) > 1){
					$pgpids = array_keys($pgroup['pages']);
					$last = array_pop($pgpids);
					$cdata['pages'][$last]['types'][] = 'end';
				}
			}
		}
		
		foreach($cdata['pages'] as $pid => $page){
			if(!empty($page['behaviors'])){
				foreach($page['behaviors'] as $group => $bvs){
					foreach($bvs as $bv){
						// if(isset($_behaviors['list']['pages'][$bv])){
							// $cdata['pages'][$pid]['behaviorsData'][$bv] = $_behaviors['list']['pages'][$bv];
							$cdata['pages'][$pid]['behaviorsData'][$bv] = $this->controller->Behaviors->getInfo('pages', $bv);
						// }
					}
				}
			}
		}
		
		// foreach($connection['pgroups'] as $pgid => $pgroup){
		// 	$counter = 0;
		// 	$pgroup['name'] = str_replace('.', '::', $pgroup['name']);
		// 	$cdata['pgroups'][$pgroup['name']] = $pgroup;
		// 	$cdata['pgroups'][$pgroup['name']]['pages'] = [];

		// 	foreach($connection['pages'] as $pid => $page){
		// 		if($page['pgroup'] == $pgid){
		// 			$pagename = $pgroup['name'].'::'.$page['name'];
		// 			$cdata['pids'][$pid] = $pagename;
		// 			$cdata['pages'][$pagename] = $page;
		// 			$cdata['pages'][$pagename]['fullname'] = str_replace('::', '.', $pagename);
		// 			$cdata['pgroups'][$pgroup['name']]['pages'][$pid] = $pagename;
		// 			$cdata['pages'][$pagename]['pgroup'] = $pgroup['name'];
		// 			$cdata['pages'][$pagename]['index'] = $counter + 1;

		// 			$cdata['pages'][$pagename]['utype'] = 'pages';
		// 			$cdata['pages'][$pagename]['uid'] = $pagename;

		// 			$cdata['pages'][$pagename]['types'] = [];
		// 			//$cdata['pages'][$pagename]['next_page'] = isset(array_keys($page['pages'])[$counter + 1]) ? $pid.'::'.array_keys($page['pages'])[$counter + 1] : '';

		// 			$cdata['pages'][$pagename]['site'] = $pgroup['site'] ?? '';
		// 			if(!empty($pgroup['type'])){
		// 				$cdata['pages'][$pagename]['types'][] = $pgroup['type'];
		// 				$cdata['pages'][$pagename]['next_page'] = $pagename;
		// 			}else{
		// 				if($counter == 0){
		// 					$cdata['pages'][$pagename]['types'][] = 'start';
		// 				}
		// 			}
		// 			$counter++;
		// 		}
		// 	}
		// }

		// foreach($cdata['pgroups'] as $pgname => $pgroup){
		// 	if(!empty($pgroup['pages'])){
		// 		$prev = '';
		// 		foreach(array_reverse($pgroup['pages']) as $page){
		// 			if(empty($pgroup['type'])){
		// 				$cdata['pages'][$page]['next_page'] = ($prev ? $prev : $page);
		// 				$prev = $page;
		// 				if(empty($cdata['pages'][$page]['types'])){
		// 					$cdata['pages'][$page]['types'][] = 'middle';
		// 				}
		// 			}else{
		// 				// $cdata['pages'][$page]['next_page'] = $page;
		// 				// $cdata['pages'][$page]['types'][] = $pgroup['type'];
		// 			}
		// 		}
		// 		if(empty($pgroup['type'])){// AND count($pgroup['pages']) > 1){
		// 			$last = array_pop($pgroup['pages']);
		// 			$cdata['pages'][$last]['types'][] = 'end';
		// 		}
		// 	}
		// }

		$this->controller->Behaviors->apply('startup2', $cdata['settings']['form']);

		$cdata['areas'] = [];
		
		$utypes = ['functions', 'views'];
		foreach($utypes as $utype){
			$cdata[$utype] = [];
			$denied = [];
			if(!empty($connection[$utype])){
				$new_units = [];
				foreach($connection[$utype] as $key => $unit){
					if($unit['type'] == 'unit_reference'){
						$reference = $connection[$utype][$unit['reference']['uid']];
						$replace = [
							'_parent' => $unit['_parent'],
							'_area' => $unit['_area'],
							'uid' => $unit['uid'].':'.$reference['uid'],
							'behaviors' => array_merge_recursive($unit['behaviors'] ?? [], $reference['behaviors'] ?? []),
							'conditions' => array_merge_recursive($unit['conditions'] ?? [], $reference['conditions'] ?? []),
							'localvars' => array_merge_recursive($unit['localvars'] ?? [], $reference['localvars'] ?? []),
							'acl' => $unit['acl'] ?? $reference['acl'] ?? [],

							'_referenced_by' => $unit['uid'],
						];
						if(!empty($replace['behaviors']['data'])){
							$replace['behaviors']['data'] = array_unique($replace['behaviors']['data']);
						}
						// pr($unit);
						$new_units[$unit['uid'].':'.$reference['uid']] = array_replace($reference, $replace);
						// pr($new_units[$unit['uid'].':'.$reference['uid']]);
						foreach($connection[$utype] as $skey => $sunit){
							if($sunit['_parent'] == $reference['uid']){
								$suid = $sunit['uid'];
								$sunit['_parent'] = $unit['uid'].':'.$reference['uid'];
								$sunit['uid'] = $unit['uid'].':'.$sunit['uid'];

								$new_units[$unit['uid'].':'.$suid] = $sunit;
							}
						}
					}else{
						$new_units[$key] = $unit;
					}
				}

				$connection[$utype] = $new_units;

				foreach($connection[$utype] as $key => $unit){
					$unit['_children'] = [];
					$unit['_dchildren'] = [];
					// if(!$this->acl($unit) OR (!empty($unit['_parent']) AND in_array($unit['_parent'], $denied))){
					// 	$denied[] = $unit['uid'];
					// 	continue;
					// }

					if(!empty($unit['_parent'])){
						$cdata[$utype][$unit['_parent']]['_dchildren'][$unit['uid']] = $unit['uid'];
						$parent = $cdata[$utype][$unit['_parent']];
						$unit['_parents'] = array_replace($parent['_parents'], [$parent['uid'] => $parent['uid']]);

						if($utype == 'views'){
							if(!empty($parent['_repeaters'])){
								$unit['_repeaters'] = $parent['_repeaters'];
							}
							if($parent['type'] == 'area_repeater'){
								$unit['_repeaters'] = array_merge($unit['_repeaters'] ?? [], [$parent['uid']]);
							}
						}
					}else{
						$unit['_parents'] = [];
					}

					foreach($unit['_parents'] as $puid){
						$cdata[$utype][$puid]['_children'][$unit['uid']] = $unit['uid'];

						if(!empty($cdata[$utype][$puid]['_referenced_by'])){
							$unit['_referenced_by'] = $cdata[$utype][$puid]['_referenced_by'];
						}
					}

					if(is_numeric($unit['_area']) AND empty($unit['_parent'])){
						$unit['_area'] = $unit['_area'];//$cdata['pages'][$unit['_area']]['fullname'];
					}
					
					if($unit['type'] == 'stored_block'){
						$bunits = $cdata['blocks'][$unit['block_id']];
						foreach($bunits as $ku => $bunit){
							$bunit['name'] = $bunit['block_id'].'#'.$unit['name'];
							if(strpos($bunit['_area'], '/') !== false){
								$bunit['_area'] = $bunit['block_id'].'#'.$bunit['_area'];
							}else{
								$bunit['_area'] = $bunit['_area'];
							}

							//$unit = $this->_update_views_references($unit, $units);
							// $cdata['uids'][$key.'#'.$ku] = $unit['name'];
							$cdata[$utype][$unit['name']] = $bunit;
							$area = !empty($bunit['_parent']) ? $bunit['_parent'].'/'.$bunit['_area'] : $bunit['_area'];
							$cdata['areas'][$area][$utype][] = $bunit['name'];
						}
					}else{
						//$unit = $this->_update_views_references($unit, $connection[$utype]);
						// $cdata['uids'][$key] = $unit['uid'];
						$cdata[$utype][$unit['uid']] = $unit;
						$area = !empty($unit['_parent']) ? $unit['_parent'].'/'.$unit['_area'] : $unit['_area'];
						$area = str_replace('.', '_', $area);
						$cdata['areas'][$area][$utype][] = $unit['uid'];

						$cdata['uids'][$utype][$unit['name']] = $unit['uid'];
					}
				}
			}
		}
		
		//inputs
		$active_page = '';

		$_bconfigs = [];
		
		foreach($cdata['views'] as $k => $view){
			if(!empty($view['behaviors'])){
				foreach($view['behaviors'] as $group => $bvs){
					foreach($bvs as $bv){
						$info = $this->controller->Behaviors->getInfo('views', $bv);
						if(empty($info)){
							$info = $this->controller->Behaviors->getInfo('views', $bv, $view['type']);
							$info['bconfig'] = true;
						}
						$cdata['views'][$view['uid']]['behaviorsData'][$bv] = $info;
					}
				}
			}
			if(!empty($view['_area']) AND isset($cdata['pages'][$view['_area']])){
				$active_page = $view['_area'];
			}
			
			$info = [];
			if(file_exists(\G3\Globals::ext_path('chronoforms', 'admin').'views'.DS.$view['type'].DS.$view['type'].'.php')){
				$info = require \G3\Globals::ext_path('chronoforms', 'admin').'views'.DS.$view['type'].DS.$view['type'].'.php';
			}
			
			$cdata['pages'][$active_page]['views'][] = $view['uid'];
			$cdata['views'][$view['uid']]['_page'] = $active_page;

			if(!empty($view['options'])){
				$cdata['views'][$view['uid']]['foptions'] = $this->controller->Parser->options($view['options']);
			}

			if(!empty($info['paid'])){
				$cdata['views'][$view['uid']]['_paid'] = $info['title'];
			}

			if(!empty($info['ugroups'])){
				$cdata['views'][$view['uid']]['ugroups'] = $info['ugroups'];

				foreach($info['ugroups'] as $ugroup){
					$cdata['pages'][$active_page][$ugroup][] = $view['uid'];
					if($ugroup == 'inputs'){
						$cdata['views'][$view['uid']]['datapath'] = $view['nodes']['main']['attrs']['name'];
						$cdata['views'][$view['uid']]['_lname'] = array_reverse(explode('.', $view['nodes']['main']['attrs']['name']))[0];

						if(strpos($cdata['views'][$view['uid']]['datapath'], '.#') !== false){
							$cdata['views'][$view['uid']]['datapath'] = $this->controller->Parser->getNames($cdata['views'][$view['uid']]['datapath']);
						}else{
							$cdata['views'][$view['uid']]['datapath'] = (array)$cdata['views'][$view['uid']]['datapath'];
						}
					}
				}
			}
		}

		foreach($cdata['functions'] as $k => $function){
			if(!empty($function['behaviors'])){
				foreach($function['behaviors'] as $group => $bvs){
					foreach($bvs as $bv){
						$info = $this->controller->Behaviors->getInfo('functions', $bv);
						if(empty($info)){
							$info = $this->controller->Behaviors->getInfo('functions', $bv, $function['type']);
							$info['bconfig'] = true;
						}
						$cdata['functions'][$function['uid']]['behaviorsData'][$bv] = $info;
					}
				}
			}

			if(!empty($function['_area']) AND isset($cdata['pages'][$function['_area']])){
				$active_page = $function['_area'];
			}

			$cdata['pages'][$active_page]['functions'][] = $function['uid'];
			$cdata['functions'][$function['uid']]['_page'] = $active_page;

			$info = [];
			if(file_exists(\G3\Globals::ext_path('chronoforms', 'admin').'functions'.DS.$function['type'].DS.$function['type'].'.php')){
				$info = require \G3\Globals::ext_path('chronoforms', 'admin').'functions'.DS.$function['type'].DS.$function['type'].'.php';

				if(!empty($info['paid'])){
					$cdata['functions'][$function['uid']]['_paid'] = $info['title'];
				}
			}
		}

		if($cdata['apptype'] == 'connectivity'){
			foreach($cdata['pages'] as $pid => $page){
				if(!empty($page['content'])){
					$pattern = '/{(view|vw|function|fn)([\.][^:]+)?:([^}]*?)}/i';
					preg_match_all($pattern, $page['content'], $matches);
					if(!empty($matches[1])){
						foreach($matches[1] as $mk => $type){
							if(in_array($type, ['function', 'fn'])){
								if(!empty($cdata['uids']['functions'][$matches[3][$mk]])){
									$fuid = $cdata['uids']['functions'][$matches[3][$mk]];
									$cdata['pages'][$pid]['functions'][] = $fuid;

									if(!empty($cdata['functions'][$fuid]['_children'])){
										foreach($cdata['functions'][$fuid]['_children'] as $cuid){
											if(!in_array($cuid, $cdata['pages'][$pid]['functions'])){
												$cdata['pages'][$pid]['functions'][] = $cuid;
											}
										}
									}
								}
							}else if(in_array($type, ['view', 'vw'])){
								if(!empty($cdata['uids']['views'][$matches[3][$mk]])){
									$vuid = $cdata['uids']['views'][$matches[3][$mk]];
									$cdata['pages'][$pid]['views'][] = $vuid;

									if(!empty($cdata['views'][$vuid]['_children'])){
										foreach($cdata['views'][$vuid]['_children'] as $cuid){
											if(!in_array($cuid, $cdata['pages'][$pid]['views'])){
												$cdata['pages'][$pid]['views'][] = $cuid;
											}
										}
									}
								}
							}
						}
					}

					if(!empty($cdata['pages'][$pid]['views'])){
						foreach($cdata['pages'][$pid]['views'] as $vuid){
							if(!empty($cdata['views'][$vuid]['ugroups'])){
								foreach($cdata['views'][$vuid]['ugroups'] as $ugroup){
									$cdata['pages'][$pid][$ugroup][] = $vuid;
								}
							}
						}
					}
				}
			}
		}
// pr($cdata);
		//check the form saved time
		if($this->cdata('settings.__lastsave', 0) > $this->sessiondata('__lastsave', time())){
			$this->sessiondata(false);
		}

		if($this->sessiondata('_clear')){
			$this->clear();
		}

		//page
		// $default_page = !empty($this->cdata('pages')) ? array_keys($this->cdata('pages', []))[0] : '';
		$default_page = '404';
		$default_page_id = 0;
		foreach($this->cdata('pages', []) as $pid => $page_data){
			if(empty($page_data['site']) OR $page_data['site'] == $this->controller->site){
				$default_page = $page_data['fullname'];
				$default_page_id = $pid;
				break;
			}
		}

		$event = $this->get('gpage', $this->data('gpage', $default_page));
		$event_id = null;
		foreach($this->cdata('pages', []) as $pid => $page_data){
			if($page_data['fullname'] == $event){
				$event_id = $pid;
				break;
			}
		}
		
		$this->sessiondata('pages.requested', $event_id, true);
		$this->sessiondata('pages.default', $default_page_id, true);

		if(
			empty($event) OR 
			empty($event_id) OR 
			(in_array('private', $cdata['pages'][$event_id]['types'])) OR
			(!empty($cdata['pages'][$event_id]['site']) AND $cdata['pages'][$event_id]['site'] != $this->controller->site)
		){
			$event = '404';
			$this->sessiondata('pages.requested', null, true);

			$this->clear();
		}

		$units = $this->units('functions', array_keys($this->cdata('pages', [])));
		foreach($units as $uid => $unit){
			if($this->controller->FData->valid($unit)){
				$this->controller->Behaviors->apply('initialize', $unit);
			}
		}

		$units = $this->units('views', array_keys($this->cdata('pages', [])));
		foreach($units as $uid => $unit){
			if($this->controller->FData->valid($unit)){
				$this->controller->Behaviors->apply('initialize', $unit);
			}
		}

		if(!empty($this->data('gtask'))){
			$this->controller->Behaviors->apply('tasks', $cdata['settings']['form'], ['task' => $this->data('gtask')]);
			$this->sessiondata('pages.requested', null, true);
		}
	}

	function clear(){
		$pgid = $this->controller->FData->cdata('pages.'.$this->sessiondata('_clear').'.pgid', 0);
		
		if(empty($this->controller->FData->cdata('pgroups.'.$pgid.'.type'))){
			$sister_pages = array_keys($this->controller->FData->cdata('pgroups.'.$pgid.'.pages', []));
		}else{
			$sister_pages = [$pgid];
		}

		$this->sessiondata('pages.active', null, true);

		foreach($sister_pages as $spageid){
			$this->sessiondata('_data.'.$spageid, null, true);
			$this->sessiondata('_vars.'.$spageid, null, true);
			$this->sessiondata('_invalid.'.$spageid, null, true);

			$this->sessiondata('pages.tokens.'.$spageid, null, true);
		}
		
		$this->sessiondata('pages.accepted', [], true);
		$this->sessiondata('pages.chain', [], true);

		$this->sessiondata('_clear', null, true);
	}

}