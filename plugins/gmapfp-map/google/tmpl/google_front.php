<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.x
	* Version J4_4F
	* Creation date: Mai 2022
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
$tag_lang=(substr($lang->getTag(),0,2)); 
$lang->load('plg_gmapfp-map_google', JPATH_ADMINISTRATOR);
$plugin = PluginHelper::getPlugin('gmapfp-map', 'google');
$options = array();
$scale_options = array();
$marqueurs = array();
$centrageauto = '';
$Zauto = '';
$num = $displayData['num'];
$com_params = $displayData['params'];

if(empty($plugin) or !property_exists($plugin, 'params')) {
	echo Text::_('PLG_GMAPFP_MAP_GOOGLE_NON_CONFIGURE_OR_ACTIF');
} else {
	$plg_params = new Registry($plugin->params);
	$map_params = new Registry($plg_params->get('gmapfp_plug_config'));
		
	$key 	= $map_params->get('gmapfp_google_key');
	if (($tag_lang!='en-AU') AND ($tag_lang!='en-GB') AND ($tag_lang!='pt-BR') AND ($tag_lang!='pt-PT') AND ($tag_lang!='zh-CN') AND ($tag_lang!='zh-TW'))
		{$tag_lang = (substr($lang->getTag(),0,2)); };

	$doc->setMetaData('viewport', 'initial-scale=1.0, user-scalable=no');
	HTMLHelper::_('script', '//maps.googleapis.com/maps/api/js?key='.$key.'&amp;language='.$tag_lang);
	HTMLHelper::_('script', 'media/plg_gmapfp-map_google/js/gmapfp_google.js', array('version'=>'auto'));

	$map_lat = $com_params->get('lat',47.915);
	$map_lng = $com_params->get('lng',2.146);
	$zoom = $com_params->get('gmapfp_zoom',0);
	//Centrage automatique de la carte
	if($com_params->get('gmapfp_auto', 1)){
		if(property_exists($this, 'item')) {
			$map_lat = $this->item->glat;
			$map_lng = $this->item->glng;
			$zoom = $this->item->gzoom;
		} else {
			$centrageauto = 'carteGMapFP'.$num.'.setCenter(bounds_GMapFP'.$num.'.getCenter());'."\n";
		}
	}
	//forçage centrage par plugin
	if($com_params->get('plug_map_centre_lat', 0)) $map_lat = $com_params->get('plug_map_centre_lat');
	if($com_params->get('plug_map_centre_lng', 0)) $map_lng = $com_params->get('plug_map_centre_lng');
	if($com_params->get('gmapfp_zoom', 0)==0){
		$Zauto = 'carteGMapFP'.$num.'.fitBounds(bounds_GMapFP'.$num.');'."\n";
		$zoom = 2;
	}

	//gestion des options de la cartes:
	$ControlOption 	= '';
	$ControlOption .= 'disableDoubleClickZoom: '.(($map_params->get('gmapfp_doubleClickZoom',1))? 'false':'true').',';
	if ($map_params->get('gmapfp_scrollWheelZoom','ctrl')!='ctrl')
		$ControlOption .= 'scrollwheel: '.(($map_params->get('gmapfp_scrollWheelZoom'))? 'true':'false').',';
	$ControlOption .= 'keyboardShortcuts: '.(($map_params->get('gmapfp_keyboard',1))? 'true':'false').',';
	$ControlOption .= 'zoomControl: '.(($map_params->get('gmapfp_zoomControl',1))? 'true':'false').',';
	$ControlOption .= 'gestureHandling: '.(($map_params->get('gmapfp_dragging',1))? '"auto"':'"none"').',';
	$ControlOption .= 'streetViewControl: '.(($map_params->get('gmapfp_street_view',1))? 'true':'false').',';
	$ControlOption .= 'scaleControl: '.(($map_params->get('gmapfp_scale',0)==0)? 'false':'true').',';
	$ControlOption .= 'fullscreenControl: '.(($map_params->get('gmapfp_fullscreenControl',0)==0)? 'false':'true').',';

	$mapTypeId=array();
	//affichage bouton carte hybride
    if ($map_params->get('gmapfp_hybrid',1))
        { $mapTypeId[]='google.maps.MapTypeId.HYBRID';}
	//affichage bouton carte normale
    if ($map_params->get('gmapfp_normal',1))
        { $mapTypeId[]='google.maps.MapTypeId.ROADMAP';}
	//affichage bouton carte relief
    if ($map_params->get('gmapfp_physic',1))
        { $mapTypeId[]='google.maps.MapTypeId.TERRAIN';}
	//affichage bouton carte satellite
    if ($map_params->get('gmapfp_satellite',1))
        { $mapTypeId[]='google.maps.MapTypeId.SATELLITE';}
    $mapTypeIds=implode( ",", $mapTypeId );
    $mapTypeIds='var types = ['.$mapTypeIds.'];';

	$carte_choix = 'ROADMAP';
    if ($map_params->get('gmapfp_choix_affichage_carte',1)==2) { $carte_choix = 'SATELLITE';};
    if ($map_params->get('gmapfp_choix_affichage_carte',1)==3) { $carte_choix = 'HYBRID';};
    if ($map_params->get('gmapfp_choix_affichage_carte',1)==4) { $carte_choix = 'TERRAIN';};

	//gestion des fichiers KML
	$kml_layer = '';
	if ($com_params->get('gmapfp_geoXML')) {
		$kml_links = explode(';', $com_params->get('gmapfp_geoXML'));
		foreach ($kml_links as $i => $kml_link) {
			if(strpos($kml_link, 'http')!==0){
				if(strpos($kml_link, '//')===0){
					$kml_link = 'http:'.$kml_link;
				} else {
					$kml_link = Uri::root().$kml_link;
				}
			}
			$kml_layer .= 'kml_layer'.$num.' = new google.maps.KmlLayer({';
			$kml_layer .= 'url: "'.$kml_link.'",';
			$kml_layer .= 'map: carteGMapFP'.$num;
			$kml_layer .= '});';
		}
	}

	if(true)
		$LF = "\r\n";
	else
		$LF = '';
	
	$js = ''
		.'var marker'.$num.' = {};'
		.'var map_marker'.$num.' = {};'
		.'var infowindow'.$num.' = {};'
		.'var arrayOfLatLngs'.$num.' = [];'
		.$LF
		.'var GMapFP_baseURL = Joomla.getOptions(\'system.paths\').rootFull;'
		.'var map_lat, map_lng, marker_lat, marker_lng, zoom_carte, map;'
		.'var bounds_GMapFP'.$num.' = new google.maps.LatLngBounds();'
		.'var kml_layer'.$num.';'
		.$LF
		.'function init_gm'.$num.'() {'
		.'	var stylemap;'
		.''
		.'	map_lat = '.$map_lat.';'
		.'	map_lng = '.$map_lng.';'
		.'	zoom_carte = '.$zoom.';'
		.''
		.	$mapTypeIds
		.'	var mycentre = new google.maps.LatLng(map_lat, map_lng);'
        .'	var myOptions = {'
        .'		zoom: zoom_carte,'
        .'  	center: mycentre,'
        .		$ControlOption
        .'  	mapTypeControlOptions: {'
        .'  		mapTypeIds: types'
        .'  	},'
        .'  	mapTypeId: google.maps.MapTypeId.'.$carte_choix
        .'	};'
        .'	carteGMapFP'.$num.' = new google.maps.Map(document.getElementById("gmapfp_map'.$num.'"),myOptions);'

		// affiche les infos sur la carte'
		.'jQuery.show_map_infos(carteGMapFP'.$num.', bounds_GMapFP'.$num.', '.$num.');'
		.$centrageauto
		.$Zauto
		.$kml_layer
		.''
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
		.'			init_gm'.$num.'();'
		.'		}'
		.'	}'
		.'}'
		.$LF
		.'function initialise_map_gmapfp'.$num.'() {'
		.'	tstGMapFP'.$num.' = document.getElementById("gmapfp_map'.$num.'");'
		.'	if(tstGMapFP'.$num.') {'
		.' 	 	tstGMapFP'.$num.'.setAttribute("oldValue",0);'
		.'  	tstIntGMapFP'.$num.' = setInterval("CheckGMapFP'.$num.'()",500);'
		.'	}'
		.'}'
		.''
		.'';

	$doc->addScriptDeclaration($js);
}
