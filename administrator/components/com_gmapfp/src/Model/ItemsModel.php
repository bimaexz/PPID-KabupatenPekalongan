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
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Table\Table;
use Joomla\Utilities\ArrayHelper;

class ItemsModel extends ListModel
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'alias', 'a.alias',
				'state', 'a.state',
				'access', 'a.access', 'access_level',
				'featured', 'a.featured',
				'ville', 'a.ville',
				'departement', 'a.departement',
				'pays', 'a.pays',
				'auteur', 'u.name',
				'ordering', 'a.ordering',
				'language', 'a.language',
				'hits', 'a.hits',
				'catid', 'a.catid', 'category_title',
				'checked_out', 'a.checked_out',
				'created_by', 'a.created_by',
				'author_id',
				'tag',
			);
		}

		parent::__construct($config);
	}

	public function &getCategoryOrders()
	{
		if (!isset($this->cache['categoryorders']))
		{
			$db = $this->getDbo();
			$query = $db->getQuery(true)
				->select('MAX(ordering) as ' . $db->quoteName('max') . ', catid')
				->select('catid')
				->from('#__gmapfp')
				->group('catid');
			$db->setQuery($query);
			$this->cache['categoryorders'] = $db->loadAssocList('catid', 0);
		}

		return $this->cache['categoryorders'];
	}

	protected function getListQuery()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id AS id,'
				. 'a.title AS title,'
				. 'a.ville AS ville,'
				. 'a.departement AS departement,'
				. 'a.pays AS pays,'
				. 'u.name AS auteur,'
				. 'a.alias AS alias,'
				. 'a.checked_out AS checked_out, a.checked_out_time,'
				. 'a.catid AS catid,'
				. 'a.state AS state,'
				. 'a.featured AS featured,'
				. 'a.note AS note,'
				. 'a.language AS language,'
				. 'a.created_by,'
				. 'a.publish_up,a.publish_down,'
				. 'a.created,'
				. 'a.hits AS hits,'
				// . 'a.access_level,'
				. 'a.ordering AS ordering'
			)
		);
		$query->from($db->quoteName('#__gmapfp', 'a'));

		// Join over the language
		$query->select('l.title AS language_title, l.image AS language_image')
			->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = a.language');
		// Join over the users for autor
		$query->select('u.name AS auteur, u.email AS auteur_mail')
			->join('LEFT', $db->quoteName('#__users', 'u') . ' ON u.id = a.created_by');
		// Join over the users for the checked out user.
		$query->select('uc.name AS editor')
			->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
			// Join over the categories.
		// Join over the asset groups.
		$query->select('ag.title AS access_level')
			->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');
		$query->select('c.title AS category_title, c.created_user_id AS category_uid, c.level AS category_level')
			->join('LEFT', '#__categories AS c ON c.id = a.catid');
		// Join over the parent categories.
		$query->select(
			'parent.title AS parent_category_title, parent.id AS parent_category_id,' .
			'parent.created_user_id AS parent_category_uid, parent.level AS parent_category_level'
		)
			->join('LEFT', '#__categories AS parent ON parent.id = c.parent_id');

		// Filter by state
		$state = (string) $this->getState('filter.state');

		if (is_numeric($state))
		{
			$query->where($db->quoteName('a.state') . ' = ' . (int) $state);
		}
		elseif ($state === '')
		{
			$query->where($db->quoteName('a.state') . ' IN (0, 1)');
		}

		// Filter by categories and by level
		$categoryId = $this->getState('filter.catid', array());
		$level = $this->getState('filter.level');

		if (is_array($categoryId) and array_search(0, $categoryId) !== false) unset($categoryId[array_search(0, $categoryId)]); // supprime la valeur none
		if (!is_array($categoryId))
		{
			$categoryId = $categoryId ? array($categoryId) : array();
		}

		// Case: Using both categories filter and by level filter
		if (count($categoryId))
		{
			$categoryId = ArrayHelper::toInteger($categoryId);
			$categoryTable = Table::getInstance('Category', 'JTable');
			$subCatItemsWhere = array();

			foreach ($categoryId as $filter_catid)
			{
				$categoryTable->load($filter_catid);
				$subCatItemsWhere[] = '(' .
					($level ? 'c.level <= ' . ((int) $level + (int) $categoryTable->level - 1) . ' AND ' : '') .
					'c.lft >= ' . (int) $categoryTable->lft . ' AND ' .
					'c.rgt <= ' . (int) $categoryTable->rgt . ')';
			}

			$query->where(implode(' OR ', $subCatItemsWhere));
		}

		// Filter by search in title.
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			elseif (stripos($search, 'author:') === 0)
			{
				$search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
				$query->where('(u.name LIKE ' . $search . ' OR u.username LIKE ' . $search . ')');
			}
			elseif (stripos($search, 'content:') === 0)
			{
				$search = $db->quote('%' . $db->escape(substr($search, 8), true) . '%');
				$query->where('(a.introtext LIKE ' . $search . ' OR a.fulltext LIKE ' . $search . ')');
			}
			else
			{
				$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
				$query->where('(a.title LIKE ' . $search . ' OR a.alias LIKE ' . $search . ' OR a.note LIKE ' . $search . ')');
			}
		}

		// Filter on the ville.
		if ($ville = $this->getState('filter.ville'))
		{
			$query->where($db->quoteName('a.ville') . ' = ' . $db->quote($ville));
		}

		// Filter on the departement.
		if ($departement = $this->getState('filter.departement'))
		{
			$query->where($db->quoteName('a.departement') . ' = ' . $db->quote($departement));
		}

		// Filter on the pays.
		if ($pays = $this->getState('filter.pays'))
		{
			$query->where($db->quoteName('a.pays') . ' = ' . $db->quote($pays));
		}

		// Filter by author
		$authorId = $this->getState('filter.author_id');
		if (is_array($authorId) and array_search(0, $authorId) !== false) 
			unset($authorId[array_search(0, $authorId)]); // supprime la valeur none
		if (is_numeric($authorId))
		{
			$type = $this->getState('filter.userid.include', true) ? '= ' : '<>';
			$query->where('a.created_by ' . $type . (int) $authorId);
		}
		elseif (is_array($authorId) and !empty($authorId))
		{
			$authorId = ArrayHelper::toInteger($authorId);
			$authorId = implode(',', $authorId);
			$query->where('a.created_by IN (' . $authorId . ')');
		}

		// Filter on the language.
		if ($language = $this->getState('filter.language'))
		{
			$query->where('a.language = ' . $db->quote($language));
		}

		// Filter by a single or group of tags.
		$tag = $this->getState('filter.tag');
		// Run simplified query when filtering by one tag.
		if (\is_array($tag) && \count($tag) === 1)
		{
			$tag = $tag[0];
		}

		if ($tag && \is_array($tag))
		{
			$tag = ArrayHelper::toInteger($tag);

			$subQuery = $db->getQuery(true)
				->select('DISTINCT ' . $db->quoteName('content_item_id'))
				->from($db->quoteName('#__contentitem_tag_map'))
				->where(
					[
						$db->quoteName('tag_id') . ' IN (' . implode(',', $query->bindArray($tag)) . ')',
						$db->quoteName('type_alias') . ' = ' . $db->quote('com_gmapfp.item'),
					]
				);

			$query->join(
				'INNER',
				'(' . $subQuery . ') AS ' . $db->quoteName('tagmap'),
				$db->quoteName('tagmap.content_item_id') . ' = ' . $db->quoteName('a.id')
			);
		}
		elseif ($tag = (int) $tag)
		{
			$query->join(
				'INNER',
				$db->quoteName('#__contentitem_tag_map', 'tagmap'),
				$db->quoteName('tagmap.content_item_id') . ' = ' . $db->quoteName('a.id')
			)
				->where(
					[
						$db->quoteName('tagmap.tag_id') . ' = :tag',
						$db->quoteName('tagmap.type_alias') . ' = ' . $db->quote('com_gmapfp.item'),
					]
				)
				->bind(':tag', $tag, ParameterType::INTEGER);
		}

		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', 'a.title');
		$orderDirn = $this->state->get('list.direction', 'ASC');

		if ($orderCol == 'a.ordering' || $orderCol == 'category_title')
		{
			$orderCol = $db->quoteName('c.title') . ' ' . $orderDirn . ', ' . $db->quoteName('a.ordering');
		}

		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

		return $query;
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');
		$id .= ':' . $this->getState('filter.featured');
		$id .= ':' . serialize($this->getState('filter.catid'));
		$id .= ':' . $this->getState('filter.ville');
		$id .= ':' . $this->getState('filter.departement');
		$id .= ':' . $this->getState('filter.pays');
		$id .= ':' . serialize($this->getState('filter.author_id'));
		$id .= ':' . $this->getState('filter.language');
		$id .= ':' . serialize($this->getState('filter.tag'));

		return parent::getStoreId($id);
	}

	public function getTable($type = 'Item', $prefix = 'Administrator', $config = array())
	{
		return parent::getTable($type, $prefix, $config);
	}

	protected function populateState($ordering = 'a.title', $direction = 'asc')
	{
		$app = Factory::getApplication();

		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$state = $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '');
		$this->setState('filter.state', $state);

		$featured = $this->getUserStateFromRequest($this->context . '.filter.featured', 'filter_featured', '');
		$this->setState('filter.featured', $featured);

		$ville = $this->getUserStateFromRequest($this->context . '.filter.ville', 'filter_ville');
		$this->setState('filter.ville', $ville);

		$departement = $this->getUserStateFromRequest($this->context . '.filter.departement', 'filter_departement', '');
		$this->setState('filter.departement', $departement);

		$pays = $this->getUserStateFromRequest($this->context . '.filter.pays', 'filter_pays', '');
		$this->setState('filter.pays', $pays);

		$language = $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '');
		$this->setState('filter.language', $language);

		$formSubmited = $app->input->post->get('form_submited');

		$authorId   = $this->getUserStateFromRequest($this->context . '.filter.author_id', 'filter_author_id');
		$categoryId = $this->getUserStateFromRequest($this->context . '.filter.catid', 'catid');
		$tag        = $this->getUserStateFromRequest($this->context . '.filter.tag', 'filter_tag', '');

		if ($formSubmited)
		{
			$authorId = $app->input->post->get('author_id');
			$this->setState('filter.author_id', $authorId);

			$categoryId = $app->input->post->get('catid');
			$this->setState('filter.catid', $categoryId);

			$tag = $app->input->post->get('tag');
			$this->setState('filter.tag', $tag);
		}

		// List state information.
		parent::populateState($ordering, $direction);
	}

	public function getItems()
	{
		$items = parent::getItems();

		foreach ($items as $item)
		{
			$item->typeAlias = 'com_gmapfp.item';
		}

		return $items;
	}
}
