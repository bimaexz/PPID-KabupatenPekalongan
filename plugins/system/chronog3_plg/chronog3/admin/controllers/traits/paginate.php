<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\C\T;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
trait Paginate {
	
	function Paginate($Model, $alias = null, $limit = null){
		//$this->_helpers[] = '\G3\H\Paginator';
		
		if(empty($alias)){
			$alias = $Model->alias;
		}
		$this->_helpers['Paginator'] = ['name' => '\G3\H\Paginator', 'params' => ['alias' => $alias]];
		
		$ModelParams = $Model->getParams();
		$count = $Model->select('count');
		$Model->setParams($ModelParams);
		
		$init_limit = !empty($limit) ? $limit : 0;
		if(is_numeric($this->data('limit')) AND (int)$this->data('limit') > 0 AND (int)$this->data('limit') <= \GApp3::config()->get('limit.max', 100)){
			$limit = $this->data('limit');
		}else{
			$limit = $init_limit ? $init_limit : \GApp3::session()->get('helpers.paginator.'.$alias.'.limit', \GApp3::config()->get('limit.default', 30));
		}
		\GApp3::session()->set('helpers.paginator.'.$alias.'.limit', $limit);
		
		if(is_numeric($this->data('startat')) AND (int)$this->data('startat') >= 0 AND (int)$this->data('startat') < $count){
			$startat = $this->data('startat');
			\GApp3::session()->set('helpers.paginator.'.$alias.'.startat', $startat);
		}else{
			$startat = \GApp3::session()->get('helpers.paginator.'.$alias.'.startat', 0);
		}
		\GApp3::session()->set('helpers.paginator.'.$alias.'.count', $count);
		
		$Model->limit($limit);
		$Model->offset($startat);
	}
	
}
?>