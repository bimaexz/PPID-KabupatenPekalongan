<?php
/**
* GMapFP Plugin gmapfp-map\Google Map for Joomla! 4.0.x
* Version J4_1F
* Creation date: Avril 2021
* Author: Fabrice4821 - www.gmapfp.org
* Author email: support@gmapfp.org
* License GNU/GPL
*/

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;

$doc 	= Factory::getDocument();
$wa 	= $doc->getWebAssetManager();
$wa->useScript('jquery');

$lang 	= Factory::getLanguage(); 
$tag_lang	= $lang->getTag();

$plugin = PluginHelper::getPlugin('gmapfp-map', 'google');

if(empty($plugin) or !property_exists($plugin, 'params')) {
	echo Text::_('PLG_GMAPFP_MAP_GOOGLE_NON_CONFIGURE_OR_ACTIF');
} else {
	$params = new Registry($plugin->params);
	$map_params = new Registry($params->get('gmapfp_plug_config'));
	
	$key 	= $map_params->get('gmapfp_google_key');
	if (($tag_lang!='en-AU') AND ($tag_lang!='en-GB') AND ($tag_lang!='pt-BR') AND ($tag_lang!='pt-PT') AND ($tag_lang!='zh-CN') AND ($tag_lang!='zh-TW'))
		{$tag_lang=(substr($lang->getTag(),0,2)); };

	$doc->setMetaData('viewport', 'initial-scale=1.0, user-scalable=no');
	$doc->addCustomTag( '<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key='.$key.'&amp;language='.$tag_lang.'"></script>'); 

	$js = ''
		.'var geocoder;'
		.'var map;'
		.'var marker1;'
		.'var tstGMapFP;'
		.'var tstIntGMapFP;'
		.''
		.'function initgmapfp() {'
		.'	UpdateAddress();'
		.'	geocoder = new google.maps.Geocoder();'
		.''
		.'	if (lat == "") {'
		.'		lat = '.$map_params->get('lat',47.915).';'
		.'		jQuery("#jform_glat").val(lat);'
		.'	}'
		.'	if (lng == "") {'
		.'		lng = '.$map_params->get('lng',2.146).';'
		.'		jQuery("#jform_glng").val(lng);'
		.'	}'
		.'	if (zoom_carte == "") zoom_carte = '.$map_params->get('zoom',10).';'
		.''
		.'	var latlng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));'
		.'	var mapOptions = {'
		.'		zoom: parseInt(zoom_carte),'
		.'		center: latlng,'
		.'		mapTypeId: google.maps.MapTypeId.ROADMAP'
		.'	};'
		.''
		.'	map = new google.maps.Map(document.getElementById("map"), mapOptions);'
		.''
		.'	google.maps.event.addListener(map, "bounds_changed", function() {'
		.'		jQuery("#jform_gzoom").val(map.getZoom());'
		.'	});'
		.''
		// Create a draggable marker which will later on be binded to a'
		.'	marker1 = new google.maps.Marker({'
		.'  	map: map,'
		.'      position: new google.maps.LatLng(lat, lng),'
		.'      draggable: true,'
		.'      title: \'Drag me!\''
		.'	});'
		.'	google.maps.event.addListener(marker1, "drag", function() {'
		.'		jQuery("#jform_glat").val(marker1.getPosition().lat());'
		.'		jQuery("#jform_glng").val(marker1.getPosition().lng());'
		.'	});'
		.'}'
		.''
		//adapte les coordonnées de la carte en fonction de ceux saisis
		.'function setCoordinate(slat="", slng="") {'
		.'	if(slat && slng)'
		.'		var latlng = new google.maps.LatLng(slat, slng);'
		.'	else'
		.'		var latlng = new google.maps.LatLng(jQuery("#jform_glat").val(), jQuery("#jform_glng").val());'
		.'	map.setZoom(parseInt(jQuery("#jform_gzoom").val()));'
		.'	map.setCenter(latlng);'
		.'	marker1.setPosition(latlng); '
		.'}'
		.''
		// Register an event listener to fire when the page finishes loading
		.'jQuery( document ).ready(initialise_map_gmapfp);'
		.''
		.'function CheckGMapFP() {'
		.'	if (tstGMapFP) {'
		.'		if (tstGMapFP.offsetWidth != tstGMapFP.getAttribute("oldValue")) {'
		.'			tstGMapFP.setAttribute("oldValue",tstGMapFP.offsetWidth);'
		.'			initgmapfp();'
		.'		}'
		.'	}'
		.'}'
		.''
		.'function initialise_map_gmapfp() {'
		.'	tstGMapFP = document.getElementById("map");'
		.'  tstGMapFP.setAttribute("oldValue",0);'
		.'  tstIntGMapFP = setInterval("CheckGMapFP()",500);'
		.'}'
		.''
		."\r\n";
	$wa->addInlineScript($js);
}