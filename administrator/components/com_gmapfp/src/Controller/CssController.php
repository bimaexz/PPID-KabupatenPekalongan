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

use Joomla\CMS\MVC\Controller\AdminController;

class CssController extends AdminController
{
	protected $text_prefix = 'COM_GMAPFP_CSS';

	public function getModel($name = 'Css', $prefix = 'Administrator', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}
	
	public function saveCss()
	{
		// Check for request forgeries.
		$this->checkToken();

		$model = $this->getModel();

		// Change the state of the records.
		if (!$model->saveCss())
		{
			$this->app->enqueueMessage($model->getError(), 'warning');
		}
		else
		{
			$this->setMessage(\JText::_('COM_GMAPFP_UPDATE_OK'));
		}

		$this->setRedirect('index.php?option=com_gmapfp&view=css');
	}
}
