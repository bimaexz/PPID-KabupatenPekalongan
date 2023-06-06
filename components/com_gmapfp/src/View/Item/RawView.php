<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_5_0F
	* Creation date: Novembre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\View\Item;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;
use Joomla\Component\Gmapfp\Site\Helper\GmapfpHelper;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

class RawView extends BaseHtmlView
{
	public function display($tpl = null): void
	{
		$map_params = array();
		$bubble_content = '';
		
		$app    = Factory::getApplication();
		$user   = Factory::getUser();
		$params = $app->getParams();

		$num = $app->input->getInt('num');

		$model       = $this->getModel();

		$mimeType = 'text/javascript';	
		$this->document->setMimeEncoding($mimeType);

		$MapContent  = array($model->getItem());
		$MarkersContent  = GmapfpHelper::getMarkers();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		//affichage titre seule
		$bubble_content = '\'<div class="gmapfp_bubble" style="max-height:'.$params->get('gmapfp_max_height_bulle_GMapFP', 350).'px; overflow-y:auto">';
		$bubble_content .= '<h4 class="titre">\' + obj.title + \'</h4><br><br>';
		$bubble_content .= '</div>\'';
		
		$map_params['gmapfp_width_bulle_GMapFP'] = $params->get('gmapfp_width_bulle_GMapFP', 1);
		$map_params['gmapfp_plus_detail'] = $params->get('gmapfp_plus_detail', 1);
		$map_params['target'] = $params->get('target', 0);
		$map_params['gmapfp_hauteur_lightbox'] = $params->get('gmapfp_hauteur_lightbox', 400);
		$map_params['gmapfp_largeur_lightbox'] = $params->get('gmapfp_largeur_lightbox', 700);
		$map_params['gmapfp_eventcontrol'] = $params->get('gmapfp_eventcontrol', 1);
		$map_params['target'] = 4; // bloque le onclick du marqueur
		
		echo 'var map_datas'.$num.' = '. json_encode($MapContent).";\n\r";
		echo 'var marqueurs_datas'.$num.' = '. json_encode($MarkersContent).";\n\r";
		echo 'var bubble_datas'.$num.' = '. json_encode($bubble_content).";\n\r";
		echo 'var map_params'.$num.' = '. json_encode($map_params).";\n\r";
	}
}
