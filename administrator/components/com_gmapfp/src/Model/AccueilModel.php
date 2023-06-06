<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\GMapFP\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\String\PunycodeHelper;
use Joomla\Component\Categories\Administrator\Helper\CategoriesHelper;
use Joomla\Database\ParameterType;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Component\ComponentHelper;

class AccueilModel extends AdminModel
{
	public $typeAlias = 'com_gmapfp.accueil';

	public function getForm($data = array(), $loadData = true)
	{
		return false;
	}

	function getPublishedTabs() {
	
        $lang = Factory::getLanguage(); 
        $tag_lang=(substr($lang->getTag(),0,2)); 

		$params = ComponentHelper::getParams('com_gmapfp');

		$tabs = array();

		$onglet = new \stdClass();
		if ($tag_lang=='fr'){
			$onglet->title = 'GMapFP c\'est aussi : ';
		} else {
			$onglet->title = 'GMapFP is also: ';
		}
		$onglet->name = 'GMapFP';
		$onglet->alert = true;
		$tabs[] = $onglet;

		if ($params->get('gmapfp_news', 1)) {
			$onglet = new \stdClass();
			$onglet->title = 'News';
			$onglet->name = 'News';
			$onglet->alert = false;
			$tabs[] = $onglet;
		}

		return $tabs;
	}
}
