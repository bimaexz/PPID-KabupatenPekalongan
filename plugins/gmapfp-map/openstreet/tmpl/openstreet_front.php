<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.x
	* Version J4_6F
	* Creation date: Juillet 2022
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
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;

$doc = Factory::getDocument();
$wa  = $doc->getWebAssetManager();
$wa ->useScript('jquery');

$wa	->getRegistry()->addExtensionRegistryFile('com_gmapfp');
$wa	->useStyle('com_gmapfp.gmapfp')
	->useStyle('com_gmapfp.jquery.fancybox')
	->useScript('com_gmapfp.jquery.fancybox');

$lang = Factory::getLanguage(); 
$lang->load('plg_gmapfp-map_openstreet', JPATH_ADMINISTRATOR);
$tag_lang=(substr($lang->getTag(),0,2)); 
$plugin = PluginHelper::getPlugin('gmapfp-map', 'openstreet');
$options = array();
$scale_options = array();
$marqueurs = array();
$centrage_auto = '';
$num = $displayData['num'];
$com_params = $displayData['params'];


if(empty($plugin) or !property_exists($plugin, 'params')) {
	echo Text::_('PLG_GMAPFP_MAP_OPENSTREET_NON_CONFIGURE_OR_ACTIF');
} else {
	$plugin_params = new Registry($plugin->params);
	$map_params = new Registry($plugin_params->get('gmapfp_plug_config'));
		
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
			$baseLayers[] = '"'.Text::_('PLG_GMAPFP_MAP_OPENSTREET_LAYER_NAME_'.$layer->name).'":'.$layer->alias;
			$aliasLayers[] = $layer->alias;
		}
	$var_baseLayers = 'var baseLayers = {'.implode(',', $baseLayers).'};';
	
	if (in_array($map_params->get('gmapfp_type_admin_osm'), $aliasLayers))
		$defaultLayer = '';
	elseif (array_key_exists(0, $aliasLayers))
		$defaultLayer = 'stylemap = "'.$aliasLayers[0].'";';
		
	HTMLHelper::_('stylesheet', 'media/plg_gmapfp-map_openstreet/leaflet/leaflet.css');
	HTMLHelper::_('script', 'media/plg_gmapfp-map_openstreet/leaflet/leaflet.js');
	HTMLHelper::_('script', 'media/plg_gmapfp-map_openstreet/js/gmapfp_osm.js');
	
	$map_lat = $com_params->get('lat',47.915);
	$map_lng = $com_params->get('lng',2.146);
	$zoom = $com_params->get('gmapfp_zoom',10);
	//Centrage automatique de la carte
	if($com_params->get('gmapfp_auto', 1)){
		if(property_exists($this, 'item')) {
			$map_lat = $this->item->glat;
			$map_lng = $this->item->glng;
			$zoom = $this->item->gzoom;
		}
	}
	
	//forçage centrage par plugin
	if($map_params->get('plug_map_centre_lat', 0)) $map_lat = $map_params->get('plug_map_centre_lat');
	if($map_params->get('plug_map_centre_lng', 0)) $map_lng = $map_params->get('plug_map_centre_lng');
	
	//gestion des options de la cartes
	$options[] = 'doubleClickZoom: '.$map_params->get('gmapfp_doubleClickZoom',0);
	$options[] = 'keyboard: '.$map_params->get('gmapfp_keyboard',1);
	$options[] = 'scrollWheelZoom: '.$map_params->get('gmapfp_scrollWheelZoom',1);
	$options[] = 'zoomControl: '.$map_params->get('gmapfp_zoomControl',1);
	$options[] = 'dragging: '.$map_params->get('gmapfp_dragging',1);
	$options[] = 'closePopupOnClick: '.$map_params->get('closePopupOnClick',1);
	$options[] = 'attributionControl: '.$map_params->get('gmapfp_attributionControl',1);
	//gestion des options de l'échelle
	$scale_options[] = 'metric: '.$map_params->get('gmapfp_metric',1);
	$scale_options[] = 'imperial: '.$map_params->get('gmapfp_imperial',1);
	
	//gestion des fichiers KML
	$kml_layer = '';
	if ($com_params->get('gmapfp_geoXML')) {
		HTMLHelper::_('script', 'media/plg_gmapfp-map_openstreet/leaflet/KML.js');
		$kml_links = explode(';', $com_params->get('gmapfp_geoXML'));
		foreach ($kml_links as $i => $kml_link) {
			if(strpos($kml_link, 'http')!==0){
				if(strpos($kml_link, '//')===0){
					$kml_link = 'http:'.$kml_link;
				} else {
					$kml_link = Uri::root().$kml_link;
				}
			}
			$kml_layer .= 'kmlLayer'.(int)$i.' = new L.KML("'.$kml_link.'", {async: true});';
			$kml_layer .= 'carteGMapFP'.$num.'.addLayer(kmlLayer'.(int)$i.');';
		}
	}
	
	if ($com_params->get('gmapfp_auto', 1)) {
		$centrage_auto .= 'carteGMapFP'.$num.'.fitBounds(arrayOfLatLngs'.$num.');';
		if ($zoom > 0) $centrage_auto .= 'carteGMapFP'.$num.'.setZoom('.$zoom.')';
		$centrage_auto .= '';
		$centrage_auto .= '';
	}

	if(true)
		$LF = "\r\n";
	else
		$LF = '';
		
	if ($zoom == 0) $zoom = 1; //zoom auto ne marche pas avec une valeur de base à 0
	
	$js = ''
		.'var marker'.$num.' = {};'
		.'var map_marker'.$num.' = {};'
		.'var infowindow'.$num.' = {};'
		.'var arrayOfLatLngs'.$num.' = [];'
		.$LF
		.'var GMapFP_baseURL = Joomla.getOptions(\'system.paths\').rootFull;'
		.'var map_lat, map_lng, marker_lat, marker_lng, zoom_carte, map;'
		// .'var kmlLayer;'
		.'var mes_layers = [];'
		.$LF
		.'function init_osm'.$num.'() {'
		.'	var stylemap;'
		.''
		.'	map_lat = '.$map_lat.';'
		.'	map_lng = '.$map_lng.';'
		.'	zoom_carte = '.(int)$zoom.';'
		.''
		.$defaultLayer
		.''
		.$layers
		.$LF
		.'	var options = {'
		.'		center: [map_lat, map_lng],'
		.'		zoom: zoom_carte,'
		.'		layers: [mes_layers[stylemap]],'
		.		implode(',', $options)
		.'	};'
		.$LF
		.'	carteGMapFP'.$num.' = L.map("gmapfp_map'.$num.'", options);'
		.''
		.$LF
		.$kml_layer
		.$LF
		//affiche l'échelle
		.'	var scale_options = {'
		.		implode(',', $scale_options)
		.'	};'
		.'	L.control.scale(scale_options).addTo(carteGMapFP'.$num.');'
		.$LF
		.''
		.$var_baseLayers
		.''
		.'	L.control.layers(baseLayers).addTo(carteGMapFP'.$num.');'
		.''
		// affiche les infos sur la carte'
		.'	jQuery.show_map_infos(carteGMapFP'.$num.', '.$num.');'
		.''
		.$centrage_auto
		.'}'
		.$LF
		// Register an event listener to fire when the page finishes loading
		.'jQuery( document ).ready(initialise_map_gmapfp'.$num.');'
		.$LF
		.'var tstGMapFP'.$num.';'
		.'var tstIntGMapFP'.$num.';'
		.$LF
		.'function CheckGMapFP'.$num.'() {'
		.'	if (tstGMapFP'.$num.') {'
		.'		if (tstGMapFP'.$num.'.offsetWidth != tstGMapFP'.$num.'.getAttribute("oldValue")) {'
		.'			tstGMapFP'.$num.'.setAttribute("oldValue",tstGMapFP'.$num.'.offsetWidth);'
		.'			init_osm'.$num.'();'
		.'		}'
		.'	}'
		.'}'
		.$LF
		.'function initialise_map_gmapfp'.$num.'() {'
		.'	tstGMapFP'.$num.' = document.getElementById("gmapfp_map'.$num.'");'
		.'	if (tstGMapFP'.$num.') {'
		.'  	tstGMapFP'.$num.'.setAttribute("oldValue",0);'
		.'  	tstIntGMapFP'.$num.' = setInterval("CheckGMapFP'.$num.'()",500);'
		.'	}'
		.'}'
		.''
		.'';

	$wa->addInlineScript($js);
}
