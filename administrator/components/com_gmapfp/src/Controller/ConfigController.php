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

use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Router\Route;
use Joomla\Utilities\ArrayHelper;

class ConfigController extends FormController
{
	protected $text_prefix = 'COM_GMAPFP_CONFIG';

	public function save($key = null, $urlVar = null)
	{
		// Check for request forgeries.
		$this->checkToken();

		$model = $this->getModel();
		$data  = $this->input->post->get('jform', array(), 'array');
		$model->save($data);
		
		$plug_name = $this->input->get('plug_name');
		$plug_type = $this->input->get('plug_type');
		$url = 'index.php?option=com_gmapfp&view=config&layout=edit&tmpl=components&plug_type=' . $plug_type . '&plug_name=' . $plug_name;
		$this->setRedirect(Route::_($url, false));
	}
}
