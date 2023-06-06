<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_5_0F
	* Creation date: Novembre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

//utilisé pour la récuération des données en affichage plugin de contenu
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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Component\ComponentHelper;

class MapModel extends ListModel
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
		$catid  = $app->input->getInt('catid', '', 'RAW');
		$id  = $app->input->get('id', '', 'RAW');
		$this->setState('category.id', $catid);
		$this->setState('item.id', $id);
	}

	protected function getListQuery()
	{
		// Get the current user for authorisation checks
		$user 	= Factory::getUser();
		$input  = Factory::getApplication()->input;

		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);
		
		//donnés pour la carte
		$datas =
			'a.id, a.title, a.alias, a.introtext, ' .
			'a.adresse, a.adresse2, a.ville, a.departement, a.codepostal, a.pays, ' .
			'a.tel, a.email, a.web, a.link, a.article_id, a.icon, ' .
			'a.catid, a.glat, a.glng, a.gzoom, a.marqueur, ' .
			'a.img, a.hits ';

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				$datas
			)
		);

		$query->from('#__gmapfp AS a');

		// Filter by access level.
		$groups = implode(',', $user->getAuthorisedViewLevels());
		$query->where('a.access IN (' . $groups . ')');
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
			// ->where('c.access IN (' . $groups . ')');
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		//faire catid ou id =======	
			
			
			

		// Filter by a single or group of articles.
		$itemId = json_decode($this->getState('item.id'));
		$query_id = '';
		if (is_numeric($itemId))
		{
			$query_id = ('a.id = ' . (int) $itemId);
		}
		elseif (is_array($itemId))
		{
			$itemId = ArrayHelper::toInteger($itemId);
			$itemId = implode(',', $itemId);
			$query_id = ('a.id IN ' . ' (' . $itemId . ')');
		}

		// Filter by a single or group of categories
		$categoryId = json_decode($this->getState('category.id'));
		$query_catid = '';
		if (is_numeric($categoryId))
		{
			$categoryEquals       = 'a.catid = ' . (int) $categoryId;
			$query_catid = ($categoryEquals);
		}
		elseif (is_array($categoryId) && (count($categoryId) > 0))
		{
			$categoryId = ArrayHelper::toInteger($categoryId);
			$categoryId = implode(',', $categoryId);
			if (!empty($categoryId))
			{
				$query_catid = ('a.catid IN ' . ' (' . $categoryId . ')');
			}
		}
		//pour affichage plugin
		if ($query_id && $query_catid){
				$query->where($query_id . ' OR ' . $query_catid);
		}
		if ($query_id XOR $query_catid){
				$query->where($query_id . $query_catid);
		}

		$nowDate  = $db->quote(Factory::getDate()->toSql());

		$query->where('(a.publish_up ="0000-00-00 00:00:00" OR a.publish_up IS NULL OR a.publish_up <= ' . $nowDate . ')')
			->where('(a.publish_down ="0000-00-00 00:00:00" OR a.publish_down IS NULL OR a.publish_down >= ' . $nowDate . ')')
			->where('(a.state = 1)');

		// Filter by language
		$query->where('a.language IN (' . $db->quote(Factory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');

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
		}

		return $items;
	}

}
