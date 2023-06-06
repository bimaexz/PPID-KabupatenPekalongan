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
class FontAwesome{

	public function updateHtml($html){
		$svgs = [];

		$assets_path = \G3\Globals::get('FRONT_PATH').'assets'.DS.'fontawesome'.DS;

		preg_match_all('/<i ([^>]*?)class=("|\')faicon ([^"]*?)(\2)([^>]*?)><\/i>/i', $html, $matches);
		// pr($matches);
		if(!empty($matches[3])){
			// $matches[3] = array_unique($matches[3]);
			$matches[0] = array_unique($matches[0]);
			foreach($matches[3] as $mk => $match){
				if(!isset($matches[0][$mk])){
					unset($matches[3][$mk]);
				}
			}
			foreach($matches[3] as $k => $match){
				$icon_name = explode(' ', $match)[0];
				$type_name = 'solid';
				if(strpos($icon_name, ':') !== false){
					$type_name = explode(':', $icon_name)[0];
					$icon_name = explode(':', $icon_name)[1];
				}
				if(file_exists($assets_path.$type_name.DS.$icon_name.'.svg')){
					$svgs[$icon_name] = file_get_contents($assets_path.$type_name.DS.$icon_name.'.svg');
					$svg = str_replace('<svg', '<svg '.$matches[1][$k].$matches[5][$k].' class="fasvg icon '.$match.'"', $svgs[$icon_name]);
					preg_match('/viewBox="([^"]*?)"/i', $svg, $vb_matches);
					if(!empty($vb_matches[1])){
						$vbd = explode(' ', $vb_matches[1]);
						if(count($vbd) == 4 AND ($vbd[2] != $vbd[3])){
							if((int)$vbd[3] > (int)$vbd[2]){
								$trans = [((int)$vbd[3] - (int)$vbd[2])/2, 0];
								$vbd[2] = $vbd[3];
							}else{
								$trans = [0, ((int)$vbd[2] - (int)$vbd[3])/2];
								$vbd[3] = $vbd[2];
							}
							$svg = str_replace($vb_matches[1], implode(' ', $vbd), $svg);
							$svg = str_replace('<path ', '<path transform="translate('.implode(', ', $trans).')"', $svg);
						}
					}
					$html = str_replace($matches[0][$k], $svg, $html);
				}
			}
		}
		
		$css = '
		svg.fasvg{
			display: inline-block;
			width: 1em;
			height: 1em;
			fill: currentColor;
			vertical-align: middle;
		}
		svg.fasvg:not(.link){
			pointer-events: none;
		}';
		\GApp3::document()->addCssCode($css, '_start');
		
		return $html;
	}

}
