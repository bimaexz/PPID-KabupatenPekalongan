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
class App {
	use \G3\L\T\GetSet;
	
	var $path = '';
	var $url = '';
	var $site = GCORE_SITE;
	var $_vars = array();
	var $data = array();
	var $buffer = '';
	var $extension = '';
	var $controller = '';
	var $action = '';
	var $template = '';
	var $tvout = '';
	var $language = 'en_GB';
	var $direction = 'ltr';
	var $reset = false;
	var $mirrors = [];
	var $instance = false;
	
	static $_id = false;

	function __construct($site = GCORE_SITE, $new = false){
		$this->data = &Request::raw();
		$this->path = \G3\Globals::get('CURRENT_PATH');
		$this->url = \G3\Globals::get('CURRENT_URL');
		$this->language = Config::get('site.language', 'en_gb');
		$this->site = $site;
		if($new){
			$this->instance = $new;
		}
	}

	public static function instance($site = GCORE_SITE, $new = false){
		static $instances;
		if(!isset($instances)){
			$instances = array();
		}
		
		$id = $site;
		
		if($new){
			$id = $site.$new;
			static::$_id = $new;
		}else if(static::$_id){
			$id = $site.static::$_id;
		}
		
		if(empty($instances[$id])){
			$instances[$id] = new static($site, $new);
			return $instances[$id];
		}else{
			return $instances[$id];
		}
	}
	
	public static function call($site, $extension, $controller = '', $action = '', $params = array(), $new = false){
		$app = static::instance($site, $new);
		$app->extension = $extension;
		$app->controller = $controller;
		$app->action = $action;
		
		foreach($params as $param => $value){
			$app->set($param, $value);
		}
		
		$app->dispatch(true);
		
		if($new){
			static::$_id = false;
		}
		
		return $app;
	}

	public static function redirect($url){
		Env::redirect($url);
	}
	
	public static function session(){
		return Session::getInstance(self::config()->get('session.handler', 'php'), array(
			'lifetime' => self::config()->get('session.lifetime', 15)
		));
	}
	
	public static function cookie(){
		static $cookie;
		if(empty($cookie)){
			$cookie = new Cookie();
		}
		return $cookie;
	}
	
	public static function user(){
		return User::getInstance();
	}
	
	public static function document(){
		return Document::getInstance();
	}
	
	public static function config(){
		return Config::getInstance();
	}
	
	public static function extension($ext = ''){
		if(empty($ext)){
			$ext = \GApp3::instance()->extension;
		}
		return Extension::getInstance($ext);
	}
	
	// public static function access($path, $aco, $owner_id = null, $user_id = null){
	// 	return \G3\L\Authorize::authorized(is_array($path) ? $path : 'ext='.$path, $aco, $owner_id, $user_id);
	// }

	public static function permitted($rules, $owner_id = null, $user_id = null){
		return \G3\L\Authorize::permitted($rules, $owner_id, $user_id);
	}
	
	public static function message($type, $content){
		\GApp3::session()->flash($type, $content);
	}
	
	public static function url($type, $params = []){
		return $type;
	}
	
	public static function _exit(){
		exit();
	}
	
	public function breadcrumb($text, $link = '', $string = '%s', $icon = ''){
		static $breadcrumbs;
		if(!isset($breadcrumbs)){
			$breadcrumbs = [];
		}
		$breadcrumbs[$text] = ['link' => $link, 'string' => !empty($string) ? $string : '%s', 'icon' => $icon];
		
		$this->set('app.breadcrumbs', $breadcrumbs);
		
		//$this->addHelper('\G3\H\Breadcrumbs');
	}

	function getBuffer(){
		return $this->buffer;
	}

	function raiseError(){
		$this->controller = 'errors';
		$this->action = 'e404';
		\G3\L\Env::e404();
	}

	public static function set_user(){

	}
	
	/*** old code ***/
	function initialize(){
		//start the session
		$this->user();
		//Event::trigger('on_initialize');
	}

	function route(){
		$this->extension = 'chronoforums';
		$this->controller = !empty($params['controller']) ? $params['controller'] : '';
		$this->action = !empty($params['action']) ? $params['action'] : '';
	}

