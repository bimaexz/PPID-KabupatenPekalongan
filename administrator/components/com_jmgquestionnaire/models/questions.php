<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2019 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Methods supporting a list of jmgquestionnaire records.
 * @since  1.6
 */
class JmgQuestionnaireModelQuestions extends JModelList
{
	/**
	 * Constructor.
	 * @param   array  $config  An optional associative array of configuration settings.
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'cid', 'a.cid', 'client_name',
				'name', 'a.name',
				'alias', 'a.alias',
				'state', 'a.state',
				'ordering', 'a.ordering',
				'language', 'a.language',
				'lft', 'a.lft',
				'rgt', 'a.rgt',
				'level', 'a.level',
				'catid', 'a.catid', 'category_title',
				'questionnaireid', 'a.questionnaireid', 'questionnaire',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'created', 'a.created',
				'publish_up', 'a.publish_up',
				'publish_down', 'a.publish_down',
				'category_id',
				'published',
				'level', 'c.level',
			);
		}

		parent::__construct($config);
	}
	/**
	 * Method to get the maximum ordering value for each category.
	 * @return  array
	 * @since   1.6
	 */
	public function &getCategoryOrders()
	{
		if (!isset($this->cache['categoryorders']))
		{
			$db = $this->getDbo();
			$query = $db->getQuery(true)
				->select('MAX(ordering) as ' . $db->quoteName('max') . ', catid')
				->select('catid')
				->from('#__jmgquestionnaire_questions')
				->group('catid');
			$db->setQuery($query);
			$this->cache['categoryorders'] = $db->loadAssocList('catid', 0);
		}
		//print_r($this->cache['categoryorders']);
		//exit;
		return $this->cache['categoryorders'];
	}
	/**
	 * Build an SQL query to load the list data.
	 * @return  JDatabaseQuery
	 */
	protected function getListQuery()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id AS id,'
				. 'a.name AS name,'
				. 'a.alias AS alias,'
				. 'a.questionnaireid AS questionnaireid,'
				. 'a.questioningid AS questioningid,'
				. 'a.checked_out AS checked_out,'
				. 'a.checked_out_time AS checked_out_time,'
				. 'a.state AS state,'
				. 'a.parent_id AS parent_id,'
				. 'a.ordering AS ordering,'
				. 'a.level AS level,'
				. 'a.lft AS lft,'
				. 'a.rgt AS rgt,'
				. 'a.path AS path,'
				. 'a.catid AS catid,'
				. 'a.language AS language,'
				. 'a.publish_up,'
				. 'a.publish_down'
			)
		);
		
		// Join over the questionnaires
		$query->select('q.name AS questionnaire, q.language AS language')
			->join('LEFT', $db->quoteName('#__jmgquestionnaire_questionnaires', 'q') . ' ON q.id = a.questionnaireid');
		
		// Join over the language
		$query->select('l.title AS language_title, l.image AS language_image')
			->join('LEFT', $db->quoteName('#__languages', 'l') . ' ON l.lang_code = q.language');
		
		// Join over the categories.
		$query->select($db->quoteName('c.title', 'category_title'))
			->join('LEFT', $db->quoteName('#__categories', 'c') . ' ON c.id = q.catid');
		
		// Join over the answers.
		$query->select('COUNT(an.id) AS answers')
			->join('LEFT', $db->quoteName('#__jmgquestionnaire_answers', 'an') . ' ON an.questionid = a.id AND an.state = 1');
		
		// Join over the users for the checked out user.
		$query->select('uc.name AS editor')
			->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
		
		$query->from($db->quoteName('#__jmgquestionnaire_questions', 'a'));
		
		// Filter by published state
		$published = $this->getState('filter.published');

		if (is_numeric($published))
		{
			$query->where($db->quoteName('a.state') . ' = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where($db->quoteName('a.state') . ' IN (0, 1)');
		}
		
		// Filter by category.
		$categoryId = $this->getState('filter.category_id');

		if (is_numeric($categoryId))
		{
			$query->where($db->quoteName('a.catid') . ' = ' . (int) $categoryId);
		}
		
		// Filter on the language.
		if ($language = $this->getState('filter.language'))
		{
			$query->where($db->quoteName('a.language') . ' = ' . $db->quote($language));
		}
		
		// Filter by questionnaire.
		$questionnaireId = $this->getState('filter.questionnaireid');

		if (is_numeric($questionnaireId))
		{
			$query->where($db->quoteName('a.questionnaireid') . ' = ' . (int) $questionnaireId);
		}
		
		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where($db->quoteName('a.id') . ' = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
				$query->where('(a.name LIKE ' . $search . ' OR a.alias LIKE ' . $search . ')');
			}
		}
		
		// Add the list ordering clause.
		//$query->order($db->escape($this->getState('list.ordering', 'a.lft')) . ' ' . $db->escape($this->getState('list.direction', 'ASC')));
		
		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', 'a.lfd');
		$orderDirn = $this->state->get('list.direction', 'ASC');

		if ($orderCol == 'a.lft' || $orderCol == 'lft')
		{
			$orderCol = $db->quoteName('c.title') . ' ' . $orderDirn . ', ' . $db->quoteName('a.lft');
		}
		
		// exclude root record
		$query->where('a.id > 1');
		
		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
		
		$query->group('a.id');
		return $query;
	}
	/**
	 * Method to get a store id based on model configuration state.
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 * @param   string  $id  A prefix for the store id.
	 * @return  string  A store id.
	 * @since   1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.published');
		$id .= ':' . $this->getState('filter.category_id');
		$id .= ':' . $this->getState('filter.client_id');
		$id .= ':' . $this->getState('filter.language');
		$id .= ':' . $this->getState('filter.level');

		return parent::getStoreId($id);
	}
	/**
	 * Returns a reference to the a Table object, always creating it.
	 * @param   string  $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 * @return  JTable  A JTable object
	 * @since   1.6
	 */
	public function getTable($type = 'JmgQuestionnaire', $prefix = 'JmgQuestionnaireTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_jmgquestionnaire.jmgquestionnaire', 'jmgquestionnaire',
			array('control' => 'jform', 'load_data' => $loadData)
		);

		if (empty($form))
		{
			return false;
		}

		return $form;
	}
	/**
	 * Method to auto-populate the model state.
	 * Note. Calling getState in this method will result in recursion.
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 * @return  void
	 * @since   1.6
	 */
	protected function populateState($ordering = 'a.lft', $direction = 'asc')
	{
		// Load the filter state.
		$this->setState('filter.search', $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search', '', 'string'));
		$this->setState('filter.published', $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '', 'string'));
		$this->setState('filter.category_id', $this->getUserStateFromRequest($this->context . '.filter.category_id', 'filter_category_id', '', 'cmd'));
		$this->setState('filter.language', $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '', 'string'));
		$this->setState('filter.questionnaireid', $this->getUserStateFromRequest($this->context . '.filter.questionnaireid', 'filter_questionnaireid', '', 'cmd'));
		$this->setState('filter.level', $this->getUserStateFromRequest($this->context . '.filter.level', 'filter_level', '', 'cmd'));

		// Load the parameters.
		$this->setState('params', JComponentHelper::getParams('com_jmgquestionnaire'));

		// List state information.
		parent::populateState($ordering, $direction);
	}
}
