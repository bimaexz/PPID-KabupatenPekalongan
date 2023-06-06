<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_8F
	* Creation date: Juillet 2022
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Categories\Categories;
use Joomla\CMS\Categories\CategoryNode;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Table\Table;
use Joomla\Component\Gmapfp\Site\Helper\QueryHelper;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Gmapfp\Site\Helper\RouteHelper as GmapfpRoute;
use Joomla\Component\Content\Site\Helper\RouteHelper as ContentRoute;

class CategoryModel extends ListModel
{
	protected $_item = null;
	protected $_articles = null;
	protected $_mapcontent = null;
	protected $_siblings = null;
	protected $_children = null;
	protected $_parent = null;
	protected $_context = 'com_gmapfp.category';
	protected $_category = null;
	protected $_categories = null;

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
				'access', 'a.access', 'access_level',
				'created', 'a.created',
				'created_by', 'a.created_by',
				'modified', 'a.modified',
				'ordering', 'a.ordering',
				'featured', 'a.featured',
				'language', 'a.language',
				'hits', 'a.hits',
				'publish_up', 'a.publish_up',
				'publish_down', 'a.publish_down',
				'author', 'a.author',
				'filter_tag'
			);
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null)
	{
		$app = Factory::getApplication();
		$pk  = $app->input->getInt('id');

		$this->setState('category.id', $pk);

		// Load the parameters. Merge Global and Menu Item params into new object
		$params = $app->getParams();

		if ($menu = $app->getMenu()->getActive())
		{
			$menuParams = $menu->getParams();
		}
		else
		{
			$menuParams = new Registry;
		}

		$mergedParams = clone $menuParams;
		$mergedParams->merge($params);

		$this->setState('params', $mergedParams);
		$user  = Factory::getUser();

		$asset = 'com_gmapfp';

		if ($pk)
		{
			$asset .= '.category.' . $pk;
		}

		if ((!$user->authorise('core.edit.state', $asset)) &&  (!$user->authorise('core.edit', $asset)))
		{
			// Limit to published for people who can't edit or edit.state.
			$this->setState('filter.condition', 1);
		}
		else
		{
			$this->setState('filter.condition', [0, 1]);
		}

		// Process show_noauth parameter
		if (!$params->get('show_noauth'))
		{
			$this->setState('filter.access', true);
		}
		else
		{
			$this->setState('filter.access', false);
		}

		$itemid = $app->input->get('id', 0, 'int') . ':' . $app->input->get('Itemid', 0, 'int');

		$value = $this->getUserStateFromRequest('com_gmapfp.category.filter.' . $itemid . '.tag', 'filter_tag', 0, 'int', false);
		$this->setState('filter.tag', $value);

		// Optional filter text
		$search = $app->getUserStateFromRequest('com_gmapfp.category.list.' . $itemid . '.filter-search', 'filter-search', '', 'string');
		$this->setState('list.filter', $search);

		// Filter.order
		$orderCol = $app->getUserStateFromRequest('com_gmapfp.category.list.' . $itemid . '.filter_order', 'filter_order', '', 'string');

		if (!in_array($orderCol, $this->filter_fields))
		{
			$orderCol = 'a.ordering';
		}

		$this->setState('list.ordering', $orderCol);

		$listOrder = $app->getUserStateFromRequest('com_gmapfp.category.list.' . $itemid . '.filter_order_Dir', 'filter_order_Dir', '', 'cmd');

		if (!in_array(strtoupper($listOrder), array('ASC', 'DESC', '')))
		{
			$listOrder = 'ASC';
		}

		$this->setState('list.direction', $listOrder);

		$this->setState('list.start', $app->input->get('limitstart', 0, 'uint'));

		// Set limit for query. If list, use parameter. If blog, add blog parameters for limit.
		if (($app->input->get('layout') === 'blog') || $params->get('layout_type') === 'blog')
		{
			$limit = $params->get('num_leading_articles') + $params->get('num_intro_articles') + $params->get('num_links');
			$this->setState('list.links', $params->get('num_links'));
		}
		else
		{
			$limit = $app->getUserStateFromRequest('com_gmapfp.category.list.' . $itemid . '.limit', 'limit', $params->get('display_num'), 'uint');
		}

		$this->setState('list.limit', $limit);

		// Set the depth of the category query based on parameter
		$showSubcategories = $params->get('show_subcategory_content', '0');

		if ($showSubcategories)
		{
			$this->setState('filter.max_category_levels', $params->get('show_subcategory_content', '1'));
			$this->setState('filter.subcategories', true);
		}

		$this->setState('filter.language', Multilanguage::isEnabled());

		$this->setState('layout', $app->input->getString('layout'));

		// Set the featured articles state
		$this->setState('filter.featured', $params->get('show_featured', 'show'));
	}

	public function getItems()
	{
		$limit = $this->getState('list.limit');

		if ($this->_articles === null && $category = $this->getCategory())
		{
			$model = $this->bootComponent('com_gmapfp')->getMVCFactory()
				->createModel('Items', 'Site', ['ignore_request' => true]);
			$model->setState('params', Factory::getApplication()->getParams());
			$model->setState('filter.category_id', $category->id);
			$model->setState('filter.condition', $this->getState('filter.condition'));
			$model->setState('filter.access', $this->getState('filter.access'));
			$model->setState('filter.language', $this->getState('filter.language'));
			$model->setState('filter.featured', $this->getState('filter.featured'));
			$model->setState('list.ordering', $this->_buildContentOrderBy());
			$model->setState('list.start', $this->getState('list.start'));
			$model->setState('list.limit', $limit);
			$model->setState('list.direction', $this->getState('list.direction'));
			$model->setState('list.filter', $this->getState('list.filter'));
			$model->setState('filter.tag', $this->getState('filter.tag'));

			// Filter.subcategories indicates whether to include articles from subcategories in the list or blog
			$model->setState('filter.subcategories', $this->getState('filter.subcategories'));
			$model->setState('filter.max_category_levels', $this->getState('filter.max_category_levels'));

			if ($limit >= 0)
			{
				$this->_articles = $model->getItems();

				if ($this->_articles === false)
				{
					$this->setError($model->getError());
				}
			}
			else
			{
				$this->_articles = array();
			}

			$this->_pagination = $model->getPagination();
		}

		return $this->_articles;
	}
	public function getMapContent()
	{
		$app 	= Factory::getApplication();
		$catid  = $app->input->get('catid', '', 'RAW');
		$ids  	= $app->input->get('id', '', 'RAW');

		$model = $this->bootComponent('com_gmapfp')->getMVCFactory()
				->createModel('Items', 'Site', ['ignore_request' => true]);
		$model->setState('params', Factory::getApplication()->getParams());
		$model->setState('filter.category_id', $catid);
		$model->setState('filter.ids', $ids);
		$model->setState('filter.condition', $this->getState('filter.condition'));
		$model->setState('filter.access', $this->getState('filter.access'));
		$model->setState('filter.language', $this->getState('filter.language'));
		$model->setState('filter.featured', $this->getState('filter.featured'));
		$model->setState('list.ordering', $this->_buildContentOrderBy());
		$model->setState('list.direction', $this->getState('list.direction'));
		$model->setState('list.filter', $this->getState('list.filter'));
		$model->setState('filter.tag', $this->getState('filter.tag'));

		// Filter.subcategories indicates whether to include articles from subcategories in the list or blog
		$model->setState('filter.subcategories', $this->getState('filter.subcategories'));
		$model->setState('filter.max_category_levels', $this->getState('filter.max_category_levels'));

		$items = $model->getItems();
		$itemid = '&Itemid='.$app->input->get('itemid', '', 'INT');
		foreach ($items as &$item)
		{
			if (empty($item->link))
				if (empty($item->article_id))
					$item->link = Route::_(GmapfpRoute::getItemRoute($item->id, $item->catid, $item->language, 'item').$itemid, false);
				else
					$item->link = Route::_(ContentRoute::getArticleRoute($item->article_id, 0, $item->language, 'article').$itemid, false);
		}

		$this->_mapcontent = $items;
		return $this->_mapcontent;
	}

	protected function _buildContentOrderBy()
	{
		$app       = Factory::getApplication();
		$db        = $this->getDbo();
		$params    = $this->state->params;
		$itemid    = $app->input->get('id', 0, 'int') . ':' . $app->input->get('Itemid', 0, 'int');
		$orderCol  = $app->getUserStateFromRequest('com_gmapfp.category.list.' . $itemid . '.filter_order', 'filter_order', '', 'string');
		$orderDirn = $app->getUserStateFromRequest('com_gmapfp.category.list.' . $itemid . '.filter_order_Dir', 'filter_order_Dir', '', 'cmd');
		$orderby   = ' ';

		if (!in_array($orderCol, $this->filter_fields))
		{
			$orderCol = null;
		}

		if (!in_array(strtoupper($orderDirn), array('ASC', 'DESC', '')))
		{
			$orderDirn = 'ASC';
		}

		if ($orderCol && $orderDirn)
		{
			$orderby .= $db->escape($orderCol) . ' ' . $db->escape($orderDirn) . ', ';
		}

		$articleOrderby   = $params->get('orderby_sec', 'rdate');
		$articleOrderDate = $params->get('order_date');
		$categoryOrderby  = $params->def('orderby_pri', '');
		$secondary        = QueryHelper::orderbySecondary($articleOrderby, $articleOrderDate, $this->getDbo()) . ', ';
		$primary          = QueryHelper::orderbyPrimary($categoryOrderby);

		$orderby .= $primary . ' ' . $secondary . ' a.created ';

		return $orderby;
	}

	public function getPagination()
	{
		if (empty($this->_pagination))
		{
			return null;
		}

		return $this->_pagination;
	}

	public function getCategory()
	{
		if (!is_object($this->_item))
		{
			if (isset($this->state->params))
			{
				$params = $this->state->params;
				$options = array();
				$options['countItems'] = $params->get('show_cat_num_articles', 1) || !$params->get('show_empty_categories_cat', 0);
				$options['access']     = $params->get('check_access_rights', 1);
			}
			else
			{
				$options['countItems'] = 0;
			}

			$categories = Categories::getInstance('Gmapfp', $options);
			$this->_item = $categories->get($this->getState('category.id', 'root'));

			// Compute selected asset permissions.
			if (is_object($this->_item))
			{
				$user  = Factory::getUser();
				$asset = 'com_gmapfp.category.' . $this->_item->id;

				// Check general create permission.
				if ($user->authorise('core.create', $asset))
				{
					$this->_item->getParams()->set('access-create', true);
				}

				// TODO: Why aren't we lazy loading the children and siblings?
				$this->_children = $this->_item->getChildren();
				$this->_parent = false;

				if ($this->_item->getParent())
				{
					$this->_parent = $this->_item->getParent();
				}

				$this->_rightsibling = $this->_item->getSibling();
				$this->_leftsibling = $this->_item->getSibling(false);
			}
			else
			{
				$this->_children = false;
				$this->_parent = false;
			}
		}

		return $this->_item;
	}

	public function getParent()
	{
		if (!is_object($this->_item))
		{
			$this->getCategory();
		}

		return $this->_parent;
	}

	public function &getLeftSibling()
	{
		if (!is_object($this->_item))
		{
			$this->getCategory();
		}

		return $this->_leftsibling;
	}

	public function &getRightSibling()
	{
		if (!is_object($this->_item))
		{
			$this->getCategory();
		}

		return $this->_rightsibling;
	}

	public function &getChildren()
	{
		if (!is_object($this->_item))
		{
			$this->getCategory();
		}

		// Order subcategories
		if ($this->_children)
		{
			$params = $this->getState()->get('params');

			$orderByPri = $params->get('orderby_pri');

			if ($orderByPri === 'alpha' || $orderByPri === 'ralpha')
			{
				$this->_children = ArrayHelper::sortObjects($this->_children, 'title', ($orderByPri === 'alpha') ? 1 : (-1));
			}
		}

		return $this->_children;
	}

	public function hit($pk = 0)
	{
		$input = Factory::getApplication()->input;
		$hitcount = $input->getInt('hitcount', 1);

		if ($hitcount)
		{
			$pk = (!empty($pk)) ? $pk : (int) $this->getState('category.id');

			$table = Table::getInstance('Category', 'JTable');
			$table->load($pk);
			$table->hit($pk);
		}

		return true;
	}
}
