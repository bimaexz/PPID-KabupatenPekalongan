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
class Paginator extends \G3\L\Helper{
	var $url;
	var $urlparams;
	
	function __construct(&$view = null, $config = []){
		parent::__construct($view, $config);
		$this->url = !empty($this->url) ? $this->url : \G3\L\Url::current();
		
		if(!empty($this->urlparams)){
			$params = [];
			foreach($this->urlparams as $p){
				$params[$p] = $this->data($p);
			}
			$this->url = \G3\L\Url::build($this->url, $params);
		}
	}
	
	public function info($alias = '', $lang = ''){
		if(empty($alias)){
			$alias = $this->params['alias'];
		}
		
		$limit = \GApp3::session()->get('helpers.paginator.'.$alias.'.limit', \G3\L\Config::get('limit.default', 30));
		$count = \GApp3::session()->get('helpers.paginator.'.$alias.'.count');
		$startat = \GApp3::session()->get('helpers.paginator.'.$alias.'.startat');
		
		if(empty($lang)){
			//$lang = 'Viewing %s records - %s through %s (of %s total)';
			$lang = '%s - %s of %s';
			if(!empty($this->params['info']['lang'])){
				$lang = $this->params['info']['lang'];
			}
		}
		
		$l_visible = ($startat + $limit > $count ? $count - $startat : $limit);
		$l_start = !empty($count) ? (!empty($startat) ? $startat : 1) : 0;
		
		if(substr_count($lang, '%s') == 4){
			$lang = rl3($lang, [$l_visible, $l_start, ($startat + $limit > $count ? $count : $startat + $limit), $count]);
		}else{
			$lang = rl3($lang, [$l_start, ($startat + $limit > $count ? $count : $startat + $limit), $count]);
		}
		//$output = $lang;
		
		$output = '
		<div class="ui tiny menu compact secondary">
			<div class="item header">
				'.$lang.'
			</div>
		</div>
		';
		
		return $output;
	}
	
	public function limiter($alias = ''){
		if(empty($alias)){
			$alias = $this->params['alias'];
		}
		
		$limit = \GApp3::session()->get('helpers.paginator.'.$alias.'.limit');
		$count = \GApp3::session()->get('helpers.paginator.'.$alias.'.count');
		
		$output = '<div class="ui icon top left dropdown pointing">';
		$output .= '<i class="faicon filter"></i>';
		$output .= '<span class="text">'.$limit.'</span>';
		$output .= '<div class="menu">';
		$values = array(5, 10, 15, 20, 30, 50, 100);
		
		$HtmlHelper = new \G3\H\Html();
		
		foreach($values as $value){
			$url = r3(\G3\L\Url::build($this->url, array('limit' => $value, 'startat' => '0')));
			$output .= $HtmlHelper->node(['tag' => 'a', 'active' => true, 'content' => $value, 'attrs' => ['class' => 'item', 'href' => $url]]);
			// $output .= $HtmlHelper->attrs(['href' => $url, 'class' => 'item'])->content($value)->tag('a');
		}
		$output .= '</div>';
		$output .= '</div>';
		
		unset($HtmlHelper);
		
		return $output;
	}
	
