<?php
namespace G3\L\T;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
trait LoadFile{
	function load_file($__file__, $__vars__ = []){
		if(empty($__vars__)){
			foreach($this->_vars as $___k => $___val){
				$$___k = $___val;
			}
		}
		
		foreach($__vars__ as $___k => $___val){
			$$___k = $___val;
		}
		
		$contents = '';
		
		if(file_exists($__file__)){
			ob_start();
			include($__file__);
			$contents = ob_get_clean();
		}
		
		return $contents;
	}
}
?>