	function dispatch($content_only = false, $check_perm = true){
		//Event::trigger('on_before_dispatch', $this);
		$doc = \G3\L\Document::getInstance($this->site);
		$session = self::session();
		//reset:
		//if no action set, set it to index
		if(strlen(trim($this->action)) == 0){
			$this->action = 'index';
		}
		//set admin path
		$site = '';
		if($this->site == 'admin'){
			$site = '\A';
		}
		//load the extension class
		$controller = !empty($this->controller) ? '\C\\'.\G3\L\Str::camilize($this->controller) : '\\'.\G3\L\Str::camilize($this->extension);
		$extension = !empty($this->extension) ? '\E\\'.\G3\L\Str::camilize($this->extension) : '';
		$classname = '\G3'.$site.$extension.$controller;
		$this->tvout = !empty(\G3\L\Request::data('tvout')) ? \G3\L\Request::data('tvout') : $this->tvout;
		//set referer
		if(!$content_only){
			if(!($this->controller == 'users' AND ($this->action == 'login' OR $this->action == 'logout' OR $this->action == 'register')) AND (!empty($this->extension) OR !empty($this->controller)) AND empty($this->tvout)){
				//$session->set('_referer', Url::current());
			}else{
				//$session->set('_referer', 'index.php');
			}
		}
		
		$this->set_user();
		if(!class_exists($classname) AND class_exists('\G3'.$site.$controller)){
			$classname = '\G3'.$site.$controller;
		}
		//if the extension class not found or the action function not found then load an error
		if(!class_exists($classname) OR !in_array($this->action, get_class_methods($classname)) OR substr($this->action, 0, 1) == '_' OR preg_match('/[A-Z]/', $this->action)){
			$this->buffer = 'Page not found...'.$this->action.' @ '.\G3\Loader::$classname.' @ '.\G3\Loader::$filepath;

			$this->raiseError();
			//we need the rendered content only
			if($content_only){
				return;
			}
		}
		//load language file
		if(!empty($this->extension)){
			\G3\L\Lang::load($this->extension);
		}
		
		// if(empty($this->tvout) OR $this->tvout == 'inline'){
		// 	$doc->_startup();
		// }
		
		//load class and run the action
		$contInstance = new $classname($this->site);
		ob_start();
		//set default layout to have the semanticui-body div container
		$contInstance->layouts[] = \G3\Globals::get('FRONT_PATH').'layouts'.DS.'main.php';
		
		$continue = $this->processAction($contInstance, '_initialize');
		
		if($continue !== false){
			$renderView = $this->processAction($contInstance);
			
			if($renderView == true){
				//initialize and render view
				$contInstance->viewer = new \G3\L\View($contInstance);
				echo $contInstance->viewer->renderView($this->action);
			}
		}

		//get the action output buffer
		$this->buffer = ob_get_clean();
		
		//finalize
		ob_start();
		$this->processAction($contInstance, '_finalize');
		$this->buffer .= ob_get_clean();

		if(empty($tvout) OR $tvout == 'inline'){
			$this->buffer = \G3\H\Message::render(\GApp3::session()->flash()).$this->buffer;
		}

		$doc->addMedia();

		// if(empty($this->tvout) OR $this->tvout == 'inline'){
		// 	$doc->addHeaderTag('
		// 	<script type="text/javascript">
		// 	jQuery(document).ready(function($){$(".G3-body").trigger("contentChange", {"act":"boot"});});
		// 	</script>
		// 	', 'z');
		// }
		
		// if(empty($this->tvout) OR $this->tvout == 'inline'){
			// $doc->_addMediaData($this->buffer);
		// }

		// $Semantic = new \G3\H\Semantic();
		// $css = $Semantic->getCss($this->buffer);
		// foreach($css as $csss){
		// 	$doc->addCssCode($csss);
		// }

		// $js = $Semantic->getJs($this->buffer);
		// foreach($js as $jss){
		// 	$doc->addJsCode($jss);
		// }

		// $Quti = new \G3\H\QutiCss();
		// $css = $Quti->getCss($this->buffer);

		// $doc->addCssCode($css);

		// $FA = new \G3\H\FontAwesome();
		// $this->buffer = $FA->updateHtml($this->buffer);
		//Event::trigger('on_after_dispatch');
	}
	
	protected function processAction(&$contInstance, $action = ''){
		if(empty($action)){
			$action = $this->action;
		}
		
		$returned = $contInstance->{$action}();
		
		$renderView = $this->processActionResult($contInstance, $returned);
		
		return $renderView;
	}
	
	protected function processActionResult(&$contInstance, $returned){
		$renderView = true;
		
		if($returned === false){
			//no view will be loaded
			$renderView = false;
		}else{
			if(is_array($returned)){
				if(!empty($this->tvout)){
					echo json_encode($returned, true);
					$renderView = false;
				}else{
					if(!empty($returned['login'])){
						$this->redirect(\GApp3::url('login', ['return' => true]));
					}
					if(!empty($returned['error'])){
						self::session()->flash('error', $returned['error']);
						if(empty($returned['continue'])){
							$renderView = false;
						}
						if(!empty($returned['reload'])){
							if(isset($contInstance->data[$this->action])){
								unset($contInstance->data[$this->action]);
							}
							$renderView = $this->processAction($contInstance);
						}
					}else if(!empty($returned['success'])){
						self::session()->flash('success', $returned['success']);
					}
					if(!empty($returned['redirect'])){
						$this->redirect($returned['redirect']);
					}
				}
			}
		}
		
		return $renderView;
	}

	function render(){
		Event::trigger('on_before_render');
		$template_model = new \G3\A\M\Template();
		$params = null;
		if(empty($this->template)){
			$template_data = $template_model->find('first', array(
				'conditions' => array('Template.site' => $this->site, 'Template.default' => 1),
				'recursive' => -1,
				'cache' => true
			));
		}else{
			$template_data = $template_model->find('first', array(
				'conditions' => array('Template.name' => $this->template),
				'recursive' => -1,
				'cache' => true
			));
		}
		if(!empty($template_data)){
			$this->template = $template_data['Template']['source'];
			$params = new Parameter($template_data['Template']['params']);
		}
		//get template view from the request
		$this->tvout = strlen(Request::data('tvout', null)) > 0 ? Request::data('tvout') : $this->tvout;
		//render the active template
		$doc = Document::getInstance($this->site, $this->thread);
		$template = Template::getInstance($doc, $this->template, $this->tvout, $params);
		$this->buffer = $template->render();
		Event::trigger('on_after_render');
	}

	function output(){
		echo $this->getBuffer();
		
		if(Config::get('error.debug', 0)){
			\G3\Loader::debug();
		}
	}
}