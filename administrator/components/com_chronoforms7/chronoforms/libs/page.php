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
class Page extends \G3\L\Component{
	var $errors = [];
	var $stopped = false;
	var $fevents = [];
	var $debug = [];
	var $messages = [];
	var $info = []; //for save_data auto model
   
	function fn($unit){
		$result = null;

		$unit = $this->controller->Behaviors->apply('before_function', $unit);
		
		if(!empty($unit) AND $this->controller->FData->valid($unit)){
			if($this->get('__invalid') AND !empty($unit['_paid'])){
				\GApp3::session()->flash('warning', $unit['_paid'].' is disabled in the free version frontend');
				return;
			}

			if(empty($unit['_page'])){
				$unit['_page'] = $this->controller->FData->sessiondata('pages.active');
			}
			//get output file
			$function_path = \G3\Globals::ext_path('chronoforms', 'admin').'functions'.DS.$unit['type'].DS.$unit['type'].'_output.php';
			
			$inputs = $this->controller->FData->units('views', !empty($unit['past_events']) ? $unit['past_events'] : []);
			foreach($inputs as $input_uid => $view){
				if(!empty($view['fns'][$unit['type']])){
					$unit = array_replace_recursive($unit, $view['fns'][$unit['type']]);
				}
			}
			
			$result = $this->load_file($function_path, ['function' => $unit]);

			$unit = $this->controller->Behaviors->apply('after_function', $unit);
			
			if(empty($this->stopped)){
				if(!empty($this->fevents[$unit['name']])){
					foreach($this->fevents[$unit['name']] as $fevent => $fevent_result){
						if($fevent_result AND !empty($unit['uid'])){
							$result .= $this->event($unit['uid'].'/'.$fevent);
						}
					}
				}
			}
		}
		
		// $this->controller->FData->sessiondata('_vars.'.$this->controller->FData->cdata('pages.'.$unit['page'].'.pgroup').'.'.$unit['name'], $this->get($unit['name']), true);
		$this->controller->Parser->pset($unit['name'], $this->get($unit['name']));
		
		return $result;
	}

	function is_single_page($pageid){
		$is_start = in_array('start', $this->controller->FData->cdata('pages.'.$pageid.'.types', []));
		$is_end = in_array('end', $this->controller->FData->cdata('pages.'.$pageid.'.types', []));
		return ($is_start AND $is_end);
	}

	function is_valid_page($pageid){
		if(strpos($pageid, '/') !== false){
			return false;
		}
		return in_array($pageid, array_keys($this->controller->FData->cdata('pages')));
		// return in_array($name, array_keys($this->controller->FData->cdata('pids')));
	}

	function is_coming_from($pageid){
		if(!empty($this->data('__cf_token'))){
			//check this is a valid token and get the page
			$tokens = $this->controller->FData->sessiondata('pages.tokens', []);
			$proceeding_from = array_search($this->data('__cf_token'), $tokens);
			if($proceeding_from == $pageid){
				return true;
			}
		}

		return false;
	}

	function check_page_type($pageid, $type = false){
		if($type === false){
			return $this->controller->FData->cdata('pages.'.$pageid.'.types');
		}else{
			if($type == 'end' AND $this->is_single_page($pageid)){
				//single page form
				return $this->is_coming_from($pageid);
			}

			return in_array($type, $this->controller->FData->cdata('pages.'.$pageid.'.types', []));
		}
	}

	function check_accepted($pageid){
		$page = $this->controller->FData->cdata('pages.'.$pageid);
		return !empty($this->controller->FData->sessiondata('pages.accepted.'.$pageid));
	}

	function reset_page($pageid){
		$page = $this->controller->FData->cdata('pages.'.$pageid);
		$this->controller->FData->sessiondata('pages.accepted.'.$pageid, null, true);
		$this->controller->FData->sessiondata('pages.tokens.'.$pageid, null, true);
	}

