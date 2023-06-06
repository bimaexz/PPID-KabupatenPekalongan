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

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Router\Route;
use Joomla\Input\Input;
use Joomla\Utilities\ArrayHelper;

class ItemsController extends AdminController
{
	protected $text_prefix = 'GMAPFP';

	public function __construct($config = array(), MVCFactoryInterface $factory = null, $app = null, $input = null)
	{
		parent::__construct($config, $factory, $app, $input);

		$this->registerTask('unfeatured', 'featured');
	}

	public function featured()
	{
		// Check for request forgeries
		$this->checkToken();

		$user   = $this->app->getIdentity();
		$ids    = $this->input->get('cid', array(), 'array');
		$values = array('featured' => 1, 'unfeatured' => 0);
		$task   = $this->getTask();
		$value  = ArrayHelper::getValue($values, $task, 0, 'int');

		// Access checks.
		foreach ($ids as $i => $id)
		{
			if (!$user->authorise('core.edit.state', 'com_gmapfp.item.' . (int) $id))
			{
				// Prune items that you can't change.
				unset($ids[$i]);
				$this->app->enqueueMessage(Text::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'), 'notice');
			}
		}

		if (empty($ids))
		{
			$this->app->enqueueMessage(Text::_('JERROR_NO_ITEMS_SELECTED'), 'error');
		}
		else
		{
			// Get the model.
			/** @var \Joomla\Component\Content\Administrator\Model\ArticleModel $model */
			$model = $this->getModel();

			// Publish the items.
			if (!$model->featured($ids, $value))
			{
				$this->app->enqueueMessage($model->getError(), 'error');
			}

			if ($value == 1)
			{
				$message = Text::plural('COM_GMAPFP_N_ITEMS_FEATURED', count($ids));
			}
			else
			{
				$message = Text::plural('COM_GMAPFP_N_ITEMS_UNFEATURED', count($ids));
			}
		}

		$this->setRedirect(Route::_('index.php?option=com_gmapfp&view=items', false), $message);
	}

	public function getModel($name = 'Item', $prefix = 'Administrator', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function getQuickiconGmapfp()
	{
		$model = $this->getModel('items');

		$model->setState('filter.published', 1);

		$amount = (int) $model->getTotal();

		$result = [];

		$result['amount'] = $amount;
		$result['sronly'] = Text::plural('COM_GMAPFP_N_QUICKICON_SRONLY', $amount);
		$result['name'] = Text::plural('COM_GMAPFP_N_QUICKICON', $amount);

		echo new JsonResponse($result);
	}
}
