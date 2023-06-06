<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_2F
	* Creation date: Juillet 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Http\HttpFactory;
use Joomla\Filter\OutputFilter;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\MVC\Model\BaseModel;
use Joomla\Database\ParameterType;
use Joomla\Registry\Registry;
use Joomla\CMS\Loader;

class AjaxModel extends BaseModel
{

	public function getLatLng($add1, $add2, $cp, $ville, $departement, $pays)
	{
		$params = ComponentHelper::getParams('com_gmapfp');

		$plugin_name = $params->get('plugin_geocoding_name', 'google');
		$plugin_path = JPATH_PLUGINS."/gmapfp-geocoding/$plugin_name/$plugin_name.php";
		
			require_once ($plugin_path);
			
		$plugin_class = '\Joomla\Plugin\gmapfp_geocoding\\'.$plugin_name.'\plgGMapFP'.$plugin_name.'Geocoding';
		$plugins = new $plugin_class;
		
		$result = $plugins->getLatLng($add1, $add2, $cp, $ville, $departement, $pays);
		
		return $result;
	}

	public function getAdresse($lat, $lng)
	{
		$params = ComponentHelper::getParams('com_gmapfp');

		$plugin_name = $params->get('plugin_geocoding_name', 'google');
		$plugin_path = JPATH_PLUGINS."/gmapfp-geocoding/$plugin_name/$plugin_name.php";
		
			require_once ($plugin_path);
			
		$plugin_class = '\Joomla\Plugin\gmapfp_geocoding\\'.$plugin_name.'\plgGMapFP'.$plugin_name.'Geocoding';
		$plugins = new $plugin_class;
		
		$result = $plugins->getAdresse($lat, $lng);
		
		return $result;
	}

	/**
	 * News du site de GMapFP
	 */
	public function Infos_News() 
	{
        $lang = Factory::getLanguage(); 
        $tag_lang=(substr($lang->getTag(),0,2)); 

		//  get RSS parsed object
		if ($tag_lang=='fr'){
			$rssurl		= 'https://gmapfp.org/fr/news?format=feed&type=rss';
		}else{
			$rssurl		= 'https://gmapfp.org/en/news-of-gmapfp?format=feed&type=rss';
		};
		return $this->rss_out($rssurl);
	}

	private function rss_out($rssurl)
	{
		$output = '';
		
		try
		{
			$response = HttpFactory::getHttp()->get($rssurl);
		}
		catch (\RuntimeException $e)
		{
			$response = null;
		}

		if ($response === null || $response->code !== 200)
		{
			Factory::getApplication()->enqueueMessage(Text::sprintf('COM_GMAPFP_MSG_ERROR_CANT_CONNECT_TO_NEWS_SERVER', $rssurl), 'error');

			return;
		}

		$updateSiteXML = simplexml_load_string($response->body);
		$languages     = array();

		foreach ($updateSiteXML->channel->item as $news)
		{
		}
		$numItems = 5;
		for( $j = 0; $j < $numItems; $j++ ) {
			$item = $updateSiteXML->channel->item[$j];
			$output .= '<h5 class="feed-link">';
			$output .= '<a href="' .$item->guid. '" target="_blank">' .$item->title. '</a>';
			$output .= '</h5>';
			if($item->description) {
				$text = OutputFilter::stripImages($item->description);
				$text = HTMLHelper::_('string.truncate', $text, 250);
				$output .= '<div class="feed-item-description">'.str_replace('&apos;', "'", $text).'</div>';
			}
		}

	 	return $output;
	}
}
