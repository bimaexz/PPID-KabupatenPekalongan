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
class Boot extends \G3\L\Boot{
	
	function __construct(){
		self::initialize();
		
		$mainframe = \JFactory::getApplication();
		//database
		\G3\L\Config::set('db.host', $mainframe->getCfg('host'));
		$dbtype = ($mainframe->getCfg('dbtype') == 'mysqli' ? 'mysql' : $mainframe->getCfg('dbtype'));
		\G3\L\Config::set('db.type', $dbtype);
		\G3\L\Config::set('db.name', $mainframe->getCfg('db'));
		\G3\L\Config::set('db.user', $mainframe->getCfg('user'));
		\G3\L\Config::set('db.pass', $mainframe->getCfg('password'));
		\G3\L\Config::set('db.prefix', $mainframe->getCfg('dbprefix'));
		//mails
		\G3\L\Config::set('mail.from_name', $mainframe->getCfg('fromname'));
		\G3\L\Config::set('mail.from_email', $mainframe->getCfg('mailfrom'));
		
		if((int)$mainframe->getCfg('smtpauth') != 0){
			\G3\L\Config::set('mail.smtp.username', $mainframe->getCfg('smtpuser'));
			\G3\L\Config::set('mail.smtp.password', $mainframe->getCfg('smtppass'));
		}
		\G3\L\Config::set('mail.smtp.host', $mainframe->getCfg('smtphost'));
		\G3\L\Config::set('mail.smtp.security', $mainframe->getCfg('smtpsecure'));
		\G3\L\Config::set('mail.smtp.port', $mainframe->getCfg('smtpport'));
		//set timezone
		//date_default_timezone_set($mainframe->getCfg('offset'));
		\G3\L\Config::set('site.timezone', $mainframe->getCfg('offset'));
		//site title
		\G3\L\Config::set('site.title', $mainframe->getCfg('sitename'));
		//\G3\Globals::set('app', 'joomla');
		
		\G3\Globals::set('FRONT_URL', \JUri::root().'plugins/system/chronog3_plg/chronog3/');
		\G3\Globals::set('ADMIN_URL', \JUri::root().'plugins/system/chronog3_plg/chronog3/admin/');
		\G3\Globals::set('ROOT_URL', \JUri::root());
		\G3\Globals::set('ADMIN_ROOT_URL', \JUri::root().'administrator/');
		
		//\G3\Globals::set('ROOT_PATH', dirname(dirname(dirname(__FILE__))).DS);
		//\G3\Globals::set('ROOT_PATH', JPATH_BASE.DS);
		\G3\Globals::set('ROOT_PATH', JPATH_ROOT.DS);
		\G3\Globals::set('ADMIN_ROOT_PATH', JPATH_ROOT.DS.'administrator'.DS);
		
		\G3\Globals::set('CACHE_PATH', JPATH_ROOT.DS.'cache'.DS);
		
		$lang = \JFactory::getLanguage();
		\G3\L\Config::set('site.language', str_replace('-', '_', $lang->getTag()));
		
		\G3\Globals::set('CURRENT_PATH', \G3\Globals::get(''.strtoupper(GCORE_SITE).'_PATH'));
		\G3\Globals::set('CURRENT_URL', \G3\Globals::get(''.strtoupper(GCORE_SITE).'_URL'));

		\G3\L\Config::set('routes.extensions', [
			'chronoforms7server' => 'com_chronoforms7server',
			//'chronomigrator' => 'com_chronomigrator',
			'chronoforms' => 'com_chronoforms7',
			'chronobackup' => 'com_chronobackup',
			'chronoforums' => 'com_chronoforums2',
			'chronomarket' => 'com_chronomarket',
		]);
		\G3\L\Config::set('routes.ext', 'option');
		\G3\L\Config::set('routes.sef', function($url){
			return \JRoute::_($url, false);
			//return \JRoute::_($url, false, -1); //dirty hack to get the full absolute url, fix later and create the full absolute url: \JURI::getInstance()->toString(array('scheme', 'host', 'port')));
		});
	}
}