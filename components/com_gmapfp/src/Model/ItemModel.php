<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_7F
	* Creation date: Mai 2022
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\ItemModel as JoomlaItemModel;
use Joomla\Component\Gmapfp\Administrator\Extension\GmapfpComponent;
use Joomla\Registry\Registry;

class ItemModel extends JoomlaItemModel
{
	protected $_context = 'com_gmapfp.item';

	protected function populateState()
	{
		$app = Factory::getApplication();

		// Load state from the request.
		$pk = $app->input->getInt('id');
		$this->setState('item.id', $pk);

		$offset = $app->input->getUInt('limitstart');
		$this->setState('list.offset', $offset);

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

		$user = Factory::getUser();

		// If $pk is set then authorise on complete asset, else on component only
		$asset = empty($pk) ? 'com_gmapfp' : 'com_gmapfp.item.' . $pk;

		if ((!$user->authorise('core.edit.state', $asset)) && (!$user->authorise('core.edit', $asset)))
		{
			$this->setState('filter.published');
			$this->setState('filter.archived');
		}

		$this->setState('filter.language', Multilanguage::isEnabled());
	}

	public function getItem($pk = null)
	{
		$user = Factory::getUser();

		$pk = (!empty($pk)) ? $pk : (int) $this->getState('item.id');

		if ($this->_item === null)
		{
			$this->_item = array();
		}

		if (!isset($this->_item[$pk]))
		{
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

				// Filter by language
				if ($this->getState('filter.language'))
				{
					$query->where('a.language in (' . $db->quote(Factory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
				}

				// Join over the categories to get parent category titles
				$query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route,' .
					'parent.alias as parent_alias, parent.language as parent_language'
				)
					->join('LEFT', '#__categories as parent ON parent.id = c.parent_id');

				if (!$user->authorise('core.edit.state', 'com_gmapfp.item.' . $pk)
					&& !$user->authorise('core.edit', 'com_gmapfp.item.' . $pk)
				)
				{
					// Filter by start and end dates.
					$date = Factory::getDate();

					$nowDate = $db->quote($date->toSql());

					$query->where('(a.publish_up ="0000-00-00 00:00:00" OR a.publish_up IS NULL OR a.publish_up <= ' . $nowDate . ')')
						->where('(a.publish_down ="0000-00-00 00:00:00" OR a.publish_down IS NULL OR a.publish_down >= ' . $nowDate . ')');
				}

				// Filter by published state.
				$published = $this->getState('filter.published');
				$archived = $this->getState('filter.archived');

				$db->setQuery($query);

				$data = $db->loadObject();

				if (empty($data))
				{
					throw new \Exception(Text::_('COM_GMAPFP_ERROR_ITEM_NOT_FOUND'), 404);
				}

				$data->params = clone $this->getState('params');

				$data->metadata = new Registry($data->metadata);

				// Technically guest could edit an article, but lets not check that to improve performance a little.
				if (!$user->get('guest'))
				{
					$userId = $user->get('id');
					$asset = 'com_gmapfp.item.' . $data->id;

					// Check general edit permission first.
					if ($user->authorise('core.edit', $asset))
					{
						$data->params->set('access-edit', true);
					}

					// Now check if edit.own is available.
					elseif (!empty($userId) && $user->authorise('core.edit.own', $asset))
					{
						// Check for a valid user and that they are the owner.
						if ($userId == $data->created_by)
						{
							$data->params->set('access-edit', true);
						}
					}
				}

				// Compute view access permissions.
				if ($access = $this->getState('filter.access'))
				{
					// If the access filter has been set, we already know this user can view.
					$data->params->set('access-view', true);
				}
				else
				{
					// If no access filter is set, the layout takes some responsibility for display of limited information.
					$user = Factory::getUser();
					$groups = $user->getAuthorisedViewLevels();

					if ($data->catid == 0 || $data->category_access === null)
					{
						$data->params->set('access-view', in_array($data->access, $groups));
					}
					else
					{
						$data->params->set('access-view', in_array($data->access, $groups) && in_array($data->category_access, $groups));
					}
				}

				$this->_item[$pk] = $data;
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
					$this->_item[$pk] = false;
				}
			}
		}

		return $this->_item[$pk];
	}

	public function hit($pk = 0)
	{
		$input = Factory::getApplication()->input;
		$hitcount = $input->getInt('hitcount', 1);

		if ($hitcount)
		{
			$pk = (!empty($pk)) ? $pk : (int) $this->getState('item.id');

			$table = $this->getTable('Item', 'Table');
			$table->load($pk);
			$table->hit($pk);
		}

		return true;
	}

	protected function cleanCache($group = null, $clientId = 0)
	{
		parent::cleanCache('com_gmapfp');
		parent::cleanCache('mod_items_archive');
		parent::cleanCache('mod_items_categories');
		parent::cleanCache('mod_items_category');
		parent::cleanCache('mod_items_latest');
		parent::cleanCache('mod_items_news');
		parent::cleanCache('mod_items_popular');
	}
}
