<?php
/**
* @title		banner image zoom effect
* @website		http://www.joomhome.com
* @copyright	Copyright (C) 2015 joomhome.com. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
// Path assignments
$mosConfig_absolute_path = JPATH_SITE;
$mosConfig_live_site = JURI :: base();
if(substr($mosConfig_live_site, -1)=="/") { $mosConfig_live_site = substr($mosConfig_live_site, 0, -1); }

if (JVERSION < 3) {
	JHTML::_('behavior.mootools');
} else {
	JHtml::_('jquery.framework');        
}
// Include helper.php
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
require_once (dirname(__FILE__).DS.'helper.php');
$lists 					= modBannerimagezoomeffectHelper::getList($params);
$uri 					= JURI::getInstance();
$uniqid					= $module->id;

$moduleclass_sfx		= $params->get('moduleclass_sfx', "");
$enable_jQuery			= $params->get('enable_jQuery', 1);
$width					= $params->get('width', "100%");
$height 				= $params->get('height', "500");
$title_module 			= $params->get('title_module', "Banner Image Zoom Effect");
$description 			= $params->get('description', "Slideshows with zoom effect using background-image and CSS3.");
//$link_array				= split ("\;", $links);
$bg_color_arrows 		= $params->get('bg_color_arrows', "#72b890");

$flip					= $params->get('flip', 1);
if($flip == 1){
	$flip_real = "vertical";
} else {
	$flip_real = "horizontal";
}
$autoplay				= $params->get('autoplay', 1);
$speed					= $params->get('speed', "800");
$interval 				= $params->get('interval', "3000");
$circular				= $params->get('circular', 1);
$shadows				= $params->get('shadows', 1);

$path 					= $params->get('path');
$path = ltrim($path,'/');

$items					= count($lists);
$images_string='';
$count0=1;
//effect:
//1. spin
//2. perspective
//3. smooth
//4. slideRight
foreach($lists as $item){
	if($count0==$items){
		$images_string .= '"'.$item->image.'"';
	} else {
		$images_string .= '"'.$item->image.'", ';
	}
	$count0++;
};

$document 				= JFactory::getDocument();
require(JModuleHelper::getLayoutPath('mod_banner_image_zoom_effect'));
?>
