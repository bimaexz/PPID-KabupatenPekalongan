<?php
namespace G3\L\T;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
trait View{
	public function View(){
		static $views;
		
		$name = get_class($this);
		
		if(empty($views[$name])){
			$views[$name] = new \G3\L\View($this);
		}
		
		return $views[$name];
	}
	
}