	public function navigation($alias = '', $binfo = false){
		if(empty($alias)){
			$alias = $this->params['alias'];
			if(empty($alias)){
				return '';
			}
		}
		
		$HtmlHelper = new \G3\H\Html();
		
		$limit = \GApp3::session()->get('helpers.paginator.'.$alias.'.limit', \G3\L\Config::get('limit.default', 30));
		$count = \GApp3::session()->get('helpers.paginator.'.$alias.'.count', 0);
		$startat = \GApp3::session()->get('helpers.paginator.'.$alias.'.startat', 0);
		
		$first = !empty($startat) ? $startat : 1;
		$last = ($startat + $limit > $count ? $count : $startat + $limit);
		
		$current_page = floor($startat/$limit) + 1;
		$page_count = ceil($count/$limit);
		
		$output = '';
		
		if($binfo){
			$output = '
			<div class="ui tiny menu compact secondary">
				<div class="item header">
					'.$first.'&nbsp;<i class="faicon angle-right"></i>'.$last.'&nbsp;('.$count.')
				</div>
			</div>
			';
		}
		
		$output .= '<div class="ui tiny menu compact secondary">';
		
		//shown
		$current_range = ($count > 0 ) ? (($startat + 1).' - '.($startat + $limit > $count ? $count : $startat + $limit)) : 0;
		//$output .= $HtmlHelper->attrs(array('class' => 'item header'))->content($current_range.' / '.$count)->tag('div');
		
		if($current_page - 2 - 1 > 1){
			//previous
			if(($startat - $limit) >= 0){
				$prev_tag = 'a';
				$prev_tag_class = '';
			}else{
				$prev_tag = 'div';
				$prev_tag_class = ' hidden';
			}
			$url = r3(\G3\L\Url::build($this->url, array('startat' => ($startat - $limit))));
			
			$output .= $HtmlHelper->node(['tag' => $prev_tag, 'active' => true, 'content' => '<i class="faicon angle-left"></i>', 'attrs' => ['class' => 'item icon'.$prev_tag_class, 'href' => $url]]);
		}
		
		if($current_page - 2 > 1){
			//first
			if($startat > 0){
				$first_tag = 'a';
				$first_tag_class = '';
			}else{
				$first_tag = 'div';
				$first_tag_class = ' hidden';
			}
			$url = r3(\G3\L\Url::build($this->url, array('startat' => 0)));
			
			$output .= $HtmlHelper->node(['tag' => 'a', 'active' => true, 'content' => 1, 'attrs' => ['class' => 'item', 'href' => $url]]);
		}
		
		if($current_page - 2 - 1 > 1){
			//spacer
			$output .= $HtmlHelper->node(['tag' => 'div', 'active' => true, 'content' => '...', 'attrs' => ['class' => 'item fitted']]);
		}
		
		//prev pages
		if($current_page > 1){
			for($i = -2; $i < 0; $i++){
				if($current_page + $i > 0){
					$url = r3(\G3\L\Url::build($this->url, array('startat' => ($startat + $i * $limit))));
					
					$output .= $HtmlHelper->node(['tag' => 'a', 'active' => true, 'content' => $current_page + $i, 'attrs' => ['class' => 'item', 'href' => $url]]);
				}
			}
		}
		
		//current
		if($count > 0 AND $startat < $count AND $startat >= 0){
			$output .= $HtmlHelper->node(['tag' => 'div', 'active' => true, 'content' => $current_page, 'attrs' => ['class' => 'item active']]);
		}
		
		//next pages
		if($current_page < $page_count){
			for($i = 1; $i < 3; $i++){
				if($current_page + $i <= $page_count){
					$url = r3(\G3\L\Url::build($this->url, array('startat' => ($startat + $i * $limit))));
					$output .= $HtmlHelper->node(['tag' => 'a', 'active' => true, 'content' => $current_page + $i, 'attrs' => ['class' => 'item', 'href' => $url]]);
				}
			}
		}
		
		if($current_page + 2 < $page_count){
			if($current_page + 2 + 1 < $page_count){
				//spacer
				$output .= $HtmlHelper->node(['tag' => 'div', 'active' => true, 'content' => '...', 'attrs' => ['class' => 'item fitted']]);
			}
			
			//last
			if(($startat + $limit) < $count){
				$last_tag = 'a';
				$last_tag_class = '';
			}else{
				$last_tag = 'div';
				$last_tag_class = ' hidden';
			}
			$url = r3(\G3\L\Url::build($this->url, array('startat' => (ceil($count/$limit) * $limit) - $limit)));
			
			$output .= $HtmlHelper->node(['tag' => 'a', 'active' => true, 'content' => ceil($count/$limit), 'attrs' => ['class' => 'item', 'href' => $url]]);
			
			if($current_page + 2 + 1 < $page_count){
				//next
				if(($startat + $limit) < $count){
					$next_tag = 'a';
					$next_tag_class = '';
				}else{
					$next_tag = 'div';
					$next_tag_class = ' hidden';
				}
				$url = r3(\G3\L\Url::build($this->url, array('startat' => ($startat + $limit))));
				
				$output .= $HtmlHelper->node(['tag' => $next_tag, 'active' => true, 'content' => '<i class="faicon angle-right"></i>', 'attrs' => ['class' => 'item icon'.$next_tag_class, 'href' => $url]]);
			}
		}
		//total
		
		$output .= '</div>';
		
		unset($HtmlHelper);
		
		return $output;
	}
}