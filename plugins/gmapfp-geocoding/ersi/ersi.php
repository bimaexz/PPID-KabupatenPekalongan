<?php
/*
	* GMapFP Component Google Map for Joomla! 4.x
	* Version J4_1F
	* Creation date: Mai 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
*/

namespace Joomla\Plugin\gmapfp_geocoding\ersi;

defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;

class plgGMapFPErsiGeocoding
{
	protected $autoloadLanguage = true;

    public function getLatLng($add1, $add2, $cp, $ville, $departement, $pays)
    {
		$key = '';
		$trame = array();
		$lat = '';
		$lng = '';
		$error_message = '';
		$this->loadLanguage('ersi');

		if(!function_exists('curl_init')) {
			return(array('error'=>Text::_('PLG_GMAPFP-GEOCODING_ERSI_CURL_NOT_AVAILABLE')));
		}
		// http://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates?singleLine=l%27Aubini%C3%A8re%2045450%20fay-aux-loges&outFields=City%2CRegion%2CCountry&maxLocations=1&f=pjson
		
		$plugin = PluginHelper::getPlugin('gmapfp-geocoding', 'ersi');
		// Check if plugin is enabled
		if ($plugin) {
			$datas_params = new Registry($plugin->params);
			$params = new Registry($datas_params->get('gmapfp_plug_config'));
			$key = $params->get('gmapfp_ersi_key');
		}
			
		if ($key) {
			$trame[] = 'forStorage = true';
			$trame[] = 'token = '.$key;
		}
		
		if ($add1)
			$trame[] = "address=".urlencode(trim($add1));
		if ($add2)
			$trame[] = "address2=".urlencode(trim($add2));
		if ($cp)
			$trame[] = "postal=".urlencode($cp);
		if ($ville)
			$trame[] = "city=".urlencode(trim($ville));
		if ($pays)
			$trame[] = "country=".urlencode(trim($pays));
			
		$url = "https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates?maxLocations=1&f=pjson&".implode('&', $trame);
		// $url='https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates?maxLocations=1&f=pjson&address=L%27Aubini%C3%A8re&postal=45450&city=FAY%20AUX%20LOGES&country=France';
		
		$options = array( 
			CURLOPT_RETURNTRANSFER => true,     // return web page 
			CURLOPT_HEADER         => false,    // return headers 
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects 
			CURLOPT_ENCODING       => "",       // handle all encodings 
			CURLOPT_USERAGENT      => "spider", // who am i 
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect 
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect 
			CURLOPT_TIMEOUT        => 120,      // timeout on response 
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects 
		); 
	 // die($url);
		$ch      = curl_init( $url ); 
		curl_setopt_array( $ch, $options ); 
		$content = curl_exec( $ch ); 
		$err     = curl_errno( $ch ); 
		$errmsg  = curl_error( $ch ); 
		$header  = curl_getinfo( $ch ); 
		curl_close( $ch ); 
		
		if ($err) return array('error'=>$errmsg);
		
		$content = json_decode($content);
		
		if ($content and property_exists($content, 'candidates')) {
			$lat = $content->candidates[0]->location->y;
			$lng = $content->candidates[0]->location->x;
		} else
			$error_message = Text::_('PLG_GMAPFP-GEOCODING_ERSI_NO_ADDRESS_FOUND');

		return array('error'=>$error_message, 'lat'=>$lat, 'lng'=>$lng); 
    }
	
	public function getAdresse($lat, $lng)
	{
		$key = '';
		$trame = array();
		$lat = '';
		$lng = '';
		$error_message = '';
		$this->loadLanguage('ersi');

		if(!function_exists('curl_init')) {
			return(array('error'=>Text::_('PLG_GMAPFP-GEOCODING_ERSI_CURL_NOT_AVAILABLE')));
		}
		// http://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates?singleLine=l%27Aubini%C3%A8re%2045450%20fay-aux-loges&outFields=City%2CRegion%2CCountry&maxLocations=1&f=pjson
		
		$plugin = PluginHelper::getPlugin('gmapfp-geocoding', 'ersi');
		// Check if plugin is enabled
		if ($plugin) {
			$datas_params = new Registry($plugin->params);
			$params = new Registry($datas_params->get('gmapfp_plug_config'));
			$key = $params->get('gmapfp_ersi_key');
		}

		if ($key) {
			$trame[] = 'forStorage = true';
			$trame[] = 'token = '.$key;
		}
		
		if ($lat and $lng)
			$trame[] = 'location='.trim($lng).','.trim($lat);
		
		$adresse = '';
		$error_message = '';
		
		if(!function_exists('curl_init')) {
			return(array('error'=>JText::_('PLG_GMAPFP_GEOCODING_ERSI_CURL_NOT_AVAILABLE')));
		}
		$url = "https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode?maxLocations=1&f=pjson&outFields=City%2CRegion%2CCountry&".implode('&', $trame);
		$options = array( 
			CURLOPT_RETURNTRANSFER => true,     // return web page 
			CURLOPT_HEADER         => true,    // return headers 
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects 
			CURLOPT_ENCODING       => "",       // handle all encodings 
			CURLOPT_USERAGENT      => "spider", // who am i 
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect 
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect 
			CURLOPT_TIMEOUT        => 120,      // timeout on response 
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects 
		); 
	 
		$ch      = curl_init( $url ); 
		curl_setopt_array( $ch, $options ); 
		$content = curl_exec( $ch ); 
		$err     = curl_errno( $ch ); 
		$errmsg  = curl_error( $ch ); 
		$header  = curl_getinfo( $ch ); 
		curl_close( $ch ); 
		
		if ($err) return array('error'=>$errmsg);
		
		$content = json_decode(substr($content, stripos($content, '{')));
		
		$status = $content->status;
		if ($status == 'OK') {
			$adresse = $content->location[0]->geometry->location->lat;
		} else
			$error_message = $content->error_message;
			
		$error_message = 'fonction non programmée !';

		return array('error'=>$error_message, 'adresse'=>$adresse);
	}
	
	private function loadLanguage($name)
	{
		$lang      = Factory::getLanguage();
		return $lang->load('plg_gmapfp-geocoding_'.$name, JPATH_ADMINISTRATOR, null, false, true);
	}
}