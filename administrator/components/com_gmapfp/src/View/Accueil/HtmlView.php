<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_2F
	* Creation date: Juillet 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Administrator\View\Accueil;

defined('_JEXEC') or die;

use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\Component\Gmapfp\Administrator\Model\GmapfpModel;
use Joomla\Registry\Registry;

class HtmlView extends BaseHtmlView
{
	protected $categories;
	protected $items;
	protected $pagination;
	protected $state;

	public function display($tpl = null)
	{
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		return parent::display($tpl);
	}

	/**
	 * GMapFP c'est aussi
	 */
	function Infos_GMapFP(){
        $lang = Factory::getLanguage(); 
        $tag_lang=(substr($lang->getTag(),0,2)); 

		if ($tag_lang=='fr'){
			$output = '<div style="padding: 5px;">';
			$output .= "Une Galerie d'image : <a target='_blank' href='https://joomla-slideshow.com/fr/'>https://joomla-slideshow.com/fr/</a><br/>";
			$output .= "Une playlist audio : <a target='_blank' href='https://joomla-playlist.com/fr/'>https://joomla-playlist.com/fr/</a><br/>";
			$output .= "Un livre intéractif : <a target='_blank' href='https://www.joomla-flippingbook.com/fr/'>https://www.joomla-flippingbook.com/fr/</a><br/>";
			$output .= "Des cartes vectoriels : <a target='_blank' href='https://cartes-cliquables-joomla.gmapfp.org/fr/'>https://cartes-cliquables-joomla.gmapfp.org/fr/</a><br/>";
			$output .= "Un portail famille pour Joomla : <a target='_blank' href='https://www.portail-famille-joomla.fr/'>https://www.portail-famille-joomla.fr/</a><br/>";
			$output .= '</div>';
		} else {
			$output = '<div style="padding: 5px;">';
			$output .= "An image gallery : <a target='_blank' href='https://joomla-slideshow.com/en/'>https://joomla-slideshow.com/en/</a><br/>";
			$output .= "An audio playlist : <a target='_blank' href='https://joomla-playlist.com/en/'>https://joomla-playlist.com/en/</a><br/>";
			$output .= "A flipping book : <a target='_blank' href='https://www.joomla-flippingbook.com/'>https://www.joomla-flippingbook.com/</a><br/>";
			$output .= "Vector maps : <a target='_blank' href='https://cartes-cliquables-joomla.gmapfp.org/en/'>https://cartes-cliquables-joomla.gmapfp.org/en/</a><br/>";
			$output .= '</div>';
		}
		return $output;
	}
	
	/**
	 * Donation pour GMapFP
	 */
	function Infos_Donation(){

		$mainframe  = Factory::getApplication(); 
		$lang		= Factory::getLanguage();
		$langue		= $lang->getTag();
		$langue=str_replace('-','_',$langue);
		
		$template	= $mainframe->getTemplate();
		$tag_lang=(substr($lang->getTag(),3,2)); 
	
		$output = '<div style="padding: 5px;">';
		$output .= '<span style="font-size:120%;">'.Text::_('COM_GMAPFP_EXPLICATION_DONATION');
		$output .= '<br /><span style="color:#0000FF; font-size:170%; font-weight:bold;">'.Text::_('COM_GMAPFP_SOMME_DONT').'</span>';
		$output .= Text::_('COM_GMAPFP_EXPLICATION2_DONATION').'</span>';
		$output .= '<br /><br /><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=f_pelletier%40yahoo%2ecom&currency_code=EUR&lc="'.$tag_lang.'&item_name=Donation%20for%20GMapFP%20services&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHostedGuest"><img src="https://www.paypal.com/'.$langue.'/i/btn/btn_donate_SM.gif">
                        </a><br /><br /><br />';
		$output .= '</div>';
		return $output;
	}

	/**
	 * News du site de GMapFP
	 */
	public function Infos_News() {
		return '<div class="gmapfp_news" id="gmapfp_news"><img style="width:80px;" src="../media/com_gmapfp/images/loading.gif">'.Text::_('COM_GMAPFP_WAIT_UPDATE_NEWS').'</div>';
	}

}
