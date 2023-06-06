<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_7F
	* Creation date: Mai 2022
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

class GmapfpHelper
{
	public static function getMarkers()
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*')
			->from($db->quoteName('#__gmapfp_marqueurs'))
			->where($db->quoteName('state').' = 1');
		$db->setQuery($query);
		$markers = $db->loadObjectList('id');

		return $markers;
	}
	
	public static function getPerso($id)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*')
			->from($db->quoteName('#__gmapfp_personnalisation'))
			->where('id = '.(int)$id)
			->where('state = 1');
		$db->setQuery($query);
		$Perso = $db->loadObject();

		return $Perso;
	}
	
	//retourne la latitude et longitude d'un lieu (fonction centrage sur un lieu du plugin)
	public static function getLatLng($id)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('glat, glng')
			->from($db->quoteName('#__gmapfp'))
			->where('id = '.(int)$id);
		$db->setQuery($query);
		$result = $db->loadAssoc();

		return $result;
	}
	
	public static function getSexagesimale($coordonne)
	{
		if($coordonne >=0)
			$sexagesimale[0] = '';
		else
			$sexagesimale[0] = '-';
			
		$coordonne = abs($coordonne);
		$sexagesimale[1] = floor($coordonne);
		$tmp = ($coordonne-$sexagesimale[1])*60;
		$sexagesimale[2] = floor($tmp);
		$sexagesimale[3] = round(($tmp-$sexagesimale[2])*60, 3);

		return $sexagesimale[0].$sexagesimale[1].'° '.$sexagesimale[2].'\' '.$sexagesimale[3].'"';
	}
	
	public static function getBubble($params)
	{
		if ($params->get('gmapfp_eventcontrol', 1) == 1)
			$read_more = '<h4>'.str_replace("'", "\'", Text::_('COM_GMAPFP_CLIQUER_POUR_ARTICLE')).'</h4>';
		else
			$read_more = '<h4><a href="javascript:show_marker_link(\' + obj.id + \');">'.str_replace("'", "\'", Text::_('COM_GMAPFP_READ_MORE_TITLE')).'</a></h4>';
		switch ($params->get('affichage', 400)) {
			case 1: //affichage image + adresse
				$bubble_content = '\'<div class="gmapfp_bubble" style="width:'.$params->get('gmapfp_width_bulle_GMapFP', 400).'px; min-height:'.$params->get('gmapfp_min_height_bulle_GMapFP', 150).'px; max-height:'.$params->get('gmapfp_max_height_bulle_GMapFP', 350).'px; overflow-y:auto">';
				$bubble_content .= '<h4 class="titre">\' + obj.title + \'</h4><br><br>';
				$bubble_content .= '<div \' + gmapfp_img_style + \'><img class="gmapfp-thumbnail img-thumbnail" style="height: 80px;" src="\' + GMapFP_baseURL + image.image + \'"></div>';
				$bubble_content .= '<p class="adresse">\' + obj.adresse + \'<br>\' + obj.codepostal + \'<br>\' + obj.ville + \'<br>\' + obj.departement + \'<br>\' + obj.pays + \'<br></p>';
				$bubble_content .= $read_more.'</div>\'';
				break;
			case 2: //affichage image + description
				$bubble_content = '\'<div class="gmapfp_bubble" style="width:'.$params->get('gmapfp_width_bulle_GMapFP', 400).'px; min-height:'.$params->get('gmapfp_min_height_bulle_GMapFP', 150).'px; max-height:'.$params->get('gmapfp_max_height_bulle_GMapFP', 350).'px; overflow-y:auto">';
				$bubble_content .= '<h4 class="titre">\' + obj.title + \'</h4><br><br>';
				$bubble_content .= '<div \' + gmapfp_img_style + \'><img class="gmapfp-thumbnail img-thumbnail" style="height: 80px;" src="\' + GMapFP_baseURL + image.image + \'"></div>';
				$bubble_content .= '<p class="message">\' + obj.introtext + \'</p>';
				$bubble_content .= $read_more.'</div>\'';
				break;
			case 3: //affichage titre seule
				$bubble_content = '\'<div class="gmapfp_bubble" style="width:'.$params->get('gmapfp_width_bulle_GMapFP', 400).'px; min-height:'.$params->get('gmapfp_min_height_bulle_GMapFP', 150).'px; max-height:'.$params->get('gmapfp_max_height_bulle_GMapFP', 350).'px; overflow-y:auto">';
				$bubble_content .= '<h4 class="titre">\' + obj.title + \'</h4><br><br>';
				$bubble_content .= $read_more.'</div>\'';
				break;
			default ://affichage complet
				$bubble_content = '\'<div class="gmapfp_bubble" style="width:'.$params->get('gmapfp_width_bulle_GMapFP', 400).'px; min-height:'.$params->get('gmapfp_min_height_bulle_GMapFP', 150).'px; max-height:'.$params->get('gmapfp_max_height_bulle_GMapFP', 350).'px; overflow-y:auto">';
				$bubble_content .= '<h4 class="titre">\' + obj.title + \'</h4>';
				$bubble_content .= '<div class="main-adresse">';
				$bubble_content .= '<div \' + gmapfp_img_style + \'><img class="gmapfp-thumbnail img-thumbnail" style="height: 80px;float:left;" src="\' + GMapFP_baseURL + image.image + \'"></div>';
				$bubble_content .= '<p class="adresse">\' + obj.adresse + \'<br>\' + obj.codepostal + \'<br>\' + obj.ville + \'<br>\' + obj.departement + \'<br>\' + obj.pays + \'</p>';
				$bubble_content .= '</div>';
				$bubble_content .= '<p class="message">\' + obj.introtext + \'</p>';
				$bubble_content .= $read_more.'</div>\'';
		}
		
		return $bubble_content;
	}
	
	public static function getIconsAddress($params)
	{
		switch ($params->get('coordinates_icons')) {
			case 1 :
				// Text
				$params->set('marker_address',   Text::_('COM_GMAPFP_ADRESSE'));
				$params->set('marker_email',     Text::_('COM_GMAPFP_EMAIL'));
				$params->set('marker_telephone', Text::_('COM_GMAPFP_TEL'));
				$params->set('marker_class',     'jicons-text');
				break;

			case 2 :
				// None
				$params->set('marker_address',   '');
				$params->set('marker_email',     '');
				$params->set('marker_telephone', '');
				$params->set('marker_class',     'jicons-none');
				break;

			default :
				if ($params->get('icon_address'))
				{
					$image1 = HTMLHelper::_(
						'image',
						$params->get('icon_address', 'con_address.png'),
						Text::_('COM_GMAPFP_ADRESSE'),
						null,
						false
					);
				}
				else
				{
					$image1 = HTMLHelper::_(
						'image', 'com_gmapfp/' . $params->get('icon_address', 'con_address.png'),
						Text::_('COM_GMAPFP_ADRESSE'),
						null,
						true
					);
				}

				if ($params->get('icon_email'))
				{
					$image2 = HTMLHelper::_(
						'image',
						$params->get('icon_email', 'emailButton.png'),
						Text::_('COM_GMAPFP_EMAIL'),
						null,
						false
					);
				}
				else
				{
					$image2 = HTMLHelper::_(
						'image',
						'com_gmapfp/' . $params->get('icon_email', 'emailButton.png'),
						Text::_('COM_GMAPFP_EMAIL'),
						null,
						true
					);
				}

				if ($params->get('icon_telephone'))
				{
					$image3 = HTMLHelper::_(
						'image',
						$params->get('icon_telephone', 'con_tel.png'),
						Text::_('COM_GMAPFP_TEL'),
						null,
						false
					);
				}
				else
				{
					$image3 = HTMLHelper::_(
						'image',
						'com_gmapfp/' . $params->get('icon_telephone', 'con_tel.png'),
						Text::_('COM_GMAPFP_TEL'),
						null,
						true
					);
				}

				$params->set('marker_address',   $image1);
				$params->set('marker_email',     $image2);
				$params->set('marker_telephone', $image3);
				$params->set('marker_class',     'jicons-icons');
				break;
		}
		return $params;
	}
}
