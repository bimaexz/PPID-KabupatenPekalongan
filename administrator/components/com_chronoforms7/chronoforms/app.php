<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\E\Chronoforms;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class App extends \G3\A\App {
	
	function _initialize(){
		parent::_initialize();

		$this->set('__valid', \GApp3::extension($this->get('ext'))->valid());
		
		$this->set('cf_settings', \GApp3::extension('chronoforms')->settings()->data);
		$this->set('cf.paths.shared', \G3\Globals::ext_path('chronoforms', 'admin').'__shared'.DS);
		$this->set('cf.paths.functions', \G3\Globals::ext_path('chronoforms', 'admin').'functions'.DS);
		$this->set('cf.paths.views', \G3\Globals::ext_path('chronoforms', 'admin').'views'.DS);
		$this->set('cf.paths.behaviors', \G3\Globals::ext_path('chronoforms', 'admin').'behaviors'.DS);

		// if(empty($this->get('cf_settings.email', []))){
		// 	if($this->data('act') != 'settings' AND $this->data('act') != 'save_settings'){
		// 		\GApp3::session()->flash('error', rl3('Your Global Email settings are not set, please save the ChronoForms7 Global Settings first!'));
				
		// 		$this->redirect(r3('index.php?ext=chronoforms&act=settings'));
		// 	}
		// }
	}
}
?>