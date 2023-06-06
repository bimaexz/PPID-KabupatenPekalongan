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
class Semantic{
	var $found = [];

	var $modules = [
		'button',
		'container',
		'divider',
		'flag',
		'header',
		'icon',
		'image',
		'input',
		'label',
		'list',
		'loader',
		'rail',
		'reveal',
		'segment',
		'step',
		// 'text',
		'breadcrumb',
		'form',
		'grid',
		'menu',
		'message',
		'table',
		// 'ad',
		'card',
		'comment',
		'feed',
		// 'item',
		'statistic',
		'accordion',
		'calendar',
		'checkbox',
		'dimmer',
		'dropdown',
		'video',
		'modal',
		'nag',
		'popup',
		'progress',
		'rating',
		'search',
		'shape',
		'sidebar',
		'sticky',
		'tab',
		'toast',
		'transition',
	];

	public function getClasses($html){
		foreach($this->modules as $module){
			if($module == 'icon'){
				$match_found = preg_match_all('/ class=("|\')icon (.*?)(\1)>/i', $html);
			}else if($module == 'flag'){
				$match_found = preg_match_all('/ data-flag/i', $html);
			}else if($module == 'dropdown'){
				$match_found = (preg_match_all('/<select ([^>]*?)>/', $html) OR preg_match('/ class=("|\')([^"]*?)ui ([^"]*?)('.$module.')([^"]*?)(\1)/i', $html));
			}else{
				$match_found = preg_match('/ class=("|\')([^"]*?)ui ([^"]*?)('.$module.')([^"]*?)(\1)/i', $html);
			}
			if($match_found){
				$this->found[] = $module;
			}
		}
		if(in_array('calendar', $this->found)){
			$this->found = array_unique(array_merge($this->found, ['popup', 'table']));
		}
		if(in_array('modal', $this->found)){
			$this->found = array_unique(array_merge($this->found, ['dimmer']));
		}
		if(!in_array('toast', $this->found) AND strpos($html, 'toolbar-button') !== false){
			$this->found[] = 'toast';
		}
		// if(in_array('toast', $this->found)){
		// 	$this->found = array_unique(array_merge($this->found, ['visibility', 'popup', 'nag', 'modal']));
		// }
		// pr($this->found);
		return $this->found;
	}

	public function getCss($html){
		$this->getClasses($html);

		$assets_path = \G3\Globals::get('FRONT_PATH').'assets'.DS.'semantic-ui'.DS;

		// $css_content = '';
		$css_content[] = file_get_contents($assets_path.DS.'reset.inline.min.css');
		// $css_content[] = file_get_contents($assets_path.DS.'site.inline.min.css');
		$css_content[] = file_get_contents($assets_path.DS.'css'.DS.'transition.min.css');
		$css_content[] = file_get_contents($assets_path.DS.'css'.DS.'loader.min.css');
		$css_content[] = file_get_contents($assets_path.DS.'css'.DS.'text.min.css');
		
		foreach($this->found as $module){
			if(file_exists($assets_path.DS.'css'.DS.$module.'.min.css')){
				$content = file_get_contents($assets_path.DS.'css'.DS.$module.'.min.css');
				if($module == 'icon' OR $module == 'flag'){
					$content = str_replace('url(../themes/default/assets', 'url('.\G3\Globals::get('ROOT_URL').'plugins/system/chrono_semantic_css/themes/default/assets', $content);
				}
				$css_content[] = $content;
			}
		}

		$css_content[] = file_get_contents($assets_path.DS.'fixes.semantic.css');
		// $css_content .= file_get_contents($assets_path.DS.'fixes.css');

		foreach($css_content as $ck => &$css){
			preg_match_all('/([0-9]*\.?[0-9]+)(rem)/', $css, $rems);
			foreach($rems[0] as $k => $rem){
				$css = preg_replace('/'.preg_quote($rem).'/', ((float)$rems[1][$k] * 14).'px', $css, 1);
			}
		}

		return $css_content;
	}

	public function getJs($html){
		if(empty($this->found)){
			$this->getClasses($html);
		}

		$assets_path = \G3\Globals::get('FRONT_PATH').'assets'.DS.'semantic-ui'.DS;

		$js_content[] = file_get_contents($assets_path.DS.'js'.DS.'transition.min.js');
		$js_content[] = file_get_contents($assets_path.DS.'js'.DS.'form.min.js');
		$js_content[] = file_get_contents($assets_path.DS.'js'.DS.'api.min.js');
		
		foreach($this->found as $module){
			if($module != 'form'){
				if(file_exists($assets_path.DS.'js'.DS.$module.'.min.js')){
					$content = file_get_contents($assets_path.DS.'js'.DS.$module.'.min.js');
					$js_content[] = '/*'.$module.'*/'.$content;
				}
			}
		}

		return $js_content;
	}

}