	function updateVars($pageid, $settings){
		if(empty($settings['layout'])){
			$path = $pageid;

			$sister_pages = [];
			if(!$this->check_page_type($pageid, 'standalone')){
				$pgid = $this->controller->FData->cdata('pages.'.$pageid.'.pgid');
				$sister_pages = array_keys($this->controller->FData->cdata('pgroups.'.$pgid.'.pages'));
			}

			// if(true OR $this->check_page_type($pageid, 'standalone')){
			// 	$path = $pageid;
			// }else{
			// 	$path = $this->controller->FData->cdata('pages.'.$pageid.'.pgroup');
			// }

			$set_data = true;
			if(!empty($this->data('__cf_token'))){
				$tokens = $this->controller->FData->sessiondata('pages.tokens', []);
				$proceeding_from = array_search($this->data('__cf_token'), $tokens);
				
				if($proceeding_from !== false){
					// $proceeding_from = $this->controller->FData->cdata('pids.'.$proceeding_from);
					if($this->controller->FData->cdata('pages.'.$pageid.'.pgid') != $this->controller->FData->cdata('pages.'.$proceeding_from.'.pgid')){
						$set_data = false;
					}
				}
			}

			if($set_data){
				$mpdata = $this->controller->FData->sessiondata('_data.'.$path, []);
				$new = \G3\L\Arr::replace_recursive($mpdata, $this->data);
				if(isset($new['__cf_token'])){
					unset($new['__cf_token']);
				}
				if(isset($new['uid'])){
					unset($new['uid']);
				}
				if(isset($new['gact'])){
					unset($new['gact']);
				}
				$this->controller->FData->sessiondata('_data.'.$path, $new, true);

				if(!empty($sister_pages)){
					foreach($sister_pages as $spageid){
						$spagedata = $this->controller->FData->sessiondata('_data.'.$spageid, []);
						$this->data = \G3\L\Arr::replace_recursive($spagedata, $this->data);
					}
				}else{
					$this->data = \G3\L\Arr::replace_recursive($new, $this->data);
				}
			}

			if(!empty($sister_pages)){
				foreach($sister_pages as $spageid){
					$spagevars = $this->controller->FData->sessiondata('_vars.'.$spageid, []);
					foreach($spagevars as $vname => $value){
						$this->set($vname, $value);
					}
				}
			}else{
				$mpvars = $this->controller->FData->sessiondata('_vars.'.$path, []);
				foreach($mpvars as $vname => $value){
					$this->set($vname, $value);
				}
			}
		}
	}

	function event_function($pageid, $function){
		$result = '';
		
		$result .= $this->fn($function);
		
		if($this->get($function['name']) === false){
			$load_event = isset($this->fevents[$function['name']]['fail']) ? $this->fevents[$function['name']]['fail'] : null;
			if($load_event === true){
				$load_event = !empty($function['_page']) ? $function['_page'] : $this->controller->FData->sessiondata('pages.default');
			}
			//p3('validating:'.$pageid.' / load_event:'.$load_event);
			if(!empty($load_event) AND $pageid != $load_event){
				//p3('failed event:'.$load_event);
				$result .= $this->event($load_event);
			}
			//var_dump($load_event);p3($function);
			//p3('failure:'.$function['name']);
			$this->stopped = true;
		}
		
		return $result;
	}
	
	function event_start($pageid, $settings){
		$result = '';
		
		$page = $this->controller->FData->cdata('pages.'.$pageid, []);
		
		$accepted_pages = array_keys($this->controller->FData->sessiondata('pages.accepted', []));

		$pgpages = array_keys($this->controller->FData->cdata('pgroups.'.$page['pgid'].'.pages', []));

		// if there is a token then find the previous page
		// if no token then page must be standalone, or accepted or default page
		$proceeding_from = false;
		$failed = false;
		if(!empty($this->data('__cf_token'))){
			//check this is a valid token and get the page
			$tokens = $this->controller->FData->sessiondata('pages.tokens', []);
			$proceeding_from = array_search($this->data('__cf_token'), $tokens);
			// $this->data('__cf_token', null, true);//clear the token to avoid loops if it's wrong

			if($proceeding_from === false OR !$this->is_valid_page($proceeding_from)){
				$failed = true;
				$this->data('__cf_token', null, true);//clear the token to avoid loops if it's wrong
			}else{
				if(empty($this->controller->FData->cdata('pgroups.'.$page['pgid'].'.type'))){
					if(!in_array($pageid, $accepted_pages) AND (!in_array($pageid, $this->controller->FData->cdata('pages.'.$proceeding_from.'.next_page')))){
						$failed = true;
					}
				}

				if(!$failed){
					$this->controller->FData->sessiondata('pages.chain.'.$proceeding_from, $pageid, true);
					// $proceeding_from_id = $this->controller->FData->cdata('pids.'.$proceeding_from);
					$prev_page = $this->controller->FData->cdata('pages.'.$proceeding_from, []);
					// if(empty($this->stopped) AND $proceeding_from AND ($name == $pages_chain[$proceeding_from])){
					// 	$this->controller->Behaviors->apply('new_event_start', $this->controller->FData->cdata('settings.0'), ['page' => $name, 'previous_page' => $proceeding_from, 'output' => &$result]);
					// }

					foreach($this->controller->FData->cdata('pages.'.$proceeding_from.'.inputs', []) as $view_name){
						$view = $this->controller->FData->cdata('views.'.$view_name, []);
						if($this->controller->FData->valid($view)){
							$this->controller->Behaviors->apply('new_event_start', $view);
						}
					}
					if(empty($this->stopped) AND $proceeding_from AND (in_array($pageid, $prev_page['next_page']))){
						// if(($page['sequence'] == $prev_page['sequence']) AND ($page['index'] == $prev_page['index'] + 1)){
							$this->controller->Behaviors->apply('new_event_start', $this->controller->FData->cdata('settings.form'), ['page' => $this->controller->FData->cdata('pages.'.$pageid), 'previous_page' => $prev_page, 'output' => &$result]);
						// }
					}

					foreach($this->controller->FData->cdata('pages.'.$proceeding_from.'.inputs', []) as $view_name){
						$view = $this->controller->FData->cdata('views.'.$view_name, []);
						if($this->controller->FData->valid($view)){
							$this->controller->Behaviors->apply('new_event', $view);
						}
					}
				}
			}
		}else{
			// if no token then page must be standalone, or accepted or default page
			$valid_direct_access = (
				$this->check_page_type($pageid, 'standalone') OR 
				$this->check_page_type($pageid, 'start') OR 
				($pageid == $this->controller->FData->sessiondata('pages.default')) OR 
				($this->controller->FData->sessiondata('pages.accepted.'.$pageid) === true)
			);
			
			if(!$valid_direct_access){
				$failed = true;
			}
		}

		if($failed){
			if(count($accepted_pages)){
				$last_visited_page = array_pop($accepted_pages);
				//$this->controller->FData->sessiondata('pages.tokens.'.$last_visited_page, null, true);
				if($pageid != $last_visited_page){
					$result .= $this->event($last_visited_page);
					$this->stopped = true;
				}
			}else{
				//add the default page to accepted so that it does not go inside this branch again
				// $this->controller->FData->sessiondata('pages.accepted.'.$this->controller->FData->sessiondata('pages.default'), true, true);
				if($pageid != $this->controller->FData->sessiondata('pages.default')){
					$result .= $this->event($this->controller->FData->sessiondata('pages.default'));
					$this->stopped = true;
				}
			}
		}
		
		return $result;
	}
	
