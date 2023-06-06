<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\A\E\Chronoforms\H;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Parser2 extends \G3\L\Component{
	var $viewslimit = 0;

	var $pattern = '/{(app|page|view|vw|function|fn|global|var|localvar|data|date|user|const|site|form|summary|session|document|path|locale|language|l|str|url|debug)([\.][^:]+)?:([^}]*?)}/i';
	var $pattern2 = '/\((var|data|date|user|const|session|locale|language|l|str)([\.][^:]+)?:([^}]*?)\)/i';
	

	public function parsev($code, $alt = false, $datapath = null){
		if(is_numeric($code) AND (!is_null($datapath) OR !is_null($this->controller->FData->cdata('views.'.$code.'.datapath')))){
			$datapath = $datapath ?? array_values($this->controller->FData->cdata('views.'.$code.'.datapath'))[0];

			if(!empty($alt) AND !is_null($this->data($datapath.'_'.$alt))){
				return $this->data($datapath.'_'.$alt, '');
			}else{
				return $this->data($datapath, '');
			}
		}
		return $this->parse($code);
	}

	public function parse($code, $pat = 1){
		$return = true;
		
		if(!is_string($code)){
			return $code;
		}
		
		$output = $code;
		
		if(false AND $pat == 2){
			preg_match_all($this->pattern2, $output, $matches);
		}else{
			preg_match_all($this->pattern, $output, $matches);
		}
		
		if(!empty($matches[0])){
			
			$tags = $matches[0];
			$value_required = ($return === true);
			
			$single_tag_required = ($return === true AND count($tags) == 1 AND strlen($tags[0]) == strlen(trim($code)));
			
			foreach($tags as $k => $tag){
				$type = $matches[1][$k];
				$method = ltrim($matches[2][$k], '/.');
				$name = trim($matches[3][$k]);

				if($type == 'l' OR $type == 'L'){
					$type = 'locale';
				}
				
				if($type == 'page'){
					$result = $this->section($name);

				}else if(in_array($type, ['view', 'vw'])){
					$view_unit = $this->controller->FData->cdata('views.'.$this->controller->FData->cdata('uids.views.'.$name));
					$result = $this->view($view_unit);

				}else if(in_array($type, ['function', 'fn'])){
					$fn_unit = $this->controller->FData->cdata('functions.'.$this->controller->FData->cdata('uids.functions.'.$name));
					$result = $this->controller->Page->fn($fn_unit);

				// }else if($type == 'unit'){
				// 	$result = $this->controller->FData->cdata('views.'.$name);

				// }else if($type == 'val' OR $type == 'value'){
				// 	list($name, $default, $params) = $this->params($name);
				// 	$default = $this->parse($default, 2);
					
				// 	$result = $this->get($name, $this->data($name, $default));
					
				// 	$result = $this->methodInfo($method, $result);

				}else if($type == 'global'){
					$result = $this->globals($name);
					
				// }else if($type == 'block'){
				// 	$result = $this->block($name);
				
				}else if($type == 'locale'){
					$result = $this->lang($name);

				}else if($type == 'site'){
					if($name == 'title'){
						$result = \G3\L\Config::get('site.title', '');
					}
				
				}else if($type == 'summary'){
					if($name == '*'){
						$name = [];
					}else{
						$name = [$name];
					}
					$result = $this->summary($name, $method);

				}else if($type == 'localvar'){
					list($name, $default, $params) = $this->params($name);
					// $default = $this->parse($default, 2);
					
					$result = $this->get('_localvars_.'.$name, $default);
					
				}else if($type == 'var'){
					list($name, $default, $params) = $this->params($name);
					// $default = $this->parse($default, 2);
					
					$result = $this->get($name, $default);
					
					$result = $this->methodInfo($method, $result);
				
				}else if($type == 'data'){
					list($name, $default, $params) = $this->params($name);
					// $default = $this->parse($default, 2);
					
					$result = $this->data($name, $default);

					if(is_string($result)){
						$result = str_replace('<?php', '< ?php', $result);
					}
					
					$result = $this->methodInfo($method, $result);
				
				}else if($type == 'const'){
					$result = $this->const($name);
				
				}else if($type == 'url'){
					$result = $this->url($name, $method);
				
				}else if($type == 'document'){
					$result = $this->document($name);
					
				}else if($type == 'path'){
					if(empty($name)){
						$name = \GApp3::instance()->site;
					}
					if($method == 'url'){
						$result = \G3\Globals::ext_url(\GApp3::instance()->extension, $name);
					}else{
						if($name == 'root'){
							$result = \G3\Globals::get('ROOT_PATH');
						}else{
							$result = \G3\Globals::ext_path(\GApp3::instance()->extension, $name);
						}
					}
					$result = rtrim($result, DS);
					
				}else if($type == 'app' OR $type == 'form'){
					if($name == 'title'){
						$result = $this->controller->FData->cdata('title');
					}else if($name == 'id'){
						$result = $this->controller->FData->cdata('id');
					}else if($name == 'alias'){
						$result = $this->controller->FData->cdata('alias');
					}
				
				}else if($type == 'date'){
					list($name, $default, $params) = $this->params($name);
					
					if(empty($name)){
						$name = 'Y-m-d H:i:s';
					}
					
					$method = !empty($method) ? $method : 'utc';
					
					if(!empty($default)){
						$result = \G3\L\Dater::datetime($name, $default, $method);
					}else{
						$result = \G3\L\Dater::datetime($name, null, $method);
					}
				
				}else if($type == 'session'){
					list($name, $default, $params) = $this->params($name);
					// $default = $this->parse($default, 2);
					
					$result = \GApp3::session()->get($name, $default);
					
					$result = $this->methodInfo($method, $result);
				
				}else if($type == 'user'){
					$result = \GApp3::user()->get($name);
				
				}else if($type == 'language'){
					$result = \G3\L\Config::get('site.language');
					
					if($name == 'short'){
						$langs = explode('_', $result);
						$result = $langs[0];
					}
					
				}else if($type == 'debug'){
					if(!empty($this->controller->Page->debug)){
						foreach($this->controller->Page->debug as $dname => $dval){
							$this->controller->Page->debug[$dname]['var'] = $this->get($dname);
							if(!empty($this->controller->Page->debug[$dname]['recipients']) AND !empty($this->controller->Page->debug[$dname]['body'])){
								echo '<h3 class="ui header dividing">'.$dname.' Body</h3>';
								echo $this->controller->Page->debug[$dname]['body'];
							}
						}
					}
					if(empty($name) OR !isset($this->controller->Page->debug[$name])){
						$result = pr3($this->data, true).pr3($this->controller->Page->debug, true);
						if(!empty($this->get('__dev__'))){
							$result = pr3($this->get('__dev__'), true, 'ui segment blue').$result;
						}
					}else{
						$result = pr3($this->controller->Page->debug[$name], true);
					}

					$result = '
					<div class="ui segment tertiary">
						<label class="ui label ribbon quti bg-black text-white"><i class="faicon bug"></i> '.rl3('Debug').'</label>
						<br /><br />
						'.$result.'
					</div>';
					
				}else if($type == 'str'){

					if($name == 'uuid'){
						$result = \G3\L\Str::uuid();

					}else if($name == 'rand'){
						if(!empty($name) AND is_numeric($name)){
							$first = str_repeat('%04X', ceil((float)$name/4));
							$result = substr(sprintf($first, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)), 0, $name);
						}else{
							$result = mt_rand();
						}
						
					}else if($name == 'ip'){
						$result = $_SERVER['REMOTE_ADDR'];
					}
					
				}else{
					$result = '';
					// if($type == 'stop' OR $type == 'end'){
					// 	$this->stopped = true;
					// 	$result = '';
					// }else{
					// 	$result = '';
					// }
				}
				
				if($single_tag_required == true){
					
					if(is_string($result)){
						$result = str_replace($tag, $result, $output);
					}
					
					return $result;
					
				}else{
					if(is_array($result)){
						$result = json_encode($result, JSON_UNESCAPED_UNICODE);
					}
				}
				
				//$output = str_replace($tag, $result, $output);
				$output = substr_replace($output, $result, strpos($output, $tag), strlen($tag));
			}
			
		}
		
		return $output;
	}

	function globals($name){
		$result = null;
		$globals = $this->get('cf_settings.globals', []);
		foreach($globals as $g){
			if($g['name'] == $name){
				$result = $this->parse($g['value']);
			}
		}
		return $result;
	}

	function pset($var, $value, $page = null){
		$this->set($var, $value);

		$page = $page ?? $this->controller->FData->sessiondata('pages.this');

		if($this->controller->FData->sessiondata('pages.this')){
			$pid = $page;//$this->controller->FData->cdata('pids.'.$page);
			// $pgroup = $this->controller->FData->cdata('pages.'.$pid.'.pgroup');
			$this->controller->FData->sessiondata('_vars.'.$pid.'.'.$var, $value, true);
		}
	}

	function pdata($var, $value, $page = null){
		$this->data($var, $value, true);

		$page = $page ?? $this->controller->FData->sessiondata('pages.this');

		if($this->controller->FData->sessiondata('pages.this')){
			$pid = $page;//!is_null($this->controller->FData->cdata('pages.'.$page)) ? $page : $this->controller->FData->cdata('pids.'.$page);
			// $pgroup = $this->controller->FData->cdata('pages.'.$pid.'.pgroup');
			$this->controller->FData->sessiondata('_data.'.$pid.'.'.$var, $value, true);
		}
	}

	// function pget($var, $default = null){
	// 	return $this->get($var, $this->controller->FData->sessiondata('_vars.'.$var, $default));
	// }

	public function ID($str, $limiter = '_'){
		$pattern = '/[^A-Za-z0-9#'.$limiter.']+/';
		
		if(function_exists('mb_convert_encoding')){
			$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
		}
		
		$str = str_replace(array("'", '"'), '', $str);
		$str = preg_replace($pattern, $limiter, $str);
		if(!empty($limiter)){
			$str = preg_replace('/['.$limiter.']+/', $limiter, $str);
		}
		$str = str_replace($limiter.$limiter, $limiter, $str);
		$str = trim($str, $limiter);
		return $str;
	}
	
	function methodInfo($method, $result){
		if(!empty($method)){
			if(strpos($method, '[') !== false){
				$pcs = explode('[', $method);
				$params = explode(';', rtrim($pcs[1], ']'));
				$method = $pcs[0];
			}
			
			if($method == 'count'){
				$result = count($result);
			}else if($method == 'strlen' OR $method == 'length'){
				$result = strlen($result);
			}else if($method == 'empty'){
				$result = empty($result);
			}else if($method == 'sum'){
				$result = array_sum($result);
			}else if($method == 'trim'){
				$result = trim($result);
			}else if($method == 'invert'){
				$result = (int)!((bool)$result);
			}else if($method == 'pr' OR $method == 'print'){
				$result = pr3($result, true);
			}else if($method == 'br'){
				$result = nl2br($result);
			}else if($method == 'slug'){
				$result = \G3\L\Str::slug($result);
			}else if($method == 'jsonen'){
				$result = json_encode($result, JSON_UNESCAPED_UNICODE);
			}else if($method == 'jsonde'){
				$result = json_decode($result, true);
			}else if($method == 'join'){
				$params[0] = !empty($params[0]) ? $this->const($params[0]) : ',';
				$result = implode($params[0], (array)$result);
			}else if($method == 'split'){
				$params[0] = !empty($params[0]) ? $this->const($params[0]) : ',';
				$result = explode($params[0], $result);
			}else if($method == 'ul'){
				if(is_array($result) AND !empty(array_filter($result))){
					$result = '<ul><li>'.implode('</li><li>', (array)$result).'</li></ul>';
				}else{
					$result = implode(' ', (array)$result);
				}
			}
		}
		
		return $result;
	}
	
	function params($string){
		$params = [];
		
		if(strpos($string, '$') !== false){
			$name = explode('$', $string)[0];
			$string = explode('$', $string)[1];

			$_parts = explode('&', $string);
			
			foreach($_parts as $k => $_part){
				if(strpos($_part, '=') !== false){
					$pcs = explode('=', $_part);
					$params[$pcs[0]] = $this->parse(str_replace(['(', ')'], ['{', '}'], $this->const($pcs[1])));
				}else{
					if($k == 0){
						$default = $this->parse(str_replace(['(', ')'], ['{', '}'], $_part));
					}else{
						$params[$pcs[0]] = null;
					}
				}
			}
		}else{
			$name = $string;
			$default = null;
		}

		return [$name, $default, $params];
	}
	
	function document($name){
		if($name == 'url'){
			return \G3\L\Url::current();
		}else if($name == 'title'){
			return \GApp3::document()->title();
		}else if($name == 'referrer'){
			return \G3\L\Url::referer();
		}else if($name == 'agent'){
			return $_SERVER['HTTP_USER_AGENT'];
		}
	}

	function lang($name){
		$site_language = \G3\L\Config::get('site.language');
		$site_language = strtoupper($site_language);

		if($this->controller->FData->cdata('locales.'.$site_language.'.'.$name, '')){
			return $this->parse($this->controller->FData->cdata('locales.'.$site_language.'.'.$name, ''));
		}else{
			return $name;
		}
	}

	function url($name = false, $method = ''){
		$events = array_keys($this->controller->FData->cdata('pids', []));
		$url = $this->_url();
		$methods = explode('.', $method);
		
		list($name, $default, $params) = $this->params($name);

		if(in_array('notvout', $methods)){
			$params['tvout'] = null;
		}
		
		if(!empty($name)){
			// $name = str_replace('.', '::', $name);
			// if(strpos($name, '.') !== false){
			// 	$name_pcs = explode('.', $name);
			// 	$epage = array_pop($name_pcs);
			// 	$name = implode('.', $name_pcs).'::'.$epage;
			// }

			if(in_array($name, $events)){
				$url = \G3\L\Url::build($url, array_merge(['gpage' => $name, 'tvout' => $this->data('tvout')], $params));
			}else if($name == '_self'){
				//return the current url without passing by sef
				if(\GApp3::instance()->extension == 'chronoconnectivity'){
					$url = \G3\L\Url::build(\G3\L\Url::current(), array_merge(['conn' => $this->controller->FData->cdata('alias')], $params));
				}else{
					$url = \G3\L\Url::build(\G3\L\Url::current(), array_merge(['chronoform' => $this->controller->FData->cdata('alias')], $params));
				}
				return $url;
			}else{
				//string which is not a form event
				$url = $this->parse(str_replace(['(', ')'], ['{', '}'], $name));
				if(!empty($params)){
					$url = \G3\L\Url::build($url, $params);
				}
			}
		}
		
		if(!in_array('full', $methods)){
			return r3($url);
		}else{
			return \G3\L\Url::full(r3($url));
		}
	}
	
	function _url(){
		if(\GApp3::instance()->extension == 'chronoconnectivity'){
			$url = 'index.php?ext=chronoconnectivity&cont=manager'.rp3('conn', $this->controller->FData->cdata('alias'));
		//}else if(\GApp3::instance()->extension == 'chronoforms'){
		}else{
			if(\GApp3::instance()->site == 'admin'){
				$url = 'index.php?ext=chronoforms&cont=manager'.rp3('chronoform', $this->controller->FData->cdata('alias'));
			}else{
				$url = 'index.php?ext=chronoforms'.rp3('chronoform', $this->controller->FData->cdata('alias'));
			}
		}
		
		return $url;
	}
	
	function const($name){
		if(strpos($name, '[') === 0 AND strpos($name, ':') !== false){
			//associative array
			$name = trim($name, '[]');
			$name = '{'.$name.'}';
		}
		
		$newValue = json_decode($name, true);
		
		if(is_null($newValue) AND strtolower($name) != 'null'){
			return $name;
		}
		
		return $newValue;
	}

	// function viewLabel($view){
	// 	return $this->parse($view['nodes']['label']['content']);
	// }

	// function viewData($view, $fname){
	// 	// $fname = $view['datapath'];

	// 	$shortcode = '{data:'.$fname.'}';
	// 	if($view['type'] == 'field_textarea'){
	// 		$shortcode = '{data.br:'.$fname.'}';
	// 	}
	// 	if(strpos($view['nodes']['main']['attrs']['name'], '[]') !== false){
	// 		$shortcode = '{data.ul:'.$fname.'}';
	// 	}
		
	// 	if(!empty($view['options'])){
	// 		$options = $this->options($view['options']);
			
	// 		if(is_array($this->data($fname))){
	// 			$shortcode = [];
	// 			foreach($this->data($fname) as $value){
	// 				$shortcode[] = $options[$value]['content'];
	// 			}
	// 			$shortcode = implode(', ', $shortcode);
	// 		}else{
	// 			if(!is_null($this->data($fname))){
	// 				if(isset($options[$this->data($fname)])){
	// 					$shortcode = $options[$this->data($fname)]['content'];
	// 				}
	// 			}
	// 		}
	// 	}

	// 	return $shortcode;
	// }
	
	function summary($pages = [], $method = 'email'){
		$result = '';
		$_repeaters = [];
		$accepted_pages = array_keys($this->controller->FData->sessiondata('pages.accepted', []));

		if(!empty($pages)){
			$accepted_pages = array_intersect($accepted_pages, $pages);
		}
		$inputs = $this->controller->FData->inputs($accepted_pages);
		
		foreach($inputs as $vuid => $view){
			// $view = $this->controller->FData->cdata('views.'.$view_name);

			$valid = true;
			if($method == 'email'){
				$valid = $this->controller->FData->cdata('views.'.$vuid.'.dynamics.email.enabled');
			}
			if($valid){
				if(!empty($view['_repeaters'])){
					if(!in_array($view['_repeaters'][0], $_repeaters)){
						$_repeaters[] = $view['_repeaters'][0];
						$result .= $this->summary_repeater($view, $view['_repeaters'][0], $accepted_pages);
					}
				}else{
					$result .= $this->summary_row($view);
				}
			}
		}

		if($result){
			$result = '<table width="100%" cellpadding="5" cellspacing="5" border="0" class="" style="border:3px solid #e2e2e2; border-radius:7px;" class="ui table">'."\n".$result.'</table>';
		}

		return $this->parse($result);
	}

	function summary_row($view){
		$label = $this->parse($view['nodes']['label']['content']);

		$name = $view['datapath'];

		$shortcode = '{data:'.$name.'}';
		if($view['type'] == 'field_textarea'){
			$shortcode = '{data.br:'.$name.'}';
		}
		if(strpos($view['nodes']['main']['attrs']['name'], '[]') !== false){
			$shortcode = '{data.ul:'.$name.'}';
		}
		
		if(!empty($view['options'])){
			$options = $this->options($view['options']);
			
			if(is_array($this->data($name))){
				$shortcode = [];
				foreach($this->data($name) as $value){
					$shortcode[] = $options[$value]['content'];
				}
				$shortcode = implode(', ', $shortcode);
			}else{
				if(!is_null($this->data($name))){
					if(isset($options[$this->data($name)])){
						$shortcode = $options[$this->data($name)]['content'];
					}
				}
			}
		}

		//$shortcode = str_replace(['{', '}'], '', $shortcode);

		return '<tr style="border:3px solid #e2e2e2;"><td width="50%" valign="middle" align="right" style="background-color:#fafafb; border:3px solid #e2e2e2;"><strong>'.$label.'</strong></td><td width="50%" valign="middle" align="left">'.$shortcode.'</td></tr>';
	}

	function summary_repeater($view, $ruid, $accepted_pages){
		$repeater = $this->controller->FData->cdata('views.'.$ruid);
		$inputs = $this->controller->FData->inputs($accepted_pages, $ruid);
		
		$name = $view['datapath'];

		$result = '';

		// $fname = $repeaters[$repeater]['model'];
		$values = \G3\L\Arr::getVal($this->data, $name, []);

		$result .= '<tr><td valign="top" align="center" colspan="2" style="background-color:#fafafb; border:3px solid #e2e2e2;">';

		foreach($values as $key => $value){
			$result .= '<table width="100%" cellpadding="5" cellspacing="5" border="0" class="" style="border:1px solid #e2e2e2; border-radius:7px;" class="ui table">';
			$result .= '<tr><td valign="top" align="center" colspan="2" style="background-color:#fafafb; border:3px solid #e2e2e2;"><strong>'.$repeater['model'].' #'.$key.'</strong></td></tr>';

			foreach($inputs as $vuid => $unit){
				$unit['datapath'] = str_replace('[n]', $key, $unit['datapath']);
				$unit['nodes']['label']['content'] = str_replace('#'.$repeater['name'].'.index#', $key, $unit['nodes']['label']['content']);
				$result .= $this->summary_row($unit);
			}

			$result .= '</table>';
		}

		$result .= '</td></tr>';

		return $result;
	}

	function dataList($units){
		$repeaters = [];
		$auto = '<table width="100%" cellpadding="5" cellspacing="5" border="0" class="email_content_table" style="border:3px solid #e2e2e2; border-radius:7px;" class="ui table">';
		foreach($units as $eunit){
			$eunit = $this->controller->FData->cdata('views.'.$eunit['uid']);
			
			if($eunit['type'] == 'area_repeater'){
				$rvalues = $this->data('__loops.'.$eunit['uid']);
				
				if(!empty($eunit['_children'])){
					$rcount = 0;
					foreach($rvalues as $rkey => $rvalue){
						foreach($eunit['_children'] as $cid){
							$cunit = $this->controller->FData->cdata('views.'.$cid);
							if(!empty($cunit['ugroups']) AND in_array('inputs', $cunit['ugroups'])){
								$label = $this->parse($cunit['nodes']['label']['content']);

								$keysData = array_keys($cunit['datapath'])[$rcount];
								$dataname = array_values($cunit['datapath'])[$rcount];

								if(!is_numeric($keysData)){
									$keysData = json_decode($keysData, true);
									$label = str_replace(array_keys($keysData), array_values($keysData), $label);
								}
								
								$auto .= $this->buildRow($cunit, $dataname, $label);
							}
						}
						$rcount++;
					}
				}
			}else{
				if(!empty($eunit['datapath'])){
					foreach($eunit['datapath'] as $keysData => $dataname){
						$label = $this->parse($eunit['nodes']['label']['content']);
	
						if(!is_numeric($keysData)){
							$keysData = json_decode($keysData, true);
							$label = str_replace(array_keys($keysData), array_values($keysData), $label);
						}
	
						$auto .= $this->buildRow($eunit, $dataname, $label);
					}
				}
			}
		}

		// $repeaters = array_unique($repeaters);
		// foreach($repeaters as $repeater){
		// 	$runit = $this->controller->FData->cdata('views.'.$repeater);
		// 	$rvalues = $this->data('__loops.'.$rid);
			
		// 	if(!empty($runit['_children'])){
		// 		$rcount = 0;
		// 		foreach($rvalues as $rkey => $rvalue){
		// 			foreach($runit['_children'] as $cid){
		// 				$cunit = $this->controller->FData->cdata('views.'.$cid);
		// 				if(!empty($cunit['ugroups']) AND in_array('inputs', $cunit['ugroups'])){
		// 					$label = $this->parse($cunit['nodes']['label']['content']);

		// 					$keysData = array_keys($cunit['datapath'])[$rcount];
		// 					$dataname = array_values($cunit['datapath'])[$rcount];

		// 					if(!is_numeric($keysData)){
		// 						$keysData = json_decode($keysData, true);
		// 						$label = str_replace(array_keys($keysData), array_values($keysData), $label);
		// 					}
							
		// 					$auto .= $this->buildRow($cunit, $dataname, $label);
		// 				}
		// 			}
		// 			$rcount++;
		// 		}
		// 	}
		// }

		$auto .= '</table>';

		return $auto;
	}

	function buildRow($unit, $dataname, $label){
		$output = '';
		$output .= '<tr style="border:3px solid #e2e2e2;" class="email_content_tr">
		<td width="50%" valign="middle" align="right" style="background-color:#fafafb; border:3px solid #e2e2e2;" class="email_content_td td_label">
		<strong>'.$label.'</strong>
		</td>
		<td width="50%" valign="middle" align="left" class="email_content_td td_value">'
		.$this->displayValue($unit, $this->parsev($unit['uid'], 'email_content', $dataname), 'email')
		.'</td>
		</tr>';

		return $output;
	}

	function displayValue($unit, $value, $target = 'page'){
		$output = $value;

		if($unit['type'] == 'wfield_signature' AND $target == 'page'){
			$output = '<img src="'.$value.'" />';

		}else if($unit['type'] == 'wfield_rating' AND $target == 'page'){
			$output = '<div class="ui yellow rating" data-rating="'.$value.'" data-max-rating="'.$unit['nodes']['main']['attrs']['data-max-rating'].'"></div>';

		}else if($unit['type'] == 'field_file' AND $target == 'page'){
			if(is_array($value)){
				$output = '<ul>';
				foreach($value as $val){
					$output .= '<li><a href="'.r3('index.php?ext=chronoforms&cont=logs&act=file&fname='.$val.'&form_id='.$this->data('form_id')).'">'.$val.'</a></li>';
				}
				$output .= '</ul>';
			}else{
				$output = '<a href="'.r3('index.php?ext=chronoforms&cont=logs&act=file&fname='.$value.'&form_id='.$this->data('form_id')).'">'.$value.'</a>';
			}

		}else if($unit['type'] == 'field_textarea'){
			$output = nl2br($value);

		}else if(!empty($unit['options'])){
			$options = $this->options($unit['options']);
			
			if(is_array($value)){
				$shortcode = [];
				foreach($value as $val){
					if(isset($options[$val]['content'])){
						$shortcode[] = $options[$val]['content'];
					}else{
						$shortcode[] = $val;
					}
				}
				$output = implode(', ', $shortcode);
			}else{
				if(!is_null($value)){
					if(isset($options[$value])){
						$output = $options[$value]['content'];
					}
				}
			}
		}else{
			if(is_array($output)){
				if(!empty($output)){
					$output = '<ul><li>'.implode('</li><li>', $output).'</li></ul>';
				}else{
					$output = '';// json_encode($output);
				}
			}
		}

		return $output;
	}
	
	function section($name, $method = false){
		$result = '';
		
		// if(empty($this->controller->FData->cdata('views'))){
		// 	return '';
		// }

		$name = str_replace('.', '_', $name);
		
		$views = [];
		$views_names = $this->controller->FData->cdata('areas.'.$name.'.views', []);
		foreach($views_names as $view_name){
			$views[] = $this->controller->FData->cdata('views.'.$view_name);
		}
		
		if(!empty($views)){
			foreach($views as $view){
				$result .= $this->view($view);
			}
		}

		if($this->controller->FData->cdata('apptype') == 'connectivity'){
			$pid = $name;//$this->controller->FData->cdata('pids.'.$name);
			
			if(!empty($this->controller->FData->cdata('pages.'.$pid))){
				$result .= $this->parse($this->controller->FData->cdata('pages.'.$pid.'.content', ''));
			}
		}
		
		if(!empty($this->controller->FData->cdata('pages.'.$name))){
			$result = $this->section_finish($name, $result);
		}
		
		return $result;
	}
	
	function section_finish($pageid, $output){

		if($this->data('gact') != 'ajax'){
			if(strpos($output, 'data-sortable=') !== false){
				\GApp3::document()->_('jquery-ui');
			}

			\GApp3::document()->__('keepalive');

			\GApp3::document()->addCssCode('.ui.form input{box-sizing:border-box;}');
			// \GApp3::document()->addJsCode($jscode);
			\GApp3::document()->_('g3.forms');

			if(strpos($output, 'data-inputmask=') !== false){
				\GApp3::document()->_('jquery.inputmask');
			}
			if(strpos($output, 'data-signature=') !== false){
				\GApp3::document()->_('signature_pad');
				\GApp3::document()->addJsCode('jQuery(document).ready(function($){$.G3.signature_pad.ready();});');
			}
			if(strpos($output, 'data-editor=') !== false){
				\GApp3::document()->_('tinymce');
				//\GApp3::document()->addJsCode('jQuery(document).ready(function($){$.G3.tinymce.init();});');
			}
			
			$this->controller->Behaviors->apply('section_finish', $this->controller->FData->cdata('settings.form'), ['page' => $this->controller->FData->cdata('pages.'.$pageid), 'output' => &$output]);

			$this->controller->Behaviors->apply('section_finish', $this->controller->FData->cdata('pages.'.$pageid), ['page' => $this->controller->FData->cdata('pages.'.$pageid), 'output' => &$output]);
		}
		
		foreach($this->controller->FData->units('functions', [$pageid]) as $function){
			$this->controller->Behaviors->apply('section_finish', $function, ['output' => &$output]);
		}
		// if($this->controller->Page->check_page_type($name, 'end')){
		// 	$this->controller->FData->sessiondata(false);
		// }
		
		return $output;
	}
	
	function view($unit){
		$result = null;

		$unit = $this->controller->Behaviors->apply('before_view', $unit);
		
		if(!empty($unit) AND $this->controller->FData->valid($unit)){
			if($this->get('__invalid')){
				if(!empty($unit['_paid'])){
					return '<span class="ui text red field quti block">'.$unit['_paid'].' is disabled in the free version frontend</span>';
				}
			}
			// if($this->viewslimit > $this->get('__viewslimit', 999999)){
			// 	\GApp3::session()->flash('warning', 'One element is not displayed on the frontend because the extension is not validated.');
			// 	return '';
			// }
			if(strpos($unit['type'], 'area_') !== 0){
				$this->viewslimit++;
			}
			//get output file
			$views_path = \G3\Globals::ext_path('chronoforms', 'admin').'views'.DS.$unit['type'].DS.$unit['type'].'_output.php';
			
			$result = $this->viewer->view($views_path, ['view' => $unit], true);
		}
		
		return $result;
	}

	// ***************

	// function options($options){
	// 	$field_options = [];

	// 	foreach($options as $k => $option_object){
	// 		foreach($option_object as $ok => $ov){
	// 			$option_object[$ok] = $this->parse($ov);
	// 			if(empty($option_object[$ok]) AND $ok != 'value' AND $ok != 'content'){
	// 				unset($option_object[$ok]);
	// 			}
	// 		}
			
	// 		$value = $option_object['value'];
	// 		$content = $option_object['content'];
			
	// 		if(!empty($value) AND empty($content)){
	// 			$content = $value;
	// 		}
			
	// 		// if(is_array($value)){
	// 		// 	$field_options = array_replace($field_options, $value);
	// 		// 	continue;
	// 		// }
			
	// 		$field_options[$value] = array_merge($option_object, ['content' => $content]);
	// 	}
		
	// 	return $field_options;
	// }

	function getNames($name){
		$list = [];

		if(!empty($this->data('__loops', []))){
			foreach($this->data('__loops', []) as $loopuid => $ldata){
				$model = $this->getModel($this->controller->FData->cdata('views.'.$loopuid));
				
				if(strpos($name, '#'.$model.'.') !== false){
					foreach($ldata as $key => $value){
						// $list[$key]['name'] = str_replace('#'.$model, $key, $name);
						// $list[$key]['index']['#'.$model] = $key;
						$list[json_encode(['#'.$model => $key])] = str_replace('#'.$model, $key, $name);
					}
				}
			}
		}

		return $list;
	}

	function getModel($view, $functions = []){
		if(!empty($view['data_source'])){
			if(is_numeric($view['data_source'])){
				if(!empty($functions)){
					$read_data = $functions[$view['data_source']];
				}else{
					$read_data = $this->controller->FData->cdata('functions.'.$view['data_source']);
				}
				
				$model = $read_data['models']['data']['vname'];
			}else{
				$model = $view['data_source'];
			}
		}else{
			$model = $view['name'];
		}

		return $model;
	}

	function options($options, $attr = 'content'){
		$field_options = [];

		foreach($options as $k => $option_object){
			foreach($option_object as $ok => $ov){
				$option_object[$ok] = $this->parse($ov);
			}
			
			$value = $option_object['value'];
			if(is_array($value)){
				foreach($value as $vk => $vt){
					$key = \G3\L\Arr::is_assoc($value) ? $vk : $vt;
					$field_options[$key] = ['value' => $key, $attr => $vt];
				}
				continue;
			}
			$content = $option_object[$attr];
			
			if(!empty($value) AND empty($content)){
				$content = $value;
			}
			
			$field_options[$value] = array_replace($option_object, ['value' => $value, $attr => $content]);
		}
		// pr($field_options);
		return $field_options;
	}

	function dataLoad($output, $data){
		$DataLoader = new \G3\H\DataLoader();
		$output = $DataLoader->load($output, $data);
		unset($DataLoader);
		return $output;
	}
	
	function end(){

	}
}