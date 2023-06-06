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
class QutiCss{
	var $colors = [
		'transparent' => 'transparent',
		'current' => 'currentColor',

		'white' => 'ffffff',
		'black' => '000000',

		'grey' => 'a0aec0',
		'grey100' => 'f7fafc',
		'grey200' => 'edf2f7',
		'grey300' => 'e2e8f0',
		'grey400' => 'cbd5e0',
		'grey500' => 'a0aec0',
		'grey600' => '718096',
		'grey700' => '4a5568',
		'grey800' => '2d3748',
		'grey900' => '1a202c',

		'red' => 'F56565',
		'red100' => 'FFF5F5',
		'red200' => 'FED7D7',
		'red300' => 'FEB2B2',
		'red400' => 'FC8181',
		'red500' => 'F56565',
		'red600' => 'E53E3E',
		'red700' => 'C53030',
		'red800' => '9B2C2C',
		'red900' => '742A2A',

		'orange' => 'ED8936',
		'orange100' => 'FFFAF0',
		'orange200' => 'FEEBC8',
		'orange300' => 'FBD38D',
		'orange400' => 'F6AD55',
		'orange500' => 'ED8936',
		'orange600' => 'DD6B20',
		'orange700' => 'C05621',
		'orange800' => '9C4221',
		'orange900' => '7B341E',

		'yellow' => 'ECC94B',
		'yellow100' => 'FFFFF0',
		'yellow200' => 'FEFCBF',
		'yellow300' => 'FAF089',
		'yellow400' => 'F6E05E',
		'yellow500' => 'ECC94B',
		'yellow600' => 'D69E2E',
		'yellow700' => 'B7791F',
		'yellow800' => '975A16',
		'yellow900' => '744210',

		'green' => '48BB78',
		'green100' => 'F0FFF4',
		'green200' => 'C6F6D5',
		'green300' => '9AE6B4',
		'green400' => '68D391',
		'green500' => '48BB78',
		'green600' => '38A169',
		'green700' => '2F855A',
		'green800' => '276749',
		'green900' => '22543D',

		'teal' => '38B2AC',
		'teal100' => 'E6FFFA',
		'teal200' => 'B2F5EA',
		'teal300' => '81E6D9',
		'teal400' => '4FD1C5',
		'teal500' => '38B2AC',
		'teal600' => '319795',
		'teal700' => '2C7A7B',
		'teal800' => '285E61',
		'teal900' => '234E52',

		'blue' => '4299E1',
		'blue100' => 'EBF8FF',
		'blue200' => 'BEE3F8',
		'blue300' => '90CDF4',
		'blue400' => '63B3ED',
		'blue500' => '4299E1',
		'blue600' => '3182CE',
		'blue700' => '2B6CB0',
		'blue800' => '2C5282',
		'blue900' => '2A4365',

		'indigo' => '667EEA',
		'indigo100' => 'EBF4FF',
		'indigo200' => 'C3DAFE',
		'indigo300' => 'A3BFFA',
		'indigo400' => '7F9CF5',
		'indigo500' => '667EEA',
		'indigo600' => '5A67D8',
		'indigo700' => '4C51BF',
		'indigo800' => '434190',
		'indigo900' => '3C366B',

		'purple' => '9F7AEA',
		'purple100' => 'FAF5FF',
		'purple200' => 'E9D8FD',
		'purple300' => 'D6BCFA',
		'purple400' => 'B794F4',
		'purple500' => '9F7AEA',
		'purple600' => '805AD5',
		'purple700' => '6B46C1',
		'purple800' => '553C9A',
		'purple900' => '44337A',

		'pink' => 'ED64A6',
		'pink100' => 'FFF5F7',
		'pink200' => 'FED7E2',
		'pink300' => 'FBB6CE',
		'pink400' => 'F687B3',
		'pink500' => 'ED64A6',
		'pink600' => 'D53F8C',
		'pink700' => 'B83280',
		'pink800' => '97266D',
		'pink900' => '702459',
	];

	var $breakpoints = [
		'sm' => 640,
		'md' => 768,
		'lg' => 1024,
		'xl' => 1280,
	];

