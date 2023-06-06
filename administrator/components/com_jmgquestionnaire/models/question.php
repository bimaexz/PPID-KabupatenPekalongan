<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use Joomla\String\StringHelper;
use Joomla\Utilities\ArrayHelper;

/**
 * question model.
 * @since  1.6
 */
class JmgQuestionnaireModelQuestion extends JModelAdmin
{
	public $typeAlias = 'com_jmgquestionnaire.question';

	/**
	 * Method to test whether a record can be deleted.
	 * @param   object  $record  A record object.
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission set in the component.
	 * @since   1.6
	*/	
	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			if ($record->state != -2)
			{
				return false;
			}

			$user = JFactory::getUser();

			if (!empty($record->catid))
			{
				return $user->authorise('core.delete', 'com_jmgquestionnaire.category.' . (int) $record->catid);
			}

			return $user->authorise('core.delete', 'com_jmgquestionnaire');
		}
	}
	
	/**
	 * Method to test whether a record can have its state changed.
	 * @param   object  $record  A record object.
	 * @return  boolean  True if allowed to change the state of the record. Defaults to the permission set in the component.
	 * @since   1.6
	 */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();

		if (!empty($record->catid))
		{
			return $user->authorise('core.edit.state', 'com_jmgquestionnaire.category.' . (int) $record->catid);
		}
		
		return $user->authorise('core.edit.state', 'com_jmgquestionnaire');
	}

	/**
	 * Returns a Table object, always creating it.
	 *
	 * @param   string  $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable    A database object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Question', $prefix = 'JmgQuestionnaireTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	
	/**
	 * Auto-populate the model state.
	 * Note. Calling getState in this method will result in recursion.
	 * @return  void
	 * @since   1.6
	 
	protected function populateState()
	{
		$app = JFactory::getApplication('administrator');

		// Load the User state.
		$pk = $app->input->getInt('id');
		$this->setState('item.id', $pk);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_menus');
		$this->setState('params', $params);
	}
*/
	/**
	 * Method to get the record form.
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 * @return  JForm    A JForm object on success, false on failure
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_jmgquestionnaire.question', 'question', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}
		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 * @return  mixed  The data for the form.
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_jmgquestionnaire.edit.question.data', array());

		if (empty($data))
		{
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('question.id') == 0)
			{
				$app = JFactory::getApplication();
				$data->set('catid', $app->input->get('catid', $app->getUserState('com_jmgquestionnaire.jmgquestionnaire.filter.category_id'), 'int'));
			}
		}

		$this->preprocessData('com_jmgquestionnaire.question', $data);

		return $data;
	}
	
	
	/**
	 * Method rebuild the entire nested set tree.
	 * @return  boolean|JException  Boolean true on success, boolean false or JException instance on error
	 * @since   1.6
	 */
	public function rebuild()
	{
		// Initialise variables.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$table = $this->getTable();

		try
		{
			$rebuildResult = $table->rebuild();
		}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		if (!$rebuildResult)
		{
			$this->setError($table->getError());

			return false;
		}

		$query->select('id, params')
			->from('#__jmgquestionnaire_questions')
			->where('params NOT LIKE ' . $db->quote('{%'))
			->where('params <> ' . $db->quote(''));
		$db->setQuery($query);

		try
		{
			$items = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			return JError::raiseWarning(500, $e->getMessage());
		}

		foreach ($items as &$item)
		{
			$registry = new Registry($item->params);
			$params = (string) $registry;

			$query->clear();
			$query->update('#__jmgquestionnaire_questions')
				->set('params = ' . $db->quote($params))
				->where('id = ' . $item->id);

			try
			{
				$db->setQuery($query)->execute();
			}
			catch (RuntimeException $e)
			{
				return JError::raiseWarning(500, $e->getMessage());
			}

			unset($registry);
		}

		// Clean the cache
		$this->cleanCache();

		return true;
	}
	
	/**
	 * Method to override the JModelAdmin save() function to handle Save as Copy correctly
	 * @param   The jmd questionnaire record data submitted from the form.
	 * @return  parent::save() return value
	 */
	public function save($data)
	{
		$input = JFactory::getApplication()->input;

		JLoader::register('CategoriesHelper', JPATH_ADMINISTRATOR . '/components/com_categories/helpers/categories.php');

		// Validate the category id
		// validateCategoryId() returns 0 if the catid can't be found
		if ((int) $data['catid'] > 0)
		{
			//$data['catid'] = CategoriesHelper::validateCategoryId($data['catid'], 'com_jmgquestionnaire');
		}

		// Alter the name and alias for save as copy
		if ($input->get('task') == 'save2copy')
		{
			$origTable = clone $this->getTable();
			$origTable->load($input->getInt('id'));

			if ($data['name'] == $origTable->name)
			{
				list($name, $alias) = $this->generateNewTitle($data['catid'], $data['alias'], $data['name']);
				$data['name'] = $name;
				$data['alias'] = $alias;
			}
			else
			{
				if ($data['alias'] == $origTable->alias)
				{
					$data['alias'] = '';
				}
			}
			// standard Joomla practice is to set the new record as unpublished
			$data['published'] = 0;
		}

		$result = parent::save($data);
		if ($result)
		{
			//$this->getTable()->rebuild(1);
		}
		return $result;
	}
	
	/**
	 * Method to save the reordered nested set tree.
	 * First we save the new order values in the lft values of the changed ids.
	 * Then we invoke the table rebuild to implement the new ordering.
	 * @param   array  $idArray   Rows identifiers to be reordered
	 * @param   array  $lftArray  lft values of rows to be reordered
	 * @return  boolean false on failure or error, true otherwise.
	 * @since   1.6
	 */
	public function saveorder($idArray = null, $lftArray = null)
	{
		// Get an instance of the table object.
		$table = $this->getTable();

		if (!$table->saveorder($idArray, $lftArray))
		{
			$this->setError($table->getError());

			return false;
		}

		// Clean the cache
		$this->cleanCache();

		return true;
	}
	
		/**
	 * Method to override getItem to allow us to get more informations
	 * in the database record into an array for subsequent prefilling of the edit form
	 * We also use this method to prefill the questionsordering field
	 */
	public function getItem($pk = null)
	{
		$item = parent::getItem($pk);
		$item->questionsordering = $item->id;
		return $item; 
	}

	
	/**
	 * Prepare and sanitise the table prior to saving.
	 * @param   JTable  $table  A JTable object.
	 * @return  void
	 * @since   1.6
	 */
	protected function prepareTable($table)
	{
		$table->name = htmlspecialchars_decode($table->name, ENT_QUOTES);
	}
	/**
	 * Insert new answer.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public function answerAdd($data)
	{		
		$data = (json_decode(json_encode($data), FALSE));
		$data->alias = JFilterOutput::stringURLSafe($data->name);
		$data->id = '';

		// Insert the object into the styles table.
		if($result = JFactory::getDbo()->insertObject('#__jmgquestionnaire_answers', $data)){
			JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_ANSWER_INSERTED'));
		}
		
		return true;
	}
	/**
	 * Set correct answer.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public function setCorrectAnswer($data)
	{		
		$data = (json_decode(json_encode($data), FALSE));
		$db   = $this->getDbo();
		
		if($data->questioningid == 1){
			// Reset the active fields for the answerid.
			$query = $db->getQuery(true)
				->update('#__jmgquestionnaire_answers')
				->set('statement = 0')
				->where('questionid = ' . (int) $data->questionid);
			$db->setQuery($query);
			$db->execute();
		}
		

		// Set the new active field style.
		$query = $db->getQuery(true)
			->update('#__jmgquestionnaire_answers')
			->set('statement = 1')
			->where('id = ' . (int) $data->answerid);
		$db->setQuery($query);
		$db->execute();

		// Clean the cache.
		$this->cleanCache();

		return true;
	}
	/**
	 * Trash questions.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public function trashQuestion($data)
	{		
		//$$data = (json_decode(json_encode($data), FALSE));
		$ids = implode(',',$data);

		$db   = $this->getDbo();
		// Set the new active field style.
		$query = $db->getQuery(true)
			->update('#__jmgquestionnaire_questions')
			->set('state = -2')
			->where('id IN ('.$ids.')');
		$db->setQuery($query);
		$db->execute();

		// Clean the cache.
		$this->cleanCache();

		return true;
	}
}
