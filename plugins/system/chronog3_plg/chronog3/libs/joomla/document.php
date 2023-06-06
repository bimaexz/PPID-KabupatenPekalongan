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
class Document extends \G3\L\Document {

	function _($name, $params = array()){
		if(\GApp3::instance()->tvout != 'inline'){
			if($name == 'jquery'){
				\JHtml::_('jquery.framework');
				return;
			}
		}
		parent::_($name, $params);
	}
	/*
	function addCssFile($path, $media = 'screen'){
		$document = \JFactory::getDocument();
		$document->addStyleSheet($path);
	}

	function addJsFile($path, $type = 'text/javascript'){
		$document = \JFactory::getDocument();
		$document->addScript($path);
	}
	
	function addCssCode($content, $media = 'screen'){
		$document = \JFactory::getDocument();
		$document->addStyleDeclaration($content);
	}

	function addJsCode($content, $type = 'text/javascript'){
		$document = \JFactory::getDocument();
		$document->addScriptDeclaration($content);
	}
	*/
	function title($title = null){
		$document = \JFactory::getDocument();
		if(is_null($title)){
			return $document->getTitle();
		}else{
			$document->setTitle($title);
		}
	}
	
	function meta($name, $content = null, $http = false){
		$document = \JFactory::getDocument();
		
		if(is_null($content)){
			return $document->getMetaData($name);
		}else{
			$document->setMetaData($name, $content, $http);
		}
	}
	
	public function buildHeader(){
		$JDocument = \JFactory::getDocument();
		//$this->package();
		
		foreach($this->cssfiles as $k => $cssfile){
			$JDocument->addStyleSheet($cssfile['href']);
		}
		
		foreach($this->csscodes as $media => $codes){
			$JDocument->addStyleDeclaration(implode("\n", $codes));
		}
		
		foreach($this->jsfiles as$k => $jsfile){
			$JDocument->addScript($jsfile['src']);//, 'text/javascript', true);
		}
		
		foreach($this->jscodes as $type => $codes){
			$JDocument->addScriptDeclaration(implode("\n", $codes));
		}
		
		ksort($this->headertags, SORT_STRING);
		foreach($this->headertags as $k => $code){
			$JDocument->addCustomTag($code);
		}
	}
}