	public static function getClasses($html){
		preg_match_all('/ class=("|\')(.*?)quti (.*?)(\1)/i', $html, $classes);
		// pr($classes);
		$classes = array_unique($classes[3]);
		// pr($classes);
		return $classes;
	}

	public function getStyles($css, $minified = false){
		$code = '';
		$n = ($minified ? "" : "\n");
		$t = ($minified ? "" : "\t");
		foreach($css as $media => $styles){
			if(!empty($media)){
				$code .= "@media (min-width: ".$this->breakpoints[$media]."px){".$n;
			}
			foreach($styles as $title => $rules){
				$imp = '!important';
				if(strpos($title, '.') !== false OR strpos($title, '@') !== false OR in_array($title, ['segment'])){
					$imp = '';
				}
				$point = '.';
				if(strpos($title, '.') === 0 OR strpos($title, '@') !== false){
					$point = '';
				}
				// $imp = (strpos($title, 'ui') === 0 OR strpos($title, '@') === 0) ? '' : '!important';
				$code .= $point.(!empty($media) ? $media.'\:' : '').$title."{".$n;
				foreach($rules as $rname => $rvalue){
					if(is_array($rvalue)){
						foreach($rvalue as $rvalue2){
							$code .= $t.$rname.":".$rvalue2.$imp.";".$n;
						}
					}else{
						if(in_array($rname, ['content', 'font-family'])){
							$code .= $t.$rname.":'".$rvalue."';".$n;
						}else{
							$code .= $t.$rname.":".$rvalue.$imp.";".$n;
						}
					}
				}
				$code .= "}".$n;
			}
			if(!empty($media)){
				$code .= "}".$n;
			}
		}

		return $code;
	}

	public function getCss($html){
		$classes = self::getClasses($html);

		if(!empty(\GApp3::instance()->get('quti.colors'))){
			foreach(\GApp3::instance()->get('quti.colors') as $color => $value){
				$this->colors[$color] = $value;
			}
		}

		$found = [];

		foreach($classes as $class){
			$clist = explode(' ', $class);

			foreach($clist as $citem){
				$found[] = $citem;
			}
		}
		$found = array_unique($found);
		// pr($found);

		$css = [
			'' => [
				'.quti' => [
					'box-sizing' => 'border-box',
					'border' => '0 solid #000',
				],
				//breaks ace editor
				// '.quti *' => [
				// 	'box-sizing' => 'border-box',
				// 	'border' => '0 solid #000',
				// ]
			]
		];
		foreach($found as $class){
			if(!isset($css[$class])){
				$css = array_merge_recursive($css, $this->buildCss($class, []));
			}
		}

		// pr($css);
		// pr($this->getStyles($css));

		return $this->getStyles($css);
	}

