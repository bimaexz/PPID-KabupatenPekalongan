<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.x
	* Version J4_1F
	* Creation date: Avril 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;

$doc = Factory::getDocument();
$wa  = $doc->getWebAssetManager();
$wa->useScript('jquery');
$lang = Factory::getLanguage(); 
$tag_lang=(substr($lang->getTag(),0,2)); 

$plugin = PluginHelper::getPlugin('gmapfp-map', 'openstreet');

if(empty($plugin) or !property_exists($plugin, 'params')) {
	echo Text::_('PLG_GMAPFP_MAP_OPENSTREET_NON_CONFIGURE_OR_ACTIF');
} else {
	$params = new Registry($plugin->params);
	$map_params = new Registry($params->get('gmapfp_plug_config'));
		
	$layers = '';
	$baseLayers = array();
	$aliasLayers = array();
	$paramsLayers = $map_params->get('gmapfp_osm_layers');
	$defaultLayer = '';
	if ($paramsLayers)
		foreach($paramsLayers AS $layer){
			$layers .= 'var '.$layer->alias.' = L.tileLayer("'.$layer->url.'", {';
			$layers .= 'attribution: "'.str_replace(array('"', '‹'), array('\"', '<'), $layer->attribution).'",';
			$layers .= 'minZoom: 1,';
			$layers .= 'maxZoom: '.$layer->max_zoom.',';
			$layers .= 'id: "'.$layer->alias.'"';
			$layers .= '});';
			$layers .= 'mes_layers["'.$layer->alias.'"] = '.$layer->alias.';';
			$baseLayers[] = '"'.$layer->name.'":'.$layer->alias;
			$aliasLayers[] = $layer->alias;
		}
	else {
		throw new \RuntimeException(Text::_('PLG_GMAPFP_MAP_OPENSTREET_LAYER_NOT_DEFINED'));
		return false;
	}
		
	$var_baseLayers = 'var baseLayers = {'.implode(',', $baseLayers).'};';
	
	if (in_array($map_params->get('gmapfp_type_admin_osm'), $aliasLayers))
		$defaultLayer = '';
	elseif (array_key_exists(0, $aliasLayers))
		$defaultLayer = 'stylemap = "'.$aliasLayers[0].'";';
		
	HTMLHelper::_('stylesheet', 'media/plg_gmapfp-map_openstreet/leaflet/leaflet.css');
	HTMLHelper::_('script', 'media/plg_gmapfp-map_openstreet/leaflet/leaflet.js');

	if(true)
		$LF = "\r\n";
	else
		$LF = '';
	
	$js = ''
		.'var map;'
		.'var marker1;'
		.'var mes_layers = [];'
		.$LF
		.'function init_osm() {'
		.'	UpdateAddress();'
		.'	var stylemap;'
		.''
		.'	if (lat == "") {'
		.'		lat = '.$map_params->get('lat',47.915).';'
		.'		jQuery("#jform_glat").val(lat);'
		.'	}'
		.'	if (lng == "") {'
		.'		lng = '.$map_params->get('lng',2.146).';'
		.'		jQuery("#jform_glng").val(lng);'
		.'	}'
		.'	if (zoom_carte == "") {'
		.'		zoom_carte = '.$map_params->get('zoom',10).';'
		.'		jQuery("#jform_gzoom").val(zoom_carte);'
		.'	}'
		.''
		.$LF
		.''
		.$defaultLayer
		.''
		.$LF
		.''
		.$layers
		.''
		.$LF
		.''
		.'	var options = {'
		.'		center: [lat, lng],'
		.'		zoom: zoom_carte,'
		.'		layers: [mes_layers[stylemap]]'
		.'	};'
		.''
		.'	map = L.map("map", options);'
		.''
		//affiche l'échelle
		.'	L.control.scale().addTo(map);'
		.''
		.$var_baseLayers
		.''
		.'	L.control.layers(baseLayers).addTo(map);'
		.''
		// Create a draggable marker which will later on be binded to a'
		.'	marker1 = L.marker([lat, lng], {draggable: true}).addTo(map);'
		.'	marker1.bindPopup("Drag me!");'."\r\n"
		.''
		.'	marker1.on("dragend", function(ev){'
		.'		var position = ev.target;'
		.'		jQuery("#jform_glat").val(position.getLatLng().lat);'
		.'		jQuery("#jform_glng").val(position.getLatLng().lng);'
		.'	});'
		.''
		.'	map.on("zoom", function(ev){'
		.'		var zoom = ev.target;'
		.'		jQuery("#jform_gzoom").val(zoom.getZoom());'
		.'	});'
		.''
		.'	map.on("baselayerchange ", function(ev){'
		.'		if ( (e = document.getElementById("jform_gmapfp_type_admin_osm")))'
		.'		   e.value = ev.layer.options.id;'
		.'		if ( (e = document.getElementById("jform_params_gmapfp_type_admin_osm")))'
		.'		   e.value = ev.layer.options.id;'
		.'	});'
		.'}'
		.$LF
		//adapte les coordonnées de la carte en fonction de ceux saisis
		.'function setCoordinate(slat="", slng="") {'
		.'	if(slat && slng)'
		.'		var latlng = L.latLng(slat, slng);'
		.'	else'
		.'		var latlng = L.latLng(jQuery("#jform_glat").val(), jQuery("#jform_glng").val());'
		.'	map.setView(latlng, jQuery("#jform_gzoom").val()); '
		.'	marker1.setLatLng(latlng);'
		.'}'
		.$LF
		// Register an event listener to fire when the page finishes loading
		.'jQuery( document ).ready(initialise_map_gmapfp);'
		.$LF
		.'var tstGMapFP;'
		.'var tstIntGMapFP;'
		.$LF
		.'function CheckGMapFP() {'
		.'	if (tstGMapFP) {'
		.'		if (tstGMapFP.offsetWidth != tstGMapFP.getAttribute("oldValue")) {'
		.'			tstGMapFP.setAttribute("oldValue",tstGMapFP.offsetWidth);'
		.'			init_osm();'
		.'		}'
		.'	}'
		.'}'
		.$LF
		.'function initialise_map_gmapfp() {'
		.'	tstGMapFP = document.getElementById("map");'
		.'  tstGMapFP.setAttribute("oldValue",0);'
		.' tstIntGMapFP = setInterval("CheckGMapFP()",500);'
		.'}'
		.'';

	$wa->addInlineScript($js);
}
