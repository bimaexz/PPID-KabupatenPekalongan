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

class CSSModel extends AdminModel
{
	public $typeAlias = 'com_gmapfp.css';

	public function getForm($data = array(), $loadData = true)
	{
		return false;
	}

	function saveCss()
	{	
		$app 		= Factory::getApplication(); 
		$file 		= '../media/com_gmapfp/css/gmapfp.css';
		$csscontent	= $app->input->get('csscontent', '', 'raw');

		if( $fp = @fopen( $file, 'w' )) {
			fputs( $fp, $csscontent );
			fclose( $fp );
			return true;
		}else{
			return false;
		}
	}
}
