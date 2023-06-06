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
class Route {
	
	public static function clean($url){
		$url = strip_tags($url);
		$url = str_replace(['"', "'"], '', $url);
		
		return $url;
	}
	
	public static function translate($url){
		$urlComponents = parse_url($url);
		
		if(!empty($urlComponents['query'])){
			parse_str($urlComponents['query'], $vars);
			
		}
		
		return $url;
	}
	
	public static function _($query, $params = []){
		if((bool)Config::get('sef.enabled') === false){
			return $query;
		}

		$query = self::clean($query);
		
		if(is_string($params)){
			$flags = str_split($params);
			$xhtml = in_array('x', $flags);
			$absolute = in_array('f', $flags);
			$ssl = in_array('s', $flags);
			$dynamic = in_array('d', $flags);
		}else{
			$xhtml = $params['xhtml'] ?? false;
			$absolute = $params['absolute'] ?? $params['full'] ?? false;
			$ssl = $params['ssl'] ?? null;
		}

		if(!empty(\G3\Globals::get('app'))){
			if(!empty(\G3\L\Config::get('routes.ext'))){
				foreach(\G3\L\Config::get('routes.extensions') as $k => $v){
					$query = str_replace('ext='.$k, \G3\L\Config::get('routes.ext').'='.$v, $query);
				}
			}

			if(!empty(\G3\L\Config::get('routes.sef'))){
				$query = \G3\L\Config::get('routes.sef')($query);
			}
		}

		if($xhtml){
			$query = str_replace('&', '&amp;', $query);
		}

		if($absolute){

			// $fullUrlComs = parse_url(\G3\L\Url::full(''));

			// $queryComs = parse_url($query);

			// if(!empty($fullUrlComs['path']) AND !empty($queryComs['path'])){
			// 	if(strpos($queryComs['path'], $fullUrlComs['path']) === 0){
			// 		$query = substr($query, strlen($fullUrlComs['path']));
			// 	}
			// }

			$query = \G3\L\Url::full($query);
		}

		if($ssl){
			$query = str_replace('http:', 'https:', $query);
		}

		if(!empty(\G3\Globals::get('app'))){
			return $query;
		}
		
		$urlComponents = parse_url($query);
		
		if(empty($urlComponents['query'])){
			return $query;
		}
		
		$result = [];
		if(!empty($urlComponents['path'])){
			$result[] = $urlComponents['path'];
			$result[] = '/';
		}
		
		parse_str($urlComponents['query'], $vars);
		$segments = self::build($vars);
		
		$result[] = implode('/', $segments);
		if(!empty($vars)){
			$result[] = '?';
			$result[] = http_build_query($vars, '', ($xhtml ? '&amp;' : '&'));
		}
		
		if(!empty($urlComponents['fragment'])){
			$result[] = '#';
			$result[] = $urlComponents['fragment'];
		}
		
		return implode('', $result);
	}
	
	public static function build(&$vars){
		$segments = array();
		
		if(!empty($vars['ext'])){
			$segments[] = $vars['ext'];
			unset($vars['ext']);
		}
		if(!empty($vars['cont'])){
			$segments[] = $vars['cont'];
			unset($vars['cont']);
		}
		if(!empty($vars['act'])){
			$segments[] = $vars['act'];
			unset($vars['act']);
		}
		$vps = array('u', 'm', 'f', 't', 'p');
		foreach($vps as $vp){
			if(!empty($vars[$vp])){
				$segments[] = $vp.$vars[$vp];
				unset($vars[$vp]);
			}
		}
		
		if(!empty($vars['alias'])){
			$segments[] = $vars['alias'];
			unset($vars['alias']);
		}
		
		return $segments;
	}
}