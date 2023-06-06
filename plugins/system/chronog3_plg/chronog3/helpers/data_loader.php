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
class DataLoader{
	var $names = [];
	var $data = [];
	
	var $ghost_pattern = '/data-ghost=["-\']1["-\']/i';
	var $name_pattern = '/ name=("|\')(.*?)("|\')/i';
	var $value_pattern = '/ value=("|\')(.*?)(\1)/i';
	var $checked_pattern = '/ checked(=("|\')checked("|\'))?/i';
	var $textarea_pattern = '/(<textarea(.*?)>)(.*?)(<\/textarea>)/is';
	//var $selected_pattern = '/selected=("|\')selected("|\')/i';
	//var $option_pattern = '/<option(.*?)<\/option>/is';
	
	public function load($html, $data = array(), $skipped = array()){
		if(!empty($html)){
			//get all fields names			
			preg_match_all('/name=("|\')([^(>|"|\')]*?)("|\')/i', $html, $names);
			
			$this->names = $names[2];
			
			if(!empty($data)){
				//$this->data = explode('_-&-_', urldecode(http_build_query($data, '', '_-&-_')));
				$this->data = $data;
			}
			
			if(!empty($this->names)){
				$this->text($html);
				$this->file($html);
				$this->check($html);
				$this->textarea($html);
				$this->select($html);
			}
		}
		
		return $html;
	}
	
	private function text(&$html){
		$pattern = '/<input([^>]*?)type=("|\')(text|password|hidden|color|date|datetime|datetime-local|email|month|number|range|search|tel|time|url|week)(\2)([^>]*?)>/is';
		preg_match_all($pattern, $html, $matches);
		
		if(!empty($matches)){
			foreach($matches[0] as $field){
				if(strpos($field, 'data-ghost=') !== false){
					continue;
				}
				
				preg_match($this->name_pattern, $field, $name_attr);
				if(!empty($name_attr[2])){
					$field_name = $name_attr[2];
					$data_value = $this->getValue($field_name, ['"']);
					
					if(is_array($data_value)){
						continue;
						//$data_value = array_shift($data_value);
					}
					
					if($data_value !== false){
						$field_cleaned = preg_replace([$this->name_pattern, $this->value_pattern], '', $field);
						
						$updated_field = str_replace('<input ', '<input name="'.$field_name.'" value="'.$data_value.'" ', $field_cleaned);
						
						$pos = strpos($html, $field);
						$html = substr_replace($html, $updated_field, $pos, strlen($field));
					}
				}
			}
		}
	}

	private function file(&$html){
		$pattern = '/<input([^>]*?)type=("|\')(file)(\2)([^>]*?)>/is';
		preg_match_all($pattern, $html, $matches);
		
		if(!empty($matches)){
			foreach($matches[0] as $field){
				if(strpos($field, 'data-ghost=') !== false){
					continue;
				}
				
				preg_match($this->name_pattern, $field, $name_attr);
				if(!empty($name_attr[2])){
					$field_name = $name_attr[2];
					$data_value = $this->getValue($field_name, ['"']);
					
					if($data_value !== false AND !empty($data_value)){
						$data_value = json_encode((array)$data_value);
						$field_cleaned = preg_replace([$this->name_pattern, $this->value_pattern], '', $field);
						
						$updated_field = str_replace('<input ', '<input name="'.$field_name.'" data-files=\''.$data_value.'\' ', $field_cleaned);
						
						$pos = strpos($html, $field);
						$html = substr_replace($html, $updated_field, $pos, strlen($field));
					}
				}
			}
		}
	}
	
	private function check(&$html){
		//checkboxes or radios fields
		$pattern = '/<input([^>]*?)type=("|\')(checkbox|radio)("|\')([^>]*?)>/is';
		preg_match_all($pattern, $html, $matches);
		
		if(!empty($matches)){
			foreach($matches[0] as $field){
				if(strpos($field, 'data-ghost=') !== false){
					continue;
				}
				
				preg_match($this->name_pattern, $field, $name_attr);
				preg_match($this->value_pattern, $field, $value_attr);
				
				if(!empty($name_attr[2])){
					$field_name = $name_attr[2];
					$field_value = isset($value_attr[2]) ? $value_attr[2] : null;
					
					$data_value = $this->getValue($field_name);
					
					if($data_value !== false){
						$updated_field = $field;
						//multi values
						if(is_array($data_value)){
							if(!is_null($field_value) AND in_array($field_value, $data_value)){
								$updated_field = preg_replace($this->name_pattern, ' name="${2}" checked="checked"', $field);
							}else{
								//remove any default value set in the html code
								$updated_field = preg_replace($this->checked_pattern, ' ', $field);
							}
						//single values
						}else{
							if(!is_null($field_value) AND $data_value == $field_value){
								$updated_field = preg_replace($this->name_pattern, ' name="${2}" checked="checked"', $field);
							}else{
								//remove any default value set in the html code
								$updated_field = preg_replace($this->checked_pattern, ' ', $field);
							}
							//single checkbox with no value attaribute, accepted value should be "on"
							if(is_null($field_value) AND $data_value == 'on'){
								$updated_field = preg_replace($this->name_pattern, ' name="${2}" checked="checked"', $field);
							}
						}
						
						$html = str_replace($field, $updated_field, $html);
					}
				}
			}
		}
	}
	
