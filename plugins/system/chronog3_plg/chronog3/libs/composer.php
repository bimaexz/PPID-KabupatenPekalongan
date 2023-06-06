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
class Composer {
	use \G3\L\T\GetSet;
	use \G3\A\C\T\Paginate;
	use \G3\A\C\T\Order;
	
	var $_vars = [];
	var $data = [];
	
	function __construct(){
		$this->_vars = &$app->_vars;
		$this->data = &Request::raw();//&$_POST;
	}
	/*
	private function addHelper($helper){
		if(!empty($this->Controller) AND !in_array($helper, $this->Controller->helpers)){
			$this->Controller->helpers[] = $helper;
		}
	}
	*/
	public function sorter($fields = array(), $Model = null){
		$return = array();
		
		//check if an order field is set in the url
		foreach($fields as $alias => $name){
			if(\G3\L\Request::data('orderfld') == $alias){
				$direction = \G3\L\Request::data('orderdir', 'asc');
				
				if($direction == 'clear'){
					\GApp3::session()->clear('helpers.sorter.'.$alias);
				}else{
					$return[$name] = $direction;
					\GApp3::session()->set('helpers.sorter.'.$alias, array('fld' => $name, 'dir' => $return[$name]));
				}
			}
		}
		//if no order is set in url then try to find one in session
		//if(empty($return)){
			$saved = \GApp3::session()->get('helpers.sorter', array());
			if(count($saved)){
				foreach($fields as $alias => $name){
					if(isset($saved[$alias])){
						$return[$saved[$alias]['fld']] = $saved[$alias]['dir'];
					}
				}
			}
		//}
		if(is_object($Model)){
			$Model->order($return);
		}
		
		return $return;
	}
	
	public function page($alias = 'default', $count = 0, $limit = null){
		$this->Paginate($count, $alias, $limit);
	}
	
	/*
	public function paginate($alias = 'default', $count = 0, $limit = null){
		\GApp3::instance()->set('helpers.paginator', $alias);
		
		$Model = null;
		if(is_object($count)){
			$Model = $count;
			$ModelParams = $Model->getParams();
			$count = $Model->select('count');
			$Model->setParams($ModelParams);
		}
		
		$this->addHelper('\G3\H\Paginator');
		
		$init_limit = !empty($limit) ? $limit : 0;
		if(is_numeric(\G3\L\Request::data('limit')) AND (int)\G3\L\Request::data('limit') > 0 AND (int)\G3\L\Request::data('limit') <= \GApp3::config()->get('limit.max', 100)){
			$limit = \G3\L\Request::data('limit');
		}else{
			$limit = $init_limit ? $init_limit : \GApp3::session()->get('helpers.paginator.'.$alias.'.limit', \GApp3::config()->get('limit.default', 30));
		}
		\GApp3::session()->set('helpers.paginator.'.$alias.'.limit', $limit);
		
		if(is_numeric(\G3\L\Request::data('startat')) AND (int)\G3\L\Request::data('startat') >= 0 AND (int)\G3\L\Request::data('startat') < $count){
			$startat = \G3\L\Request::data('startat');
			\GApp3::session()->set('helpers.paginator.'.$alias.'.startat', $startat);
		}else{
			$startat = \GApp3::session()->get('helpers.paginator.'.$alias.'.startat', 0);
		}
		\GApp3::session()->set('helpers.paginator.'.$alias.'.count', $count);
		
		if(is_object($Model)){
			$Model->limit($limit);
			$Model->offset($startat);
		}
		
		return [$limit, $startat];
	}
	*/
	/*
	public function pageHeader($text, $link = '', $string = '%s', $icon = ''){
		\GApp3::instance()->set('composer.header.text', htmlspecialchars($text));
		\GApp3::instance()->set('composer.header.link', $link);
		\GApp3::instance()->set('composer.header.string', !empty($string) ? $string : '%s');
		\GApp3::instance()->set('composer.header.icon', $icon);
		
		$this->addHelper('\G3\H\Header');
	}
	*/
}