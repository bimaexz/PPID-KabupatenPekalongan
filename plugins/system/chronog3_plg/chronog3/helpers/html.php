<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\H;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Html{

	public function _attrs($params){
		$list = [];
		foreach($params as $name => $value){
			$list[] = $this->_attr($name, $value);
		}
		
		return implode(' ', $list);
	}
	
	public function _attr($name, $value){
		if(strpos($value, "'") !== false AND strpos($value, '"') !== false){
			return $name.'="'.htmlspecialchars($value).'"';
		}else if(strpos($value, '"') !== false){
			return $name."='".$value."'";
		}else{
			return $name.'="'.$value.'"';
		}
	}

	function node($node){
		$out = [];

		if(!is_array($node)){
			return $node;
		}

		if(!isset($node['tag'])){
			$node['tag'] = 'div';
		}

		if(!isset($node['content'])){
			if(in_array($node['tag'], ['div', 'textarea', 'span', 'button', 'i', 'li', 'ol', 'ul', 'p', 'pre', 'blockquote', 'a', 'table', 'tr', 'td', 'th', 'canvas'])){
				$node['content'] = [];
			}
		}

		if(!empty($node['before'])){
			foreach($node['before'] as $child){
				if(is_array($child) AND empty($child['active']) AND empty($child['children'])){
					continue;
				}
				$out[] = $this->node($child);
			}
		}

		$out[] = '<'.$node['tag'];
		
		if(!empty($node['attrs'])){
			foreach($node['attrs'] as $attr => $val){
				if(is_array($val)){
					$val = \G3\L\Arr::flatten($val);
					$val = implode(' ', array_unique($val));
				}else if(is_bool($val)){
					$val = $attr;
				}

				$out[] = ' '.$this->_attr($attr, $val);
			}
		}

		if(isset($node['children']) OR isset($node['content'])){
			if(isset($node['content']) AND (!empty($node['content']) OR $node['content'] == '0')){
				$node['content'] = [$node['content']];
			}else{
				$node['content'] = [];
			}

			if(!empty($node['children'])){
				foreach($node['children'] as $child){
					if(is_array($child) AND empty($child['active']) AND empty($child['children'])){
						continue;
					}
					$node['content'][] = $this->node($child);
				}
			}

			if(empty($node['active'])){
				return implode('', $node['content']);
			}
		}

		if(!isset($node['content'])){
			$out[] = ' />';
		}else{
			if(is_array($node['content'])){
				$node['content'] = implode('', $node['content']);
			}
			$out[] = '>'.$node['content'].'</'.$node['tag'].'>';
		}

		if(!empty($node['after'])){
			foreach($node['after'] as $child){
				if(is_array($child) AND empty($child['active']) AND empty($child['children'])){
					continue;
				}
				$out[] = $this->node($child);
			}
		}

		return implode('', $out);
	}

	public function a($text, $href, $attrs = []){
		return $this->node([
			'tag' => 'a', 
			'active' => true, 
			'content' => $text, 
			'attrs' => array_replace(['href' => $href], $attrs)
		]);
	}

	public function toggler($status, $href){
		return $this->node([
			'tag' => 'a', 
			'active' => true, 
			'content' => '<i class="faicon '.((int)$status ? 'check' : 'times').'"></i>', 
			'attrs' => [
				'href' => $href,
				'class' => 'compact ui button icon mini circular quti text-white rounded-full p-2 '.((int)$status ? 'bg-green700' : 'bg-red700'),
			]
		]);
	}
	
}