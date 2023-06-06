<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\L\Wordpress;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Boot extends \G3\L\Boot{
	
	function __construct($name, $plugin){
		self::initialize();
		
		global $wpdb;
		\G3\L\Config::set('db.host', DB_HOST);
		$dbtype = 'mysql';
		\G3\L\Config::set('db.type', $dbtype);
		\G3\L\Config::set('db.name', DB_NAME);
		\G3\L\Config::set('db.user', DB_USER);
		\G3\L\Config::set('db.pass', DB_PASSWORD);
		\G3\L\Config::set('db.prefix', $wpdb->prefix);
		
		//set timezone
		\G3\L\Config::set('site.timezone', !empty(get_option('timezone_string')) ? get_option('timezone_string') : 'UTC');
		//site title
		\G3\L\Config::set('site.title', get_bloginfo('name'));
		
		//\G3\Globals::set('app', 'wordpress');
		
		\G3\Globals::set('FRONT_URL', plugins_url().'/'.$plugin.'/chronog3/');
		\G3\Globals::set('ADMIN_URL', plugins_url().'/'.$plugin.'/chronog3/admin/');
		\G3\Globals::set('ROOT_URL', site_url().'/');
		\G3\Globals::set('ADMIN_ROOT_URL', site_url().'/'.'wp-admin/');
		
		\G3\Globals::set('ROOT_PATH', dirname(dirname(dirname(__FILE__))).DS);
		\G3\Globals::set('ADMIN_ROOT_PATH', dirname(dirname(dirname(__FILE__))).DS.'wp-admin'.DS);

		\G3\Globals::set('CACHE_PATH', \G3\Globals::get('FRONT_PATH').'cache'.DS);
		
		\G3\L\Config::set('site.language', str_replace('-', '_', get_bloginfo('language')));
		//change the default page parameter string because WP uses the param "page"
		//\G3\L\Config::set('page_url_param_name', 'page_num');
		
		/* if(function_exists('wp_magic_quotes')){
			$stripslashes_wp = function (&$value){
				$value = stripslashes($value);
			};
			array_walk_recursive($_GET, $stripslashes_wp);
			array_walk_recursive($_POST, $stripslashes_wp);
			array_walk_recursive($_COOKIE, $stripslashes_wp);
			array_walk_recursive($_REQUEST, $stripslashes_wp);
		} */
		
		\G3\Globals::set('CURRENT_PATH', \G3\Globals::get(''.strtoupper(GCORE_SITE).'_PATH'));
		\G3\Globals::set('CURRENT_URL', \G3\Globals::get(''.strtoupper(GCORE_SITE).'_URL'));

		\G3\L\Config::set('routes.extensions', [
			'chronoforms7server' => 'chronoforms7server',
			'chronoforms' => 'Chronoforms',
			'chronoforums' => 'chronoforums2',
			'chronomarket' => 'chronomarket',
		]);
		\G3\L\Config::set('routes.ext', 'page');

		if(\G3\Globals::get('app') == 'wordpress' AND \G3\L\Config::get('wordpress.stripslashes')){
			$stripslashes_gpc = function (&$value){
				$value = stripslashes($value);
			};
			
			array_walk_recursive($_GET, $stripslashes_gpc);
			array_walk_recursive($_POST, $stripslashes_gpc);
			array_walk_recursive($_COOKIE, $stripslashes_gpc);
			array_walk_recursive($_REQUEST, $stripslashes_gpc);
		}
	}
}