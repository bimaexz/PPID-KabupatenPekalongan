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
class Controller {
	use \G3\L\T\GetSet;
	use \G3\L\T\View;
	use \G3\L\T\Model;
	use \G3\L\T\Helper;
	use \G3\L\T\LoadFile;
	
	var $name = '';
	var $action = '';
	var $extension = '';
	var $site = '';
	
	var $_libs = [];
	var $_models = [];
	var $_helpers = [];
	
	var $_vars = [];
	var $path = '';
	var $url = '';
	
	var $view = [];
	var $viewer;
	//var $views_dir = '';
	
	var $data = [];
	var $theme = 'default';
	var $layouts = [];
	var $errors = [];
	
	function __construct($site = GCORE_SITE){
		$app = \GApp3::instance($site);
		$this->site = $site;
		$this->_vars = &$app->_vars;
		$this->data = &Request::raw();//&$_POST;
		//$this->data = array_merge($_GET, $this->data);
		$this->path = $app->path;
		$this->url = $app->url;
		$this->name = get_class($this);
		$this->alias = Base::getClassName(get_class($this));
		$this->action = $app->action;
		$this->extension = $app->extension;
		$this->tvout = $app->tvout;
		//set models properties
		if(!empty($this->_models)){
			foreach($this->_models as $k => $model){
				if(is_numeric($k)){
					$alias = Base::getClassName($model);
					$this->$alias = new $model();
				}
			}			
		}
		//set libs properties
		if(!empty($this->_libs)){
			foreach($this->_libs as $k => $lib){
				if(is_numeric($k)){
					$alias = Base::getClassName($lib);
					$this->$alias = new $lib($this);
				}else{
					$alias = $k;
					$this->$alias = new $lib($this);
				}
			}			
		}
	}
	
	function _initialize(){
		
	}
	
	function _finalize(){
		
	}
	
	function getController($controller, $ext = null){
		$extension = '';
		if(is_null($ext)){
			$extension = $this->extension;
		}else{
			$extension = $ext;
		}
		
		$classname = '\G3\E\\'.Str::camilize($extension).'\C\\'.Str::camilize($controller);
		${$classname} = new $classname($this->site);
		//$continue = ${$classname}->_initialize();
		${$classname}->extension = $extension;
		${$classname}->action = '';
		
		return ${$classname};
	}
	
	function layout($layout){
		$this->layouts[] = $layout;
	}
	
	function redirect($url){
		Env::redirect($url);
	}
}