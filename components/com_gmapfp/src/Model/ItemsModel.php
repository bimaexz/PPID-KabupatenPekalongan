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

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Component\Gmapfp\Administrator\Extension\GmapfpComponent;
use Joomla\Component\Gmapfp\Site\Helper\AssociationHelper;
use Joomla\Registry\Registry;
use Joomla\String\StringHelper;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\HTML\HTMLHelper;

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
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'catid', 'a.catid', 'category_title',
				'state', 'a.state',
				'stage_condition', 'ws.condition',
				'access', 'a.access', 'access_level',
				'created', 'a.created',
				'created_by', 'a.created_by',
				'ordering', 'a.ordering',
				'featured', 'a.featured',
				'language', 'a.language',
				'hits', 'a.hits',
				'publish_up', 'a.publish_up',
				'publish_down', 'a.publish_down',
				'images', 'a.images',
				'urls', 'a.urls',
				'filter_tag',
			);
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = 'ordering', $direction = 'ASC')
	{
		$app = Factory::getApplication();

		// List state information
		$value = $app->input->get('limit', $app->get('list_limit', 0), 'uint');
		$this->setState('list.limit', $value);

		$value = $app->input->get('limitstart', 0, 'uint');
		$this->setState('list.start', $value);

		$value = $app->input->get('filter_tag', 0, 'uint');
		$this->setState('filter.tag', $value);

		$orderCol = $app->input->get('filter_order', 'a.ordering');

		if (!in_array($orderCol, $this->filter_fields))
		{
			$orderCol = 'a.ordering';
		}

		$this->setState('list.ordering', $orderCol);

		$listOrder = $app->input->get('filter_order_Dir', 'ASC');

		if (!in_array(strtoupper($listOrder), array('ASC', 'DESC', '')))
		{
			$listOrder = 'ASC';
		}

		$this->setState('list.direction', $listOrder);

		$params = $app->getParams();
		$this->setState('params', $params);
		$user = Factory::getUser();

		if ((!$user->authorise('core.edit.state', 'com_gmapfp')) && (!$user->authorise('core.edit', 'com_gmapfp')))
		{
			// Filter on published for those who do not have edit or edit.state rights.
			$this->setState('filter.condition', GmapfpComponent::CONDITION_PUBLISHED);
		}

		$this->setState('filter.language', Multilanguage::isEnabled());

		// Process show_noauth parameter
		if ((!$params->get('show_noauth')) || (!ComponentHelper::getParams('com_gmapfp')->get('show_noauth')))
		{
			$this->setState('filter.access', true);
		}
		else
		{
			$this->setState('filter.access', false);
		}

		$this->setState('layout', $app->input->getString('layout'));
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . serialize($this->getState('filter.condition'));
		$id .= ':' . $this->getState('filter.access');
		$id .= ':' . $this->getState('filter.featured');
		$id .= ':' . serialize($this->getState('filter.item_id'));
		$id .= ':' . $this->getState('filter.item_id.include');
		$id .= ':' . serialize($this->getState('filter.ids'));
		$id .= ':' . $this->getState('filter.ids.include');
		$id .= ':' . serialize($this->getState('filter.category_id'));
		$id .= ':' . $this->getState('filter.category_id.include');
		$id .= ':' . serialize($this->getState('filter.author_id'));
		$id .= ':' . $this->getState('filter.author_id.include');
		$id .= ':' . serialize($this->getState('filter.author_alias'));
		$id .= ':' . $this->getState('filter.author_alias.include');
		$id .= ':' . $this->getState('filter.date_filtering');
		$id .= ':' . $this->getState('filter.date_field');
		$id .= ':' . $this->getState('filter.start_date_range');
		$id .= ':' . $this->getState('filter.end_date_range');
		$id .= ':' . $this->getState('filter.relative_date');
		$id .= ':' . serialize($this->getState('filter.tag'));

		return parent::getStoreId($id);
	}

	protected function getListQuery()
	{
		// Get the current user for authorisation checks
		$user 	= Factory::getUser();
		$input  = Factory::getApplication()->input;

		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);
		
		if($input->getInt('map', 0) != 1) { //données pour les affichages
			$datas =
				'a.id, a.title, a.alias, a.introtext, a.fulltext, ' .
				'a.adresse, a.adresse2, a.ville, a.departement, a.codepostal, a.pays, ' .
				'a.tel, a.email, a.web, a.link, a.glat, a.glng, a.horaires_prix, ' .
				'a.checked_out, a.checked_out_time, a.state,' .
				'a.catid, a.created, a.created_by, a.created_by_alias, ' .
				'a.modified, a.modified_by, uam.name as modified_by_name,' .
				// Use created if publish_up is null
				'CASE WHEN a.publish_up IS NULL THEN a.created ELSE a.publish_up END as publish_up,' .
				'a.publish_down, a.img, a.attribs, a.metadata, a.metakey, a.metadesc, a.access, ' .
				'a.hits, a.featured, a.language, ' . $query->length('a.fulltext') . ' AS readmore, a.ordering';
		} else { //donnés pour la carte
			$datas =
				'a.id, a.title, a.alias, a.introtext, ' .
				'a.adresse, a.adresse2, a.ville, a.departement, a.codepostal, a.pays, ' .
				'a.tel, a.email, a.web, a.link, a.article_id, a.icon, ' .
				'a.catid, a.glat, a.glng, a.gzoom, a.marqueur, ' .
				'a.img, a.hits, a.language ';
		}

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				$datas
			)
		);

		$query->from('#__gmapfp AS a');

		$params      = $this->getState('params');
		$orderby_sec = $params->get('orderby_sec');

		// Join over the categories.
		$query->select('c.title AS category_title, c.path AS category_route, c.access AS category_access, c.alias AS category_alias,' .
			'c.language AS category_language'
		)
			->select('c.published, c.published AS parents_published, c.lft')
			->join('LEFT', '#__categories AS c ON c.id = a.catid');

		if($input->getInt('map', 0) != 1)
		// Join over the users for the author and modified_by names.
		$query->select("CASE WHEN a.created_by_alias > ' ' THEN a.created_by_alias ELSE ua.name END AS author")
			->select('ua.email AS author_email')
			->join('LEFT', '#__users AS ua ON ua.id = a.created_by')
			->join('LEFT', '#__users AS uam ON uam.id = a.modified_by');

		if($input->getInt('map', 0) != 1)
		// Join over the categories to get parent category titles
		$query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias,' .
			'parent.language as parent_language'
		)
			->join('LEFT', '#__categories as parent ON parent.id = c.parent_id');

		// Filter by access level.
		if ($this->getState('filter.access', true))
		{
			$groups = implode(',', $user->getAuthorisedViewLevels());
			$query->where('a.access IN (' . $groups . ')')
				->where('c.access IN (' . $groups . ')');
		}

		// Filter by featured state
		$featured = $this->getState('filter.featured');

		switch ($featured)
		{
			case 'hide':
				$query->where('a.featured = 0');
				break;

			case 'only':
				$query->where('a.featured = 1');
				break;

			case 'show':
			default:
				// Normally we do not discriminate between featured/unfeatured items.
				break;
		}

		// Filter by a single or group of articles.
		$articleId = $this->getState('filter.article_id');

		if (is_numeric($articleId))
		{
			$type = $this->getState('filter.article_id.include', true) ? '= ' : '<> ';
			$query->where('a.id ' . $type . (int) $articleId);
		}
		elseif (is_array($articleId))
		{
			$articleId = ArrayHelper::toInteger($articleId);
			$articleId = implode(',', $articleId);
			$type      = $this->getState('filter.article_id.include', true) ? 'IN' : 'NOT IN';
			$query->where('a.id ' . $type . ' (' . $articleId . ')');
		}

		// Filter by a single or group of categories
		$categoryId = json_decode($this->getState('filter.category_id'));

		if (is_numeric($categoryId))
		{
			$type = $this->getState('filter.category_id.include', true) ? '= ' : '<> ';

			// Add subcategory check
			$includeSubcategories = $this->getState('filter.subcategories', false);
			$categoryEquals       = 'a.catid ' . $type . (int) $categoryId;

			if ($includeSubcategories)
			{
				$levels = (int) $this->getState('filter.max_category_levels', '1');

				// Create a subquery for the subcategory list
				$subQuery = $db->getQuery(true)
					->select('sub.id')
					->from('#__categories as sub')
					->join('INNER', '#__categories as this ON sub.lft > this.lft AND sub.rgt < this.rgt')
					->where('this.id = ' . (int) $categoryId);

				if ($levels >= 0)
				{
					$subQuery->where('sub.level <= this.level + ' . $levels);
				}

				// Add the subquery to the main query
				$query->where('(' . $categoryEquals . ' OR a.catid IN (' . (string) $subQuery . '))');
			}
			else
			{
				$query->where($categoryEquals);
			}
		}
		elseif (is_array($categoryId) && (count($categoryId) > 0))
		{
			$categoryId = ArrayHelper::toInteger($categoryId);
			$categoryId = implode(',', $categoryId);

			if (!empty($categoryId))
			{
				$type = $this->getState('filter.category_id.include', true) ? 'IN' : 'NOT IN';
				$query->where('a.catid ' . $type . ' (' . $categoryId . ')');
			}
		}

		// Filter by a single or group of categories
		$ids = json_decode($this->getState('filter.ids'));

		if (is_numeric($ids))
		{
			$type = $this->getState('filter.ids.include', true) ? '= ' : '<> ';

			// Add subcategory check
			$categoryEquals       = 'a.id ' . $type . (int) $ids;
			$query->where($categoryEquals);
		}
		elseif (is_array($ids) && (count($ids) > 0))
		{
			$ids = ArrayHelper::toInteger($ids);
			$ids = implode(',', $ids);

			if (!empty($ids))
			{
				$type = $this->getState('filter.ids.include', true) ? 'IN' : 'NOT IN';
				$query->where('a.id ' . $type . ' (' . $ids . ')');
			}
		}

		// Filter by author
		$authorId    = $this->getState('filter.author_id');
		$authorWhere = '';

		if (is_numeric($authorId))
		{
			$type        = $this->getState('filter.author_id.include', true) ? '= ' : '<> ';
			$authorWhere = 'a.created_by ' . $type . (int) $authorId;
		}
		elseif (is_array($authorId))
		{
			$authorId = array_filter($authorId, 'is_numeric');

			if ($authorId)
			{
				$authorId    = implode(',', $authorId);
				$type        = $this->getState('filter.author_id.include', true) ? 'IN' : 'NOT IN';
				$authorWhere = 'a.created_by ' . $type . ' (' . $authorId . ')';
			}
		}

		// Filter by author alias
		$authorAlias      = $this->getState('filter.author_alias');
		$authorAliasWhere = '';

		if (is_string($authorAlias))
		{
			$type             = $this->getState('filter.author_alias.include', true) ? '= ' : '<> ';
			$authorAliasWhere = 'a.created_by_alias ' . $type . $db->quote($authorAlias);
		}
		elseif (is_array($authorAlias))
		{
			$first = current($authorAlias);

			if (!empty($first))
			{
				foreach ($authorAlias as $key => $alias)
				{
					$authorAlias[$key] = $db->quote($alias);
				}

				$authorAlias = implode(',', $authorAlias);

				if ($authorAlias)
				{
					$type             = $this->getState('filter.author_alias.include', true) ? 'IN' : 'NOT IN';
					$authorAliasWhere = 'a.created_by_alias ' . $type . ' (' . $authorAlias .
						')';
				}
			}
		}

		if (!empty($authorWhere) && !empty($authorAliasWhere))
		{
			$query->where('(' . $authorWhere . ' OR ' . $authorAliasWhere . ')');
		}
		elseif (empty($authorWhere) && empty($authorAliasWhere))
		{
			// If both are empty we don't want to add to the query
		}
		else
		{
			// One of these is empty, the other is not so we just add both
			$query->where($authorWhere . $authorAliasWhere);
		}

		$nowDate  = $db->quote(Factory::getDate()->toSql());

		// Filter by start and end dates.
		if ((!$user->authorise('core.edit.state', 'com_gmapfp')) && (!$user->authorise('core.edit', 'com_gmapfp')))
		{
			$query->where('(a.publish_up ="0000-00-00 00:00:00" OR a.publish_up IS NULL OR a.publish_up <= ' . $nowDate . ')')
				->where('(a.publish_down ="0000-00-00 00:00:00" OR a.publish_down IS NULL OR a.publish_down >= ' . $nowDate . ')')
				->where('(a.state = 1)');
		}

		// Filter by Date Range or Relative Date
		$dateFiltering = $this->getState('filter.date_filtering', 'off');
		$dateField     = $this->getState('filter.date_field', 'a.created');

		switch ($dateFiltering)
		{
			case 'range':
				$startDateRange = $this->getState('filter.start_date_range', '');
				$endDateRange   = $this->getState('filter.end_date_range', '');

				if ($startDateRange || $endDateRange)
				{
					$query->where($dateField . ' IS NOT NULL');

					if ($startDateRange)
					{
						$query->where($dateField . ' >= ' . $db->quote($startDateRange));
					}

					if ($endDateRange)
					{
						$query->where($dateField . ' <= ' . $db->quote($endDateRange));
					}
				}

				break;

			case 'relative':
				$relativeDate = (int) $this->getState('filter.relative_date', 0);
				$query->where(
					$dateField . ' IS NOT NULL AND '
					. $dateField . ' >= ' . $query->dateAdd($nowDate, -1 * $relativeDate, 'DAY')
				);
				break;

			case 'off':
			default:
				break;
		}

		// Process the filter for list views with user-entered filters
		if (is_object($params) && ($params->get('filter_field') !== 'hide') && ($filter = $this->getState('list.filter')))
		{
			// Clean filter variable
			$filter      = StringHelper::strtolower($filter);
			$monthFilter = $filter;
			$hitsFilter  = (int) $filter;
			$filter      = $db->quote('%' . $db->escape($filter, true) . '%', false);

			switch ($params->get('filter_field'))
			{
				case 'author':
					$query->where(
						'LOWER( CASE WHEN a.created_by_alias > ' . $db->quote(' ') .
						' THEN a.created_by_alias ELSE ua.name END ) LIKE ' . $filter . ' '
					);
					break;

				case 'hits':
					$query->where('a.hits >= ' . $hitsFilter . ' ');
					break;

				case 'month':
					if ($monthFilter != '')
					{
						$query->where(
							$db->quote(date("Y-m-d", strtotime($monthFilter)) . ' 00:00:00')
							. ' <= CASE WHEN a.publish_up IS NULL THEN a.created ELSE a.publish_up END'
						);

						$query->where(
							$db->quote(date("Y-m-t", strtotime($monthFilter)) . ' 23:59:59')
							. ' >= CASE WHEN a.publish_up IS NULL THEN a.created ELSE a.publish_up END'
						);
					}
					break;

				case 'title':
				default:
					// Default to 'title' if parameter is not valid
					$query->where('LOWER( a.title ) LIKE ' . $filter);
					break;
			}
		}

		// Filter by language
		if ($this->getState('filter.language'))
		{
			$query->where('a.language IN (' . $db->quote(Factory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		}

		// Filter by a single or group of tags.
		$tagId = $this->getState('filter.tag');

		if (is_array($tagId) && count($tagId) === 1)
		{
			$tagId = current($tagId);
		}

		if (is_array($tagId))
		{
			$tagId = implode(',', ArrayHelper::toInteger($tagId));

			if ($tagId)
			{
				$subQuery = $db->getQuery(true)
					->select('DISTINCT content_item_id')
					->from($db->quoteName('#__contentitem_tag_map'))
					->where('tag_id IN (' . $tagId . ')')
					->where('type_alias = ' . $db->quote('com_content.article'));

				$query->innerJoin('(' . (string) $subQuery . ') AS tagmap ON tagmap.content_item_id = a.id');
			}
		}
		elseif ($tagId)
		{
			$query->innerJoin(
				$db->quoteName('#__contentitem_tag_map', 'tagmap')
				. ' ON tagmap.tag_id = ' . (int) $tagId
				. ' AND tagmap.content_item_id = a.id'
				. ' AND tagmap.type_alias = ' . $db->quote('com_content.article')
			);
		}

		// Add the list ordering clause.
		$query->order($this->getState('list.ordering', 'a.ordering') . ' ' . $this->getState('list.direction', 'ASC'));

		return $query;
	}

	public function getItems()
	{
		$items  = parent::getItems();
		$user   = Factory::getUser();
		$userId = $user->get('id');
		$guest  = $user->get('guest');
		$groups = $user->getAuthorisedViewLevels();
		$input  = Factory::getApplication()->input;

		// Get the global params
		$globalParams = ComponentHelper::getParams('com_gmapfp', true);

		// Convert the parameter fields into objects.
		if($input->getInt('map', 0) != 1 OR ($input->getInt('map', 0) == 1 AND ($globalParams->get('affichage',0) == 0 OR $globalParams->get('affichage',0) == 2) AND ($globalParams->get('gmapfp_taille_bulle_cesure',200) OR $globalParams->get('gmapfp_html_bubble',0))))
		foreach ($items as &$item)
		{
			//truncate et supprime le code html du text d'intro pour la bubble
			if($globalParams->get('gmapfp_taille_bulle_cesure',200)) {
				$item->introtext = HTMLHelper::_('string.truncate', $item->introtext, $globalParams->get('gmapfp_taille_bulle_cesure',200), true, $globalParams->get('gmapfp_html_bubble',0)); 
			}
			//supprime le code html de l'intro pour la bubble
			if($globalParams->get('gmapfp_taille_bulle_cesure',200) == 0 and $globalParams->get('gmapfp_html_bubble',0)){
				$item->introtext = strip_tags($item->introtext);
			}

			if($input->getInt('map', 0) != 1) {
				$articleParams = new Registry($item->attribs);

				// Unpack readmore and layout params
				$item->alternative_readmore = $articleParams->get('alternative_readmore');
				$item->layout               = $articleParams->get('layout');

				$item->params = clone $this->getState('params');

				/**
				 * For blogs, article params override menu item params only if menu param = 'use_article'
				 * Otherwise, menu item params control the layout
				 * If menu item is 'use_article' and there is no article param, use global
				 */
				if (($input->getString('layout') === 'blog') || ($input->getString('view') === 'featured')
					|| ($this->getState('params')->get('layout_type') === 'blog'))
				{
					// Create an array of just the params set to 'use_article'
					$menuParamsArray = $this->getState('params')->toArray();
					$articleArray    = array();

					foreach ($menuParamsArray as $key => $value)
					{
						if ($value === 'use_item')
						{
							// If the article has a value, use it
							if ($articleParams->get($key) != '')
							{
								// Get the value from the article
								$articleArray[$key] = $articleParams->get($key);
							}
							else
							{
								// Otherwise, use the global value
								$articleArray[$key] = $globalParams->get($key);
							}
						}
					}

					// Merge the selected article params
					if (count($articleArray) > 0)
					{
						$articleParams = new Registry($articleArray);
						$item->params->merge($articleParams);
					}
				}
				else
				{
					// For non-blog layouts, merge all of the article params
					$item->params->merge($articleParams);
				}

				// Get display date
				switch ($item->params->get('list_show_date'))
				{
					case 'modified':
						$item->displayDate = $item->modified;
						break;

					case 'published':
						$item->displayDate = ($item->publish_up == 0) ? $item->created : $item->publish_up;
						break;

					default:
					case 'created':
						$item->displayDate = $item->created;
						break;
				}

				/**
				 * Compute the asset access permissions.
				 * Technically guest could edit an article, but lets not check that to improve performance a little.
				 */
				if (!$guest)
				{
					$asset = 'com_gmapfp.item.' . $item->id;

					// Check general edit permission first.
					if ($user->authorise('core.edit', $asset))
					{
						$item->params->set('access-edit', true);
					}

					// Now check if edit.own is available.
					elseif (!empty($userId) && $user->authorise('core.edit.own', $asset))
					{
						// Check for a valid user and that they are the owner.
						if ($userId == $item->created_by)
						{
							$item->params->set('access-edit', true);
						}
					}
				}

				$access = $this->getState('filter.access');

				if ($access)
				{
					// If the access filter has been set, we already have only the articles this user can view.
					$item->params->set('access-view', true);
				}
				else
				{
					// If no access filter is set, the layout takes some responsibility for display of limited information.
					if ($item->catid == 0 || $item->category_access === null)
					{
						$item->params->set('access-view', in_array($item->access, $groups));
					}
					else
					{
						$item->params->set('access-view', in_array($item->access, $groups) && in_array($item->category_access, $groups));
					}
				}

				// Some contexts may not use tags data at all, so we allow callers to disable loading tag data
				if ($this->getState('load_tags', $item->params->get('show_tags', '1')))
				{
					$item->tags = new TagsHelper;
					$item->tags->getItemTags('com_gmapfp.item', $item->id);
				}

				if (Associations::isEnabled() && $item->params->get('show_associations'))
				{
					$item->associations = AssociationHelper::displayAssociations($item->id);
				}
			}
		}

		return $items;
	}

	/**
	 * Method to get the starting number of items for the data set.
	 *
	 * @return  integer  The starting number of items available in the data set.
	 *
	 * @since   3.0.1
	 */
	public function getStart()
	{
		return $this->getState('list.start');
	}

	/**
	 * Count Items by Month
	 *
	 * @return  mixed  An array of objects on success, false on failure.
	 *
	 * @since   3.9.0
	 */
	public function countItemsByMonth()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Get the list query.
		$listQuery = $this->getListQuery();
		$bounded   = $listQuery->getBounded();

		// Bind list query variables to our new query.
		$keys      = array_keys($bounded);
		$values    = array_column($bounded, 'value');
		$dataTypes = array_column($bounded, 'dataType');

		$query->bind($keys, $values, $dataTypes);

		$query
			->select(
				'DATE(' .
				$query->concatenate(
					array(
						$query->year($db->quoteName('publish_up')),
						$db->quote('-'),
						$query->month($db->quoteName('publish_up')),
						$db->quote('-01')
					)
				) . ') AS ' . $db->quoteName('d')
			)
			->select('COUNT(*) AS ' . $db->quoteName('c'))
			->from('(' . $this->getListQuery() . ') AS ' . $db->quoteName('b'))
			->group($db->quoteName('d'))
			->order($db->quoteName('d') . ' DESC');

		return $db->setQuery($query)->loadObjectList();
	}
}