	function event($pageid, $settings = []){
		$result = '';

		if($this->is_valid_page($pageid)){
			$this->controller->FData->sessiondata('pages.this', $pageid, true);

			$this->updateVars($pageid, $settings);

			$pgroup_pages = array_keys($this->controller->FData->cdata('pgroups.'.$this->controller->FData->cdata('pages.'.$pageid.'.pgid').'.pages'));
				
			$views = $this->controller->FData->units('views', $pgroup_pages);
			foreach($views as $uid => $unit){
				if($this->controller->FData->valid($unit)){
					$this->controller->Behaviors->apply('initialize_event', $unit);
				}
			}

			$this->controller->Behaviors->apply('initialize_event', $this->controller->FData->cdata('pages.'.$pageid), ['page' => $this->controller->FData->cdata('pages.'.$pageid), 'output' => &$result]);
			
			if(!empty($this->controller->FData->cdata('pages.'.$pageid.'.invalid'))){
				return $result;
			}

			$result .= $this->event_start($pageid, $settings);
			
			if(empty($this->stopped)){
				
				$this->controller->FData->sessiondata('pages.accepted.'.$pageid, true, true);

				if(empty($settings['layout'])){
					// if(empty($settings['inline'])){
						$this->controller->FData->sessiondata('pages.active', $pageid, true);
					// }

					if(!$this->controller->FData->sessiondata('pages.tokens.'.$pageid, '')){
						$this->controller->FData->sessiondata('pages.tokens.'.$pageid, \G3\L\Str::uuid(), true);
					}
				}

				$views = $this->controller->FData->units('views', $pgroup_pages);
				foreach($views as $uid => $unit){
					if($this->controller->FData->valid($unit)){
						$this->controller->Behaviors->apply('event', $unit);
					}
				}

				$this->controller->Behaviors->apply('event', $this->controller->FData->cdata('pages.'.$pageid), ['page' => $this->controller->FData->cdata('pages.'.$pageid), 'output' => &$result]);
			}
		}
		
		$functions = [];
		$functions_names = $this->controller->FData->cdata('areas.'.$pageid.'.functions', []);
		foreach($functions_names as $fn_name){
			$functions[] = $this->controller->FData->cdata('functions.'.$fn_name);
		}
		
		if(0 AND $this->controller->FData->cdata('apptype') == 'connectivity'){
			//connectivity mode
			// $result .= $this->parse($this->controller->FData->cdata('pages.'.$pageid)['content']);
			// $result .= $this->controller->Parser->parse($this->controller->FData->cdata('pages.'.$pageid)['content']);
		}else{
			if(empty($this->stopped) AND !empty($functions)){
				//forms mode
				foreach($functions as $function){
					if(empty($this->stopped)){
						$result .= $this->fn($function);
						
						if(!empty($this->stopped)){
							break;
						}
					}
				}
			}
		}
		
		if($this->is_valid_page($pageid) AND (empty($this->stopped) OR $pageid == $this->controller->FData->sessiondata('pages.default'))){
			$result .= $this->event_finish($pageid);
		}
		
		return $result;
	}
	
