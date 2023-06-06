<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Plugin\PluginHelper;

class DisplayController extends BaseController
{
	protected $default_view = 'accueil';

	public function display($cachable = false, $urlparams = array())
	{

		// charge les fichiers de langue des plugins GMapFP.
		$language = Factory::getLanguage();
		$gmapfp_plugins = PluginHelper::getPlugin('gmapfp-map');
		foreach($gmapfp_plugins as $gmapfp_plugin) {
			$language->load('plg_gmapfp-map_'.$gmapfp_plugin->name);
		}
		$gmapfp_plugins = PluginHelper::getPlugin('gmapfp-geocoding');
		foreach($gmapfp_plugins as $gmapfp_plugin) {
			$language->load('plg_gmapfp-geocoding_'.$gmapfp_plugin->name);
		}

		$view   = $this->input->get('view', $this->default_view);
		$layout = $this->input->get('layout', 'default');
		$id     = $this->input->getInt('id');

		// Check for edit form.
		if ($view == 'gmapfp' && $layout == 'edit' && !$this->checkEditId('com_gmapfp.edit.gmapfp', $id))
		{
			// Somehow the person just went to the form - we don't allow that.
			$this->setMessage(\JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id), 'error');
			$this->setRedirect(\JRoute::_('index.php?option=com_gmapfp&view=gmapfps', false));

			return false;
		}

		return parent::display();
	}
}
