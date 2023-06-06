<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.x
	* Version J4_1F
	* Creation date: Avril 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/
namespace Joomla\Plugin\GmapfpMap\Google\Field;

defined('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;

class MapcentergoogleField extends FormField
{
	public $type = 'Mapcentergoogle';

	protected function getInput()
	{
		$doc 	= Factory::getDocument();
		$wa 	= $doc->getWebAssetManager();
		$wa->useScript('jquery');
		$lang 	= Factory::getLanguage(); 
		$tag_lang	= $lang->getTag();
		
		$base = substr($this->id, 0, strrpos($this->id, '_')+1);
		
		$plugin = PluginHelper::getPlugin('gmapfp-map', 'google');
		
		if(empty($plugin) or !property_exists($plugin, 'params')) {
			return Text::_('PLG_GMAPFP_MAP_GOOGLE_NON_CONFIGURE_OR_ACTIF');
		} else {
			$params = new Registry($plugin->params);
			$map_param = $params->get('gmapfp_plug_config');
			$key 	= '';
			if (is_object($map_param) and property_exists($map_param, 'gmapfp_google_key')) $key 	= $map_param->gmapfp_google_key;
			if (($tag_lang!='en-AU') AND ($tag_lang!='en-GB') AND ($tag_lang!='pt-BR') AND ($tag_lang!='pt-PT') AND ($tag_lang!='zh-CN') AND ($tag_lang!='zh-TW'))
				{$tag_lang=(substr($lang->getTag(),0,2)); };

			$doc->setMetaData('viewport', 'initial-scale=1.0, user-scalable=no');
			$doc->addCustomTag( '<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key='.$key.'&amp;language='.$tag_lang.'"></script>'); 

			$js = ''
				.'var map;'
				.'var marker1;'
				.''
				.'function initgmapfp() {'
				.'	var lat, lng, zoom_carte;'
				.''		
				.'	lat = jQuery("#'.$base.'lat").val();'
				.'	lng = jQuery("#'.$base.'lng").val();'
				.'	zoom_carte = parseInt(jQuery("#'.$base.'zoom").val());'
				.''
				.'	var latlng = new google.maps.LatLng(lat, lng);'
				.'	var mapOptions = {'
				.'		zoom: zoom_carte,'
				.'		center: latlng,'
				.'		mapTypeId: google.maps.MapTypeId.ROADMAP'
				.'	};'
				.''
				.'	map = new google.maps.Map(document.getElementById("'. $this->id .'"), mapOptions);'
				.''
				.'	google.maps.event.addListener(map, "bounds_changed", function() {'
				.'		jQuery("#'.$base.'zoom").val(map.getZoom());'
				.'	});'
				.''
				  // Create a draggable marker which will later on be binded to a
				.'  marker1 = new google.maps.Marker({'
				.'	  map: map,'
				.'	  position: new google.maps.LatLng(lat, lng),'
				.'	  draggable: true,'
				.'	  title: "Drag me!"'
				.'  });'
				.'  google.maps.event.addListener(marker1, "drag", function() {'
				.'		jQuery("#'.$base.'lat").val(marker1.getPosition().lat());'
				.'		jQuery("#'.$base.'lng").val(marker1.getPosition().lng());'
				.'  });'
				.'}'
				.''
				// Register an event listener to fire when the page finishes loading.
				.'jQuery( document ).ready(initgmapfp);'
				.'';
			$wa->addInlineScript($js);

			return '
				<style>#'. $this->id .' img {max-width : none !important;}</style>
				<div id="'. $this->id .'" style="height: 500px; width: 100%; overflow:hidden;"></div>';
		}
	}
}

?>