	function event_finish($pageid){
		$result = '';

		if($this->controller->Page->check_page_type($pageid, 'end')){
			// $pgroup = $this->controller->FData->cdata('pages.'.$pageid.'.pgroup');
			$this->controller->FData->sessiondata('_clear', $pageid, true);
		}

		$this->controller->Behaviors->apply('event_finish', $this->controller->FData->cdata('settings.form'), ['page' => $this->controller->FData->cdata('pages.'.$pageid), 'output' => &$result]);

		$this->controller->Behaviors->apply('event_finish', $this->controller->FData->cdata('pages.'.$pageid), ['page' => $this->controller->FData->cdata('pages.'.$pageid), 'output' => &$result]);

		foreach($this->controller->FData->units('functions', [$pageid]) as $function){
			$this->controller->Behaviors->apply('event_finish', $function, ['output' => &$result]);
		}

		foreach($this->controller->FData->units('views', [$pageid]) as $view){
			$this->controller->Behaviors->apply('event_finish', $view);
		}

		if($this->check_page_type($pageid, 'end') AND $this->is_single_page($pageid)){
			//single page form
			if($this->is_coming_from($pageid)){
				$this->data = [];
			}
		}
		
		// if(false AND !empty($this->_connection('models')) AND $this->check_page_type($name, 'end')){
		// 	foreach($this->_connection('models') as $model){
		// 		if(empty($model['enabled'])){
		// 			continue;
		// 		}
				
		// 		$data_path = '';
		// 		$multi = false;
		// 		if(!empty($this->data[$model['name']]) AND is_array($this->data[$model['name']])){
		// 			$data_path = $model['name'];
		// 			if(\G3\L\Arr::is_assoc($this->data[$model['name']]) == false){
		// 				$multi = true;
		// 			}
		// 		}
				
		// 		if(!empty($model['relations'])){
		// 			foreach($model['relations'] as $relation){
		// 				if(!empty($relation['type']) AND !empty($relation['model']) AND !empty($relation['fkey'])){
		// 					if($relation['type'] == 'belongsto'){
		// 						if($multi AND !empty($this->data[$model['name']])){
		// 							foreach($this->data($model['name']) as $kd => $vd){
		// 								$path = implode('.', array_filter([$data_path, $kd, $relation['fkey']]));
		// 								$this->data($path, $this->data($relation['model'].'.'.$this->info[$name.'_save_data_'.$relation['model']]['pkey']), true);
		// 							}
		// 						}else{
		// 							$path = implode('.', array_filter([$data_path, $relation['fkey']]));
		// 							$this->data($path, $this->data($relation['model'].'.'.$this->info[$name.'_save_data_'.$relation['model']]['pkey']), true);
		// 						}
		// 					}
		// 				}
		// 			}
		// 		}
				
		// 		$save_data_name = $name.'_save_data_'.$model['name'];
				
		// 		$save_data = [
		// 			'type' => 'save_data',
		// 			'name' => $save_data_name,
		// 			'db_table' => $model['db_table'],
		// 			'model_name' => $model['name'],
		// 			'data_provider' => '{data:'.$data_path.'}',
		// 			'action' => 'insert:ignore',
		// 			//'autofields' => true,
		// 			'overrides' => [
		// 				['action' => 'insert', 'name' => 'created', 'value' => '{date:Y-m-d H:i:s}'],
		// 				['action' => 'insert', 'name' => 'user_id', 'value' => '{user:id}'],
		// 				['action' => 'update', 'name' => 'modified', 'value' => '{date:Y-m-d H:i:s}'],
		// 			],
		// 		];
				
		// 		if($multi AND !empty($this->data[$model['name']])){
		// 			$save_data_var = [];
		// 			foreach($this->data($model['name']) as $kd => $vd){
		// 				$save_data['name'] = $save_data_name.'_'.$kd;
		// 				$save_data['data_provider'] = $vd;
						
		// 				$result .= $this->event_function($name, $save_data);
		// 				$save_data_var[$kd] = $this->get($save_data['name'], []);
		// 			}
		// 		}else{
		// 			$result .= $this->event_function($name, $save_data);
		// 			$save_data_var = $this->get($save_data_name, []);
		// 		}
				
		// 		$this->data = array_replace_recursive($this->data, [$model['name'] => $save_data_var]);
		// 	}
		// }
		
		return $result;
	}

}