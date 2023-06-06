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
class AppLoader {
	public static function app(){
		$app = '';
		if(defined('JPATH_SITE')){
			$app = 'joomla';

			jimport('joomla.version');
			$version = new \Joomla\CMS\Version();

			\G3\Globals::set('app_version', explode('.', $version->getShortVersion())[0]);

		}else if(defined('DB_HOST')){
			$app = 'wordpress';
		}
		
		return $app;
	}
	
	public static function initialize($plugin = null){
		$app = self::app();
		
		\G3\Globals::set('app', $app);
		\G3\Globals::set('inline', true);
		
		\G3\Globals::ready();
		
		//\G3\Bootstrap::initialize($app);
		$boot = \G3\Globals::getClass('boot');
		new $boot($app, $plugin);
	}
	
	function __construct($settings){
		foreach($settings as $key => $value){
			$$key = $value;
		}

		$app = self::app();
		
		self::initialize($alias);
		
		$tvout = !empty(\G3\L\Request::data('tvout')) ? \G3\L\Request::data('tvout') : '';
		$controller = $controller ?? $vars['controller'] ?? \G3\L\Request::data('cont', '');
		$action = $action ?? $vars['action'] ?? \G3\L\Request::data('act', '');
		
		// if(!empty($setup) AND is_callable($setup)){
		// 	$return_vars = $setup();
		// 	if(!empty($return_vars)){
		// 		$vars = array_merge($vars, $return_vars);
		// 	}
		// }
		
		if($app == 'joomla' AND $site == 'admin' AND empty($tvout) AND \G3\Globals::get('app_version') != '4'){
			\GApp3::document()->addCssFile(\G3\Globals::get('FRONT_URL').'assets/joomla/fixes.css');
		}
		
		$app = \GApp3::call($site, $extension, $controller, $action, $vars ?? []);
		$output = $app->getBuffer();
		
		if(!empty($tvout)){
			if($tvout == 'inline'){
				$doc = \GApp3::document();
				echo $doc->buildMediaOutput();
			}

			echo $output;
			
			$app->_exit();
		}else{
			// echo \G3\H\Message::render(\GApp3::session()->flash());
			
			echo $output;
		}
	}
}