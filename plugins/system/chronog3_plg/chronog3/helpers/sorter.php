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
class Sorter extends \G3\L\Helper{
	var $url;
	
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
	
	public function link($text, $name){
		$alias = \G3\L\Str::slug($name, '_');
		$orderdir = \GApp3::session()->get('helpers.sorter.'.$alias.'.dir', '');
		$orderdir_new = ($orderdir == '') ? 'asc' : ($orderdir == 'asc' ? 'desc' : 'asc');
		$url = r3(\G3\L\Url::build($this->url, array('orderfld' => $alias, 'orderdir' => $orderdir_new)));
		$cancel_url = r3(\G3\L\Url::build($this->url, array('orderfld' => $alias, 'orderdir' => 'clear')));
		
		$HtmlHelper = new \G3\H\Html();
		// $sort_link = $HtmlHelper->attrs(['href' => $url])->content($text.'&nbsp;<i class="sort alphabet '.$orderdir.'ending icon"></i>')->tag('a');
		$sort_link = $HtmlHelper->node([
			'tag' => 'a', 
			'active' => true, 
			'content' => $text.(!empty($orderdir) ? '&nbsp;<i class="faicon sort-alpha-'.($orderdir == 'asc' ? 'down' : 'up').'"></i>' : ''), 'attrs' => ['href' => $url]
		]);
		
		if(!empty($orderdir)){
			// $cancel_link = $HtmlHelper->attrs(['href' => $cancel_url])->content('<i class="cancel icon small inverted red"></i>')->tag('a');
			$cancel_link = $HtmlHelper->node(['tag' => 'a', 'active' => true, 'content' => '<i class="faicon times small inverted red"></i>', 'attrs' => ['href' => $cancel_url]]);
		}else{
			$cancel_link = '';
		}
		
		unset($HtmlHelper);
		
		return $sort_link.$cancel_link;
	}
}