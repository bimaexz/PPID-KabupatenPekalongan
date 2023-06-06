<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\L\Joomla;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class App extends \G3\L\App{
	
	public function breadcrumb($text, $link = '', $string = '%s', $icon = ''){
		parent::breadcrumb($text, $link, $string, $icon);
		
		$pathway = \JFactory::getApplication()->getPathway();
		$pathway->addItem($text, $link);
	}
	
	public static function _exit(){
		$mainframe = \JFactory::getApplication();
		$mainframe->close();
	}
	
	public static function redirect($url){
		\JFactory::getApplication()->redirect($url);
	}
	
	public static function message($type, $content){
		\JFactory::getApplication()->enqueueMessage($content, $type);
	}
	/*
	public static function user(){
		return \G3\L\Users\UserJoomla::getInstance();
	}
	*/
	public static function url($type, $params = []){
		if($type == 'login'){
			$url = 'index.php?option=com_users&view=login';
			if(!empty($params['return'])){
				if($params['return'] === true){
					$url .= '&return='.urlencode(base64_encode(\G3\L\Url::current()));
				}else{
					$url .= '&return='.urlencode(base64_encode($params['return']));
				}
			}
		}
		
		if($type == 'activation'){
			$url = 'index.php?option=com_users&task=registration.activate';
			if(!empty($params['token'])){
				$url .= '&token='.$params['token'];
			}
		}
		
		return r3($url, false, true);
	}

	function raiseError(){
		$this->controller = 'errors';
		$this->action = 'e404';
		\G3\L\Env::e404();
		\JError::raiseError(404, $this->buffer);
	}
	
	// function dispatch($content_only = false, $check_perm = true){
	// 	//Event::trigger('on_before_dispatch', $this);
	// 	$session = self::session();
	// 	//reset:
	// 	//if no action set, set it to index
	// 	if(strlen(trim($this->action)) == 0){
	// 		$this->action = 'index';
	// 	}
	// 	//set admin path
	// 	$site = '';
	// 	if($this->site == 'admin'){
	// 		$site = '\A';
	// 	}
	// 	//load the extension class
	// 	$controller = !empty($this->controller) ? '\C\\'.\G3\L\Str::camilize($this->controller) : '\\'.\G3\L\Str::camilize($this->extension);
	// 	$extension = !empty($this->extension) ? '\E\\'.\G3\L\Str::camilize($this->extension) : '';
	// 	$classname = '\G3'.$site.$extension.$controller;
	// 	$this->tvout = !empty(\G3\L\Request::data('tvout')) ? \G3\L\Request::data('tvout') : $this->tvout;
	// 	//set referer
	// 	if(!$content_only){
	// 		if(!($this->controller == 'users' AND ($this->action == 'login' OR $this->action == 'logout' OR $this->action == 'register')) AND (!empty($this->extension) OR !empty($this->controller)) AND empty($this->tvout)){
	// 			//$session->set('_referer', Url::current());
	// 		}else{
	// 			//$session->set('_referer', 'index.php');
	// 		}
	// 	}
		
	// 	$this->set_user();
		
	// 	//if the extension class not found or the action function not found then load an error
	// 	if(!class_exists($classname) OR !in_array($this->action, get_class_methods($classname)) OR substr($this->action, 0, 1) == '_' OR preg_match('/[A-Z]/', $this->action)){
	// 		$this->buffer = 'Page not found...'.$this->action.' @ '.\G3\Loader::$classname.' @ '.\G3\Loader::$filepath;

	// 		$this->raiseError();
	// 		//we need the rendered content only
	// 		if($content_only){
	// 			return;
	// 		}
	// 	}
	// 	//load language file
	// 	if(!empty($this->extension)){
	// 		\G3\L\Lang::load($this->extension);
	// 	}
		
	// 	$template = \JFactory::getApplication()->getTemplate();
	// 	if(strpos($template, 'semantic') === 0 AND \G3\L\Request::data('tmpl') != 'component'){
	// 		\G3\L\Config::set('template.semantic.dynamic', 0);
	// 	}
		
	// 	if(empty($this->tvout) OR $this->tvout == 'inline'){
	// 		$doc = \G3\L\Document::getInstance($this->site);
	// 		$doc->_startup();
	// 	}
		
	// 	//load class and run the action
	// 	$contInstance = new $classname($this->site);
	// 	ob_start();
	// 	//set default layout to have the semanticui-body div container
	// 	$contInstance->layouts[] = \G3\Globals::get('FRONT_PATH').'layouts'.DS.'main.php';
		
	// 	$continue = $this->processAction($contInstance, '_initialize');
		
	// 	if($continue !== false){
	// 		$renderView = $this->processAction($contInstance);
			
	// 		if($renderView == true){
	// 			//initialize and render view
	// 			$contInstance->viewer = new \G3\L\View($contInstance);
	// 			echo $contInstance->viewer->renderView($this->action);
	// 		}
	// 	}

	// 	//get the action output buffer
	// 	$this->buffer = ob_get_clean();
		
	// 	//finalize
	// 	ob_start();
	// 	$this->processAction($contInstance, '_finalize');
	// 	$this->buffer .= ob_get_clean();
		
	// 	$doc = \G3\L\Document::getInstance($this->site);
	// 	$doc->addHeaderTag('
	// 	<script type="text/javascript">
	// 	jQuery(document).ready(function($){$("div.G3-joomla").trigger("contentChange", {"act":"boot"});});
	// 	</script>
	// 	', 'z');
	// 	//$doc->addJsCode('jQuery(document).ready(function($){$("div.G3-joomla").trigger("contentChange", {"act":"boot"});});');
		
	// 	if(empty($this->tvout) OR $this->tvout == 'inline'){
	// 		$doc = \G3\L\Document::getInstance($this->site);
	// 		$doc->_build($this->buffer);
	// 	}
	// 	//Event::trigger('on_after_dispatch');
	// }
	
	public static function set_user(){
		$session = self::session();
		
		$G_User = $session->get('user', array());
		//check permissions
		
		$J_User = \JFactory::getUser();
		if(empty($J_User->groups) OR empty($G_User['groups']) OR (array_values($J_User->groups) !== $G_User['groups']) OR empty($G_User['inheritance'])){
			$user_session = array();
			$user_session['id'] = $J_User->id;
			$user_session['name'] = $J_User->name;
			$user_session['username'] = $J_User->username;
			$user_session['email'] = $J_User->email;
			$user_session['last_login'] = $J_User->lastvisitDate;
			$user_session['logged_in'] = !$J_User->guest;
			$user_session['guest'] = $J_User->guest;
			$user_session['groups'] = empty($J_User->groups) ? array(1) : array_values($J_User->groups);
			$user_session['inheritance'] = array();
			if(!empty($J_User->groups)){
				//sort groups
				$Group = new \G3\A\M\Group();
				$groups = $Group->order(['Group.parent_id' => 'ASC'])->select();
				$valid_groups = array_intersect($user_session['groups'], \G3\L\Arr::getVal($groups, array('[n]', 'Group', 'id')));
				if(!empty($groups) AND $valid_groups){
					reloop:
					foreach($groups as $group){
						//if this group exists in the user's groups or its inheitance then add its parent_id
						if(in_array($group['Group']['id'], $user_session['groups']) OR in_array($group['Group']['id'], $user_session['inheritance'])){
							$user_session['inheritance'][] = $group['Group']['parent_id'];
						}
					}
					//find the number of occurances of each group in the inheritane
					$groups_counted = array_count_values($user_session['inheritance']);
					//if the count of root parent (0 parent_id) is less than the count of user's groups then not all pathes have been found, reloop
					if((count($user_session['groups']) AND !isset($groups_counted[0])) OR $groups_counted[0] < count($user_session['groups'])){
						goto reloop;
					}else{
						$user_session['inheritance'] = array_unique($user_session['inheritance']);
					}
				}
			}
			if($session->get('user', array()) !== $user_session){
				$session->clear('acos_permissions');
			}
			$session->set('user', array_merge($session->get('user', array()), $user_session));
		}
	}
	
}