<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_2F
	* Creation date: Juillet 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Table\Table;

class AjaxController extends BaseController
{

	public function getlatlng()
	{
		// Check for request forgeries.
		// $this->checkToken();
		
		$app	= Factory::getApplication();
		$model  = $this->getModel('ajax');

		$input = $app->input;

		$results = null;

		$add1 = $input->get('add1', '', 'raw');
		$add2 = $input->get('add2', '', 'raw');
		$cp = $input->get('cp', '', 'raw');
		$ville = $input->get('ville', '', 'raw');
		$departement = $input->get('departement', '', 'raw');
		$pays = $input->get('pays', '', 'raw');
		
		$results = $model->getlatlng($add1, $add2, $cp, $ville, $departement, $pays);
	
		// Return the results in the desired format
		echo new JsonResponse($results, null, false, $input->get('ignoreMessages', true, 'bool'));
		
		$app->close();
	}
	
	public function getnews()
	{
		$app	= Factory::getApplication();
		$model  = $this->getModel('ajax');
		$result = $model->Infos_News();
		echo $result;
		
		$app->close();
	}
}
