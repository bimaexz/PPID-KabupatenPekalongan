<?php
/**
* @title		banner image zoom effect
* @website		http://www.joomhome.com
* @copyright	Copyright (C) 2015 joomhome.com. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');
jimport( 'joomla.filesystem.folder' );

abstract class modBannerimagezoomeffectHelper {

	static function getList($params) {
		$filter = '\.png$|\.gif$|\.jpg$|\.bmp$';
		$path		= $params->get('path');
		$files 		= JFolder::files(JPATH_BASE.$path,$filter);
		
		$i=0;
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
		$lists = array();
		foreach ($files as $file) {
		$lists[$i] = new stdClass();
			$lists[$i]->title	= JFile::stripExt($file);
			$lists[$i]->image	= JURI::base().str_replace(DS,'/',substr($path,1)).'/'.$file;
			$i++;
		}
		return $lists; 
	}	
}		