<?php
/*
	* GMapFP Component Google Map for Joomla! 4.x
	* Version J4_1F
	* Creation date: Mai 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
*/

namespace Joomla\Plugin\gmapfp_geocoding\google;

defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;

class plgGMapFPGoogleGeocoding
{
	protected $autoloadLanguage = true;

    public function getLatLng($add1, $add2, $cp, $ville, $departement, $pays)
    {
		//https://maps.googleapis.com/maps/api/geocode/json?components=route:Annankatu|administrative_area:Helsinki|country:Finland&key=YOUR_API_KEY
		
		$key = '';
		$trame = array();
		$lat = '';
		$lng = '';
		$error_message = '';
		$this->loadLanguage('google');
		
		if(!function_exists('curl_init')) {
			return(array('error'=>Text::_('PLG_GMAPFP-GEOCODING_GOOGLE_CURL_NOT_AVAILABLE')));
		}
		
		$plugin = PluginHelper::getPlugin('gmapfp-geocoding', 'google');
		// Check if plugin is enabled
		if ($plugin) {
			$datas_params = new Registry($plugin->params);
			$params = new Registry($datas_params->get('gmapfp_plug_config'));
			$key = $params->get('gmapfp_google_key');
		}

		if (empty(!$key)) {
			$plugin = PluginHelper::getPlugin('gmapfp-map', 'google');
			// Check if plugin is enabled
			if ($plugin) {
				$datas_params = new Registry($plugin->params);
				$params_plg_map = new Registry($datas_params->get('gmapfp_plug_config'));
				$key = $params_plg_map->get('gmapfp_google_key');
			}
		}
		
		if ($add1 or $add2)
			$trame[] = "route:".str_replace(' ', '+', trim($add1.' '.$add2));
		if ($cp)
			$trame[] = "postal_code:".$cp;
		if ($ville)
			$trame[] = "administrative_area:".str_replace(' ', '+', trim($ville));
		if ($pays)
			$trame[] = "country:".str_replace(' ', '+', trim($pays));

		$url = "https://maps.googleapis.com/maps/api/geocode/json?components=".implode('|', $trame)."&key=".$key;
		
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
			$lat = $content->results[0]->geometry->location->lat;
			$lng = $content->results[0]->geometry->location->lng;
		} else
			$error_message = $content->error_message;

		return array('error'=>$error_message, 'lat'=>$lat, 'lng'=>$lng); 
    }
	
	public function getAdresse($lat, $lng)
	{
		$adresse = '';
		$error_message = 'fonction non programmée !';
		$this->loadLanguage('google');

		if(!function_exists('curl_init')) {
			return(array('error'=>Text::_('PLG_GMAPFP-GEOCODING_GOOGLE_CURL_NOT_AVAILABLE')));
		}
		
		$plugin = PluginHelper::getPlugin('gmapfp-geocoding', 'google');
		// Check if plugin is enabled
		if ($plugin) {
			$datas_params = new Registry($plugin->params);
			$params = new Registry($datas_params->get('gmapfp_plug_config'));
			$key = $params->get('gmapfp_google_key');
		}
		if (empty($key)) {
			$plugin = PluginHelper::getPlugin('gmapfp-map', 'google');
			// Check if plugin is enabled
			if ($plugin) {
				$params = new Registry($plugin->params);
				$key = $params->get('gmapfp_google_key');
			}
		}

		// https://maps.googleapis.com/maps/api/geocode/json?latlng=47.9144379,2.148007&key=YOUR_API_KEY
		return array('error'=>$error_message, 'adresse'=>$adresse);
	}

	private function loadLanguage($name)
	{
		$lang      = Factory::getLanguage();
		return $lang->load('plg_gmapfp-geocoding_'.$name, JPATH_ADMINISTRATOR, null, false, true);
	}
}