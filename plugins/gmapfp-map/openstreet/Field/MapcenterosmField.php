<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.x
	* Version J4_1F
	* Creation date: Avril 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/
namespace Joomla\Plugin\GmapfpMap\Openstreet\Field;

defined('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;

class MapcenterosmField extends FormField
{
	public $type = 'Mapcenterosm';

	protected function getInput()
	{
		$doc 	= Factory::getDocument();
		$wa 	= $doc->getWebAssetManager();
		$wa->useScript('jquery');
		$lang 	= Factory::getLanguage(); 
		$tag_lang	= $lang->getTag();
		
		$base = substr($this->id, 0, strrpos($this->id, '_')+1);
		
		$plugin = PluginHelper::getPlugin('gmapfp-map', 'openstreet');
		
		if(empty($plugin) or !property_exists($plugin, 'params')) {
			return Text::_('PLG_GMAPFP_MAP_OPENSTREET_NON_CONFIGURE_OR_ACTIF');
		} else {
			$params = new Registry($plugin->params);
			$map_params = new Registry($params->get('gmapfp_map_config'));
				
			$layers = '';
			$layers .= 'var OSM = L.tileLayer("//{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png", {';
			$layers .= 'attribution: "&copy; <a href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\">OpenStreetMap</a> contributors",';
			$layers .= 'minZoom: 1,';
			$layers .= 'maxZoom: 18,';
			$layers .= 'id: "OSM"';
			$layers .= '});';
			$defaultLayer = 'stylemap = OSM;';

			HTMLHelper::_('stylesheet', 'media/plg_gmapfp-map_openstreet/leaflet/leaflet.css');
			HTMLHelper::_('script', 'media/plg_gmapfp-map_openstreet/leaflet/leaflet.js');

			if(false)
				$LF = "\r\n";
			else
				$LF = '';
			
			$js = ''
				.'var map;'
				.'var marker1;'
				.'var mes_layers = [];'
				.$LF
				.'function init_osm() {'
				.'	var stylemap;'
				.'	var lat, lng, zoom_carte;'
				.$LF		
				.'	lat = jQuery("#'.$base.'lat").val();'
				.'	lng = jQuery("#'.$base.'lng").val();'
				.'	zoom_carte = parseInt(jQuery("#'.$base.'zoom").val());'
				.$LF
				.$layers
				.$LF
				.$defaultLayer
				.$LF
				.'	var options = {'
				.'		center: [lat, lng],'
				.'		zoom: zoom_carte,'
				.'		scrollWheelZoom: false,'
				.'		layers: stylemap'
				.'	};'
				.$LF
				.'	map = L.map("'. $this->id .'", options);'
				.$LF
				//affichce l'échelle
				.'	L.control.scale().addTo(map);'
				.$LF
				// Create a draggable marker which will later on be binded to a'
				.'	marker1 = L.marker([lat, lng], {draggable: true}).addTo(map);'
				.'	marker1.bindPopup("Drag me!");'."\r\n"
				.''
				.'	marker1.on("dragend", function(ev){'
				.'		var position = ev.target;'
				.'		jQuery("#'.$base.'lat").val(position.getLatLng().lat);'
				.'		jQuery("#'.$base.'lng").val(position.getLatLng().lng);'
				.'	});'
				.$LF
				.'	map.on("zoom", function(ev){'
				.'		var zoom = ev.target;'
				.'		jQuery("#'.$base.'zoom").val(zoom.getZoom());'
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
				.'	tstGMapFP = document.getElementById("'. $this->id .'");'
				.'  tstGMapFP.setAttribute("oldValue",0);'
				.'  tstIntGMapFP = setInterval("CheckGMapFP()",500);'
				.'}'
				.'';
			$wa->addInlineScript($js);

			return '
				<style>#'. $this->id .' img {max-width : none !important;}</style>
				<div id="'. $this->id .'" style="height: 500px; width: 100%; overflow:hidden;"></div>';
		}
	}
}

?>