	public function buildCss($class, $uis = []){
		$class_data = explode(":", $class);
		$media = '';
		if(count($class_data) == 1){
			$class = $class;
		}else if(count($class_data) == 2){
			$class = $class_data[1];
			if(in_array($class_data[0], ['sm', 'md', 'lg', 'xl'])){
				$media = $class_data[0];
			}else{
				$event = $class_data[0];
			}
		}else if(count($class_data) == 3){
			$class = $class_data[2];
			$media = $class_data[0];
			$event = $class_data[1];
		}
		$params = explode('-', $class);
		$type = array_shift($params);

		$name = $class;
		if(!empty($event)){
			$name = $event.'\:'.$name.':'.$event;
		}
		$values = [];

		// pr($name);

		$css = [];

		if($type == 'disabled'){
			$css[$type] = [
				'opacity' => '0.45',
				'color' => 'rgba(40, 40, 40, 0.3)',
				'cursor' => 'default',
				'pointer-events' => 'none',
			];

		}else if($type == 'segment'){
			$css[$type] = [
				'position' => 'relative',
				'background-color' => '#fff',
				'margin' => '1rem 0',
				'padding' => '1em 1em',
				// 'border-radius' => '0.28571429rem',
				'border' => '1px solid rgba(34, 36, 38, 0.15)',
			];
			$css[$type.':first-child'] = [
				'margin-top' => '0',
			];
			$css[$type.':last-child'] = [
				'margin-bottom' => '0',
			];

		}else if($type == 'loading'){
			$css[$type] = [
				'position' => 'relative',
				'cursor' => 'default',
				'pointer-events' => 'none',
				'text-shadow' => 'none',
				'-webkit-transition' => 'all 0s linear',
				'transition' => 'all 0s linear',
			];
			$css[$type.':before'] = [
				'position' => 'absolute',
				'content' => '',
				'top' => 0,
				'left' => 0,
				'background' => 'rgba(255, 255, 255, 0.8)',
				'width' => '100%',
				'height' => '100%',
				'z-index' => 100,
			];
			$css[$type.':after'] = [
				'position' => 'absolute',
				'content' => '',
				'top' => '50%',
				'left' => '50%',
				'background' => 'rgba(255, 255, 255, 0.8)',
				'margin' => '-1.5em 0 0 -1.5em',
				'width' => '2em',
				'height' => '2em',
				'-webkit-animation' => 'loader 0.6s infinite linear',
				'animation' => 'loader 0.6s infinite linear',
				'border' => '0.2em solid #767676',
				'border-right-color' => 'transparent',
				'border-radius' => '500rem',
				'-webkit-box-shadow' => '0 0 0 1px transparent',
				'box-shadow' => '0 0 0 1px transparent',
				'visibility' => 'visible',
				'z-index' => 101,
			];

		}else if($type == 'bg'){
			//color
			if($params[0] == 'transparent'){
				$css[$name]["background-color"] = "transparent";
			}else if($params[0] == 'current'){
				$css[$name]["background-color"] = "currentColor";
			}else{
				list($r, $g, $b) = sscanf($this->colors[$params[0]], "%02x%02x%02x");
				$css[$name]["--bg-opacity"] = "1";
				// $css[$name]["background-color"][] = "#".$this->colors[$params[0]];
				$css[$name]["background-color"][] = "rgba(".$r.", ".$g.", ".$b.", var(--bg-opacity))";
			}
		}else if($type == 'rounded'){
			//radius,axis
			if(empty($params)){
				$css[$name]["border-radius"] = "0.25rem";
			}else{
				if($params[0] == 'full'){
					$css[$name]["border-radius"] = "9999px";
				}else if($params[0] == 'none'){
					$css[$name]["border-radius"] = "0";
				}else{
					if(is_numeric($params[0])){
						$css[$name]["border-radius"] = (((int)$params[0] > 100) ? (int)$params[0]/100 : (int)$params[0] * 0.25)."rem";
					}else{
						$map = [
							'tl' => ['top-left'],
							'tr' => ['top-right'],
							'br' => ['bottom-right'],
							'bl' => ['bottom-left'],
							't' => ['top-left', 'top-right'],
							'r' => ['top-right', 'bottom-right'],
							'b' => ['bottom-left', 'bottom-right'],
							'l' => ['top-left', 'bottom-left'],
						];
						$poss = $map[$params[0]];
						if(!isset($params[1])){
							$params[1] = 1;
						}
						foreach($poss as $pos){
							$css[$name]["border-".$pos."-radius"] = (((int)$params[1] > 100) ? (int)$params[1]/100 : (int)$params[1] * 0.25)."rem";
						}
					}
				}
			}
		}else if($type == 'border'){
			if(empty($params)){
				$css[$name]["border-width"] = "1px";
			}else{
				if(!isset($params[1])){
					if(in_array($params[0], ['solid', 'dashed', 'dotted', 'double', 'none'])){
						//style
						$css[$name]["border-style"] = $params[0];
					}else if($params[0] == 'opacity'){
						//width,axis
						$css[$name]["--border-opacity"] = (int)$params[1]/100;
					}else if(is_numeric($params[0])){
						//width,axis
						$css[$name]["border-width"] = $params[0]."px";
					}else{
						//color
						if($params[0] == 'transparent'){
							$css[$name]["border-color"] = "transparent";
						}else if($params[0] == 'current'){
							$css[$name]["border-color"] = "currentColor";
						}else{
							list($r, $g, $b) = sscanf($this->colors[$params[0]], "%02x%02x%02x");
							$css[$name]["--border-opacity"] = "1";
							// $css[$name]["border-".$params[0]."-color"] = "#".$this->colors[$params[1]];
							$css[$name]["border-color"] = "rgba(".$r.", ".$g.", ".$b.", var(--border-opacity))";
						}
					}
				}else{
					if(in_array($params[1], ['solid', 'dashed', 'dotted', 'double', 'none'])){
						//style
						$css[$name]["border-".$params[0]."-style"] = $params[1];
					}else if(is_numeric($params[1])){
						//width,axis
						$map = [
							't' => ['top'],
							'r' => ['right'],
							'b' => ['bottom'],
							'l' => ['left'],
							'x' => ['right', 'left'],
							'y' => ['top', 'bottom'],
						];
						$poss = ($map[$params[0]] ?? [$params[0]]);
						foreach($poss as $pos){
							$css[$name]["border-".$pos."-width"] = (is_numeric($params[1]) ? $params[1]."px" : $params[1]);
						}
					}else{
						//color
						if($params[1] == 'transparent'){
							$css[$name]["border-".$params[0]."-color"] = "transparent";
						}else if($params[1] == 'current'){
							$css[$name]["border-".$params[0]."-color"] = "currentColor";
						}else{
							list($r, $g, $b) = sscanf($this->colors[$params[1]], "%02x%02x%02x");
							$css[$name]["--border-opacity"] = "1";
							// $css[$name]["border-".$params[0]."-color"] = "#".$this->colors[$params[1]];
							$css[$name]["border-".$params[0]."-color"] = "rgba(".$r.", ".$g.", ".$b.", var(--border-opacity))";
						}
					}
				}
			}
		}else if(in_array($type, ['block', 'inline', 'table', 'flow', 'hidden'])){
			//display
			if($type == 'hidden'){
				$css[$name]["display"] = 'none';
			}else{
				$css[$name]["display"] = $type.(!empty($params) ? '-'.implode('-', $params) : '');
			}
		}else if($type == 'flex'){
			if(empty($params)){
				$css[$name]["display"] = 'flex';
			}else if(in_array($params[0], ['row', 'column'])){
				$css[$name]["flex-direction"] = implode('-', $params);
			}else if(strpos($params[0], 'wrap') !== false){
				$css[$name]["flex-wrap"] = implode('-', $params);
			}else if($params[0] == 'items'){
				unset($params[0]);
				$css[$name]["align-items"] = str_replace(['start', 'end'], ['flex-start', 'flex-end'], implode('-', $params));
			}else if($params[0] == 'content'){
				unset($params[0]);
				$css[$name]["align-content"] = str_replace(['start', 'end', 'between', 'around'], ['flex-start', 'flex-end', 'space-between', 'space-around'], implode('-', $params));
			}else if($params[0] == 'justify'){
				unset($params[0]);
				$css[$name]["justify-content"] = str_replace(['start', 'end', 'between', 'around', 'evenly'], ['flex-start', 'flex-end', 'space-between', 'space-around', 'space-evenly'], implode('-', $params));
			}else if($params[0] == 'self'){
				unset($params[0]);
				$css[$name]["align-self"] = str_replace(['start', 'end'], ['flex-start', 'flex-end'], implode('-', $params));
			}else if($params[0] == 'grow'){
				unset($params[0]);
				$css[$name]["flex-grow"] = $params[0] ?? 1;
			}else if($params[0] == 'shrink'){
				unset($params[0]);
				$css[$name]["flex-shrink"] = $params[0] ?? 1;
			}else if($params[0] == 'order'){
				unset($params[0]);
				$css[$name]["order"] = str_replace(['first', 'last'], ['-9999', '9999'], $params[0]);
			}
		}else if($type == 'items'){
			if(empty($params)){
				$css[$name]["display"] = 'flex';
			}else if(in_array($params[0], ['row', 'column'])){
				$css[$name]["flex-direction"] = implode('-', $params);
			}else if(strpos($params[0], 'wrap') !== false){
				$css[$name]["flex-wrap"] = implode('-', $params);
			}
		}else if($type == 'grid'){
			if(empty($params)){
				$css[$name]["display"] = 'grid';
			}else if(in_array($params[0], ['rows', 'columns'])){
				$css[$name]["grid-template-".$params[0]] = (is_numeric($params[1])) ? "repeat(".$params[1]." minmax(0, 1fr))" : "none";
			}else if($params[0] == 'flow'){
				unset($params[0]);
				$css[$name]["grid-auto-flow"] = implode("-", $params);
			}else if($params[0] == 'gap'){
				if(is_numeric($params[1])){
					$css[$name]["gap"] = ((int)$params[1] * 0.25)."rem";
				}else if($params[1] == 'x'){
					$css[$name]["column-gap"] = ((int)$params[1] * 0.25)."rem";
				}else if($params[1] == 'y'){
					$css[$name]["row-gap"] = ((int)$params[1] * 0.25)."rem";
				}
			}
		}else if(in_array($type, ['row', 'column'])){
			if($params[0] == 'auto'){
				$css[$name]["grid-".$type] = 'auto';
			}else if($params[0] == 'span'){
				$css[$name]["grid-".$type] = 'span '.$params[1].' / span '.$params[1];
			}else if($params[0] == 'start'){
				$css[$name]["grid-".$type."-start"] = $params[1];
			}else if($params[0] == 'end'){
				$css[$name]["grid-".$type."-end"] = $params[1];
			}
		}else if($type == 'float'){
			//float
			$css[$name]["float"] = $params[0];
		}else if($type == 'h'){
			//height
			if(is_numeric($params[0])){
				$height = $params[0]."%";
			}else{
				$height = implode('-', $params);
			}

			$css[$name]["height"] = $height;
		}else if($type == 'w'){
			//width
			if(is_numeric($params[0])){
				if(!isset($params[1])){
					$width = $params[0]."%";
				}else{
					$width = ((int)$params[0]/(int)$params[1])."%";
				}
			}else{
				$width = implode('-', $params);
			}

			$css[$name]["width"] = $width;
		}else if($type == 'maxh'){
			$css[$name]["max-height"] = (is_numeric($params[0]) ? $params[0]."%" : $params[0]);
		}else if($type == 'maxw'){
			$css[$name]["max-width"] = (is_numeric($params[0]) ? $params[0]."%" : $params[0]);
		}else if($type == 'minh'){
			$css[$name]["min-height"] = (is_numeric($params[0]) ? $params[0]."%" : $params[0]);
		}else if($type == 'minw'){
			$css[$name]["min-width"] = (is_numeric($params[0]) ? $params[0]."%" : $params[0]);
		}else if($type == 'objfit'){
			$css[$name]["object-fit"] = implode('-', $params);
		}else if($type == 'objpos'){
			$css[$name]["object-position"] = implode(' ', $params);
		}else if($type == 'opacity'){
			$css[$name]["opacity"] = ((int)$params[0] * 0.01);
		}else if($type == 'overflow'){
			//value, axis
			$css[$name]["overflow".(isset($params[1]) ? "-".$params[1] : "")] = $params[0];
		}else if(in_array($type, ['m', 'mx', 'my', 'mt', 'mr', 'mb', 'ml'])){
			if(strlen($type) > 1){
				array_unshift($params, str_replace('m', '', $type));
			}
			//value, sides
			if(!isset($params[1])){
				if(strpos($params[0], 'n') === 0){
					$params[0] = - ((int)str_replace('n', '', $params[0]));
				}
				if(is_numeric($params[0])){
					$margin = (((int)$params[0] > 100) ? (int)$params[0]/100 : (int)$params[0] * 0.25)."rem";
				}else{
					$margin = $params[0];
				}

				$css[$name]["margin"] = $margin;
			}else{
				if(strpos($params[1], 'n') === 0){
					$params[1] = '-'.str_replace('n', '', $params[1]);
				}
				if(is_numeric($params[1])){
					$margin = (((int)$params[1] > 100) ? (int)$params[1]/100 : (int)$params[1] * 0.25)."rem";
				}else{
					$margin = $params[1];
				}

				$map = [
					't' => ['top'],
					'r' => ['right'],
					'b' => ['bottom'],
					'l' => ['left'],
					'x' => ['left', 'right'],
					'y' => ['top', 'bottom'],
				];
				$poss = $map[$params[0]];
				foreach($poss as $pos){
					$css[$name]["margin-".$pos] = $margin;
				}
			}
		}else if(in_array($type, ['p', 'px', 'py', 'pt', 'pr', 'pb', 'pl'])){
			if(strlen($type) > 1){
				array_unshift($params, str_replace('p', '', $type));
			}
			//value, sides
			if(!isset($params[1])){
				if(strpos($params[0], 'n') === 0){
					$params[0] = - ((int)str_replace('n', '', $params[0]));
				}
				if(is_numeric($params[0])){
					$padding = (((int)$params[0] > 100) ? (int)$params[0]/100 : (int)$params[0] * 0.25)."rem";
				}else{
					$padding = $params[0];
				}

				$css[$name]["padding"] = $padding;
			}else{
				if(strpos($params[1], 'n') === 0){
					$params[1] = - ((int)str_replace('n', '', $params[1]));
				}
				if(is_numeric($params[1])){
					$padding = (((int)$params[1] > 100) ? (int)$params[1]/100 : (int)$params[1] * 0.25)."rem";
				}else{
					$padding = $params[1];
				}

				$map = [
					't' => ['top'],
					'r' => ['right'],
					'b' => ['bottom'],
					'l' => ['left'],
					'x' => ['left', 'right'],
					'y' => ['top', 'bottom'],
				];
				$poss = $map[$params[0]];
				foreach($poss as $pos){
					$css[$name]["padding-".$pos] = $padding;
				}
			}
		}else if(in_array($type, ['static', 'relative', 'absolute', 'fixed', 'sticky'])){
			if($type == 'sticky'){
				$css[$name]["position"][] = "-webkit-sticky";
			}
			$css[$name]["position"][] = $type;
		}else if(in_array($type, ['top', 'bottom', 'right', 'left'])){
			$css[$name][$type] = $params[0] ?? 0;
		}else if($type == 'z'){
			$css[$name]["z-index"] = $params[0];
		}else if($type == 'cursor'){
			$css[$name]["cursor"] = $params[0];
		}else if($type == 'shadow'){
			$params[0] = $params[0] ?? '';
			if(!empty($params[1])){
				list($r, $g, $b) = sscanf($this->colors[$params[1]], "%02x%02x%02x");
			}
			$map = [
				'xs' => '0 0 0 1px rgba(0, 0, 0, 0.05)',
				'sm' => '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
				'md' => '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
				'lg' => '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
				'xl' => '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
				'2xl' => '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
				'inner' => 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
				'outline' => '0 0 0 3px '.(!empty($params[1]) ? "rgba(".$r.", ".$g.", ".$b.", 0.5)" : 'rgba(66, 153, 225, 0.5)'),
				'none' => 'none',
				'' => "0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)",
			];
			$css[$name]["box-shadow"] = $map[$params[0]] ?? '';
		}else if($type == 'table'){
			if(in_array($params[0], ['auto', 'fixed'])){
				$css[$name]["table-layout"] = $params[0];
			}else if($params[0] == 'border'){
				$css[$name]["border-collapse"] = $params[1];
			}
		}else if(in_array($type, ['text'])){
			if(in_array($params[0], ['left', 'center', 'right', 'justify'])){
				$css[$name]["text-align"] = $params[0];
			}else if(in_array($params[0], ['uppercase', 'lowercase', 'normalcase', 'capitalize'])){
				$css[$name]["text-transform"] = $params[0];
			}else if(in_array($params[0], ['underline', 'line'])){
				if(implode('-', $params) == 'underline-none'){
					$css[$name]["text-decoration"] = 'none';
				}else{
					$css[$name]["text-decoration"] = implode('-', $params);
				}
			}else if(in_array($params[0], ['2xs', 'xs', 'sm', 'md', 'ml', 'lg', 'xl', '2xl', '3xl'])){
				//size
				$map = [
					'2xs' => 0.4,
					'xs' => 0.5,
					'sm' => 0.75,
					'md' => 1,
					'ml' => 1.25,
					'lg' => 1.5,
					'xl' => 2,
					'2xl' => 4,
					'3xl' => 8,
				];

				$css[$name]["font-size"] = $map[$params[0]]."rem";
			}else{
				if($params[0] == 'transparent'){
					$css[$name]["color"] = "transparent";
				}else if($params[0] == 'current'){
					$css[$name]["color"] = "currentColor";
				}else{
					list($r, $g, $b) = sscanf($this->colors[$params[0]], "%02x%02x%02x");
					$css[$name]["--text-opacity"] = "1";
					$css[$name]["color"][] = "#".$this->colors[$params[0]];
					$css[$name]["color"][] = "rgba(".$r.", ".$g.", ".$b.", var(--text-opacity))";
				}
			}
		}else if($type == 'topacity'){
			$css[$name]["--text-opacity"] = ((int)$params[0] * 0.01);
		}else if($type == 'valign'){
			$css[$name]["vertical-align"] = $params[0];
		}else if($type == 'visibility'){
			$css[$name]["visibility"] = str_replace([1, 0], ['visible', 'hidden'], $params[0]);
		}else if($type == 'whitespace'){
			$css[$name]["white-space"] = implode('-', $params);
		}else if($type == 'font'){
			if(in_array($params[0], ['sans', 'serif', 'mono'])){
				$map = [
					'sans' => 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
					'serif' => 'Georgia, Cambria, "Times New Roman", Times, serif',
					'mono' => 'Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
				];
				$css[$name]["font-family"] = $map[$params[0]];
			}else if($params[0] == 'style'){
				$css[$name]["font-style"] = $params[1];
			}else{
				//weight
				$css[$name]["font-weight"] = $params[0];
			}
		}else if(in_array($type, ['fill', 'stroke'])){
			if($type == 'fill'){
				if($params[0] == 'transparent'){
					$css[$name]["fill"] = "transparent";
				}else if($params[0] == 'current'){
					$css[$name]["fill"] = "currentColor";
				}else{
					list($r, $g, $b) = sscanf($this->colors[$params[0]], "%02x%02x%02x");
					$css[$name]["fill"][] = "#".$this->colors[$params[0]];
					$css[$name]["fill"][] = "rgba(".$r.", ".$g.", ".$b.", 1)";
				}
			}else if($type == 'stroke'){
				if(empty($params)){
					$css[$name]["stroke"] = "currentColor";
				}else{
					$css[$name]["stroke-width"] = $params[0];
				}
			}
		}else if(in_array($type, ['break', 'truncate'])){
			if($type == 'truncate'){
				$css[$name]["overflow"] = 'hidden';
				$css[$name]["text-overflow"] = 'ellipsis';
				$css[$name]["white-space"] = 'nowrap';
			}else{
				$map = [
					'normal' => ['overflow-wrap' => 'normal', 'word-break' => 'normal'],
					'words' => ['overflow-wrap' => 'break-word'],
					'all' => ['word-break' => 'break-all'],
				];
			}

			foreach($map[$params[0]] as $p => $v){
				$css[$name][$p] = $v;
			}
		}else if($type == 'space'){
			//axis,value
			$dir1 = ($params[0] == 'y') ? 'top' : 'left';
			$dir2 = ($params[0] == 'y') ? 'bottom' : 'right';
			$unit = $params[2] ?? 'rem';

			if(strpos($params[1], 'n') === 0){
				$params[1] = - ((int)str_replace('n', '', $params[1]));
			}

			$name = $name." > :not(template) ~ :not(template)";
			$css[$name]["--space-".$params[0]."-reverse"] = 0;
			$css[$name]["margin-".$dir1] = "calc(".(0.25 * $params[1]).$unit." * calc(1 - var(--space-".$params[0]."-reverse)))";
			$css[$name]["margin-".$dir2] = "calc(".(0.25 * $params[1]).$unit." * var(--space-".$params[0]."-reverse))";
		}else if($type == 'divide'){
			//axis, value
			$dir1 = ($params[0] == 'y') ? 'top' : 'left';
			$dir2 = ($params[0] == 'y') ? 'bottom' : 'right';

			if(strpos($params[1], 'n') === 0){
				$params[1] = - ((int)str_replace('n', '', $params[1]));
			}

			$name = $name." > :not(template) ~ :not(template)";
			$css[$name]["--divide-".$params[0]."-reverse"] = 0;
			$css[$name]["border-".$dir1."-width"] = "calc(".$params[1]."px * calc(1 - var(--divide-".$params[0]."-reverse)))";
			$css[$name]["border-".$dir2."-width"] = "calc(".$params[1]."px * var(--divide-".$params[0]."-reverse))";
		}
		// pr($css);
		return [$media => $css];
	}
}
