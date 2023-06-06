<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

class PlggmapfpmapopenstreetInstallerScript{

	// Method to run after the install routine.
	function postflight($type, $parent) 
	{
		// Only execute database changes on MySQL databases
		$dbName = Factory::getDbo()->name;

		if (strpos($dbName, 'mysql') !== false) {
			if($type == 'install') {
				$this->set_plugins_params();
			}
		}
	}
	
	private function set_plugins_params()
	{
		$db    = Factory::getDbo();
		
		// plg_gmapfp_map_openstreet
		$sql = 'UPDATE ' . $db->quoteName('#__extensions') . 'SET ' . $db->quoteName('params') . " = '{\"gmapfp_plug_config\":{\"lat\":\"47.91476007815484\",\"lng\":\"2.1462410086989085\",\"zoom\":\"9\",\"gmapfp_doubleClickZoom\":\"1\",\"gmapfp_keyboard\":\"1\",\"gmapfp_scrollWheelZoom\":\"1\",\"gmapfp_zoomControl\":\"1\",\"gmapfp_dragging\":\"1\",\"closePopupOnClick\":\"1\",\"gmapfp_attributionControl\":\"1\",\"gmapfp_metric\":\"1\",\"gmapfp_imperial\":\"1\",\"gmapfp_osm_layers\":{\"__field20\":{\"name\":\"Route\",\"alias\":\"OSM\",\"url\":\"\\\/\\\/{s}.tile.openstreetmap.fr\\\/osmfr\\\/{z}\\\/{x}\\\/{y}.png\",\"attribution\":\"\\\u00a9 \\\u2039a href=\\\\\"https:\\\/\\\/www.openstreetmap.org\\\/copyright\\\\\" target=\\\\\"_blank\\\\\">OpenStreetMap\\\u2039\\\/a> contributors\",\"max_zoom\":\"20\"},\"__field21\":{\"name\":\"Satellite\",\"alias\":\"esri_sat\",\"url\":\"\\\/\\\/server.arcgisonline.com\\\/ArcGIS\\\/rest\\\/services\\\/World_Imagery\\\/MapServer\\\/tile\\\/{z}\\\/{y}\\\/{x}\",\"attribution\":\"\\\u00a9  \\\u2039a href=\\\\\"http:\\\/\\\/www.esri.com\\\/\\\\\" target=\\\\\"_blank\\\\\">Esri\\\u2039\\\/a>i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community\",\"max_zoom\":\"19\"}}}}' WHERE " . $db->quoteName('name') . " = 'plg_gmapfp_map_openstreet'";
		$query = $db->getQuery(true);
		$db->setQuery($sql);
		$db->execute();
	}
}