	private function textarea(&$html){
		//textarea fields
		$pattern = '/<textarea([^>]*?)>(.*?)<\/textarea>/is';
		preg_match_all($pattern, $html, $matches);
		
		if(!empty($matches)){
			foreach($matches[0] as $field){
				if(strpos($field, 'data-ghost=') !== false){
					continue;
				}
				
				preg_match($this->name_pattern, $field, $name_attr);
				if(!empty($name_attr[2])){
					$field_name = $name_attr[2];
					$data_value = $this->getValue($field_name, ['<', '>']);
					
					if($data_value !== false AND is_string($data_value)){
						//$updated_field = preg_replace($this->textarea_pattern, '${1}'.str_replace(['\\', '$'], ['\\\\', '\$'], $data_value).'${4}', $field);
						$updated_field = preg_replace($this->textarea_pattern, '${1}___DUMMYx0xTEXT___${4}', $field);
						$updated_field = str_replace('___DUMMYx0xTEXT___', $data_value, $updated_field);
						$html = str_replace($field, $updated_field, $html);
					}
				}
			}
		}
	}
	
	private function select(&$html){
		//select boxes
		$pattern = '/<select([^>]*?)>(.*?)<\/select>/is';
		preg_match_all($pattern, $html, $matches);
		
		if(!empty($matches)){
			foreach($matches[0] as $field){
				if(strpos($field, 'data-ghost=') !== false){
					continue;
				}
				$updated_field = $field;
				
				preg_match($this->name_pattern, $field, $name_attr);
				if(!empty($name_attr[2])){
					$field_name = $name_attr[2];
					$data_value = $this->getValue($field_name);
					
					if($data_value !== false){
						$data_value = (array)$data_value;
						$set_values = [];
						
						preg_match_all('/<option(.*?)<\/option>/is', $field, $matched_options);
						foreach($matched_options[0] as $matched_option){
							preg_match($this->value_pattern, $matched_option, $matched_option_value);
							$updated_option = $matched_option;
							$option_value = isset($matched_option_value[2]) ? $matched_option_value[2] : null;
							
							if(!is_null($option_value)){
								if(in_array($option_value, $data_value)){
									//this option is selected
									$updated_option = preg_replace('/selected="selected"/i', '', $matched_option);
									$updated_option = preg_replace('/<option/i', '<option selected="selected"', $updated_option);
									$set_values[] = $option_value;
								}else{
									//this option is not selected
									$updated_option = preg_replace('/selected=("|\')selected("|\')/i', '', $matched_option);
								}
							}
							$updated_field = str_replace($matched_option, $updated_option, $updated_field);
						}
						
						if((count($data_value) > count($set_values)) AND (strpos($field, 'data-allowadditions="1"') !== false OR strpos($field, 'data-keepnonexistent="1"') !== false)){
							foreach($data_value as $dvalue){
								//check the value is not empty (important, because it may be a ghost value of multi dropdown) and not in the select options
								if(!empty($dvalue) AND !in_array($dvalue, $set_values)){
									$updated_field = preg_replace('/<\/select>/i', '<option selected="selected" value="'.$dvalue.'">'.$dvalue.'</option></select>', $updated_field);
								}
							}
						}
						
						$pos = strpos($html, $field);
						$html = substr_replace($html, $updated_field, $pos, strlen($field));
					}
				}
			}
		}
	}
	
	private function getValue($name, $escape = false){
		$path = str_replace(']', '', $name);
		$parts = explode('[', $path);
		foreach($parts as $k => $v){
			if(strlen(trim($v)) == 0){
				$parts[$k] = '[n]';
			}
		}
		
		$return = \G3\L\Arr::getVal($this->data, $parts, false);

		//if this is a multi checkbox or multi select and had no selections, we check for the default passed ghost value
		if($return === false AND array_pop($parts) == '[n]'){
			$return = \G3\L\Arr::getVal($this->data, $parts, false);
		}
		
		if($return !== false AND is_string($return) AND !empty($escape)){
			//$return = htmlspecialchars($return, ENT_QUOTES);//escape any special (") or regex chars ($)
			//$return = str_replace(['"', "'", "$"], ["&#34;", "&#39;", "&#36;"], $return);//escape any special (") or regex chars ($)
			//$return = str_replace(['"', "'"], ["&#34;", "&#39;"], $return);//escape any special (") or regex chars ($)
			//$return = str_replace(['"'], ["&#34;"], $return);//escape any special (") or regex chars ($)
			$return = str_replace($escape, array_map('htmlentities', $escape), $return);//escape any special (") or regex chars ($)
		}
		return $return;
	}
}