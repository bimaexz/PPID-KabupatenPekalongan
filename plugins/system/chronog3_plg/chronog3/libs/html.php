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
class Html {
	//get the data path from the field name
	public static function dpath($field_name, $add_keys = false){
		static $parsed = [];
		if($add_keys AND strpos($field_name, '[]') !== false){
			$count = array_count_values($parsed);
			$next = isset($count[$field_name]) ? $count[$field_name] : 0;
			$parsed[] = $field_name;
			$field_name = str_replace('[]', '['.$next.']', $field_name);
		}else{
			$field_name = str_replace('[]', '', $field_name);
		}
		
		$field_name = str_replace(['[', ']'], ['.', ''], $field_name);
		$field_name = str_replace(['-N-'], ['[n]'], $field_name);
		
		return $field_name;
	}
	
	//get the last name from the data path
	public static function lname($fname){
		$parts = explode('.', $fname);
		$parts = array_reverse($parts);
		foreach($parts as $part){
			if(strpos($part, '}') === false AND strpos($part, '{') === false AND strpos($part, ']') === false AND strpos($part, '[') === false){
				return $part;
			}
		}
	}
}