<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\FormModel;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Database\ParameterType;
use Joomla\Database\QueryInterface;
use Joomla\Registry\Registry;

class EmailModel extends FormModel
{
	protected $view_item = 'email';
	protected $_item = null;
	protected $_context = 'com_gmapfp.email';

	protected function populateState()
	{
		/** @var SiteApplication $app */
		$app = Factory::getContainer()->get(SiteApplication::class);

		if (\JFactory::getApplication()->isClient('api'))
		{
			// TODO: remove this
			$app->loadLanguage();
			$this->setState('email.id', \JFactory::getApplication()->input->post->getInt('id'));
		}
		else
		{
			$this->setState('email.id', $app->input->getInt('id'));
		}

		$this->setState('params', $app->getParams());
	}

	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm('com_gmapfp.email', 'email', array('control' => 'jform', 'load_data' => true));

		if (empty($form))
		{
			return false;
		}

		$params = clone $this->getState('params');

		if (!$params->get('show_email_copy', 0))
		{
			$form->removeField('email_copy');
		}

		return $form;
	}

	protected function loadFormData()
	{
		$data = (array) Factory::getApplication()->getUserState('com_gmapfp.email.data', array());

		if (empty($data['language']) && Multilanguage::isEnabled())
		{
			$data['language'] = Factory::getLanguage()->getTag();
		}

		$this->preprocessData('com_gmapfp.email', $data);

		return $data;
	}

	public function getItem($pk = null)
	{
		$pk = (!empty($pk)) ? $pk : (int) $this->getState('email.id');

		try
		{
			$db = $this->getDbo();
			$query = $db->getQuery(true)
				->select(
					$this->getState(
						'item.select', 'a.*'
					)
				);
			$query->from('#__gmapfp AS a')
				->where('a.id = ' . (int) $pk);

			// Join on category table.
			$query->select('c.title AS category_title, c.alias AS category_alias, c.access AS category_access,' .
				'c.language AS category_language'
			)
				->innerJoin('#__categories AS c on c.id = a.catid')
				->where('c.published > 0');

			// Join on user table.
			$query->select('u.name AS author')
				->join('LEFT', '#__users AS u on u.id = a.created_by');

			$db->setQuery($query);
			$data = $db->loadObject();

			if (empty($data))
			{
				throw new \Exception(Text::_('COM_GMAPFP_ERROR_ITEM_NOT_FOUND'), 404);
			}

			$data->params = clone $this->getState('params');
		}
		catch (\Exception $e)
		{
			if ($e->getCode() == 404)
			{
				// Need to go through the error handler to allow Redirect to work.
				throw new \Exception($e->getMessage(), 404);
			}
			else
			{
				$this->setError($e);
				$data = false;
			}
		}

		return $data;
	}

}
