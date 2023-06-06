<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2020 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Date\Date;

/**
 * questionnaire model.
 * @since  1.6
 */
class JmgQuestionnaireModelQuestionnaire extends JModelAdmin
{
	public $typeAlias = 'com_jmgquestionnaire.questionnaire';

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
	public function getTable($type = 'Questionnaire', $prefix = 'JmgQuestionnaireTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

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
		$form = $this->loadForm('com_jmgquestionnaire.questionnaire', 'questionnaire', array('control' => 'jform', 'load_data' => $loadData));

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
		$data = JFactory::getApplication()->getUserState('com_jmgquestionnaire.edit.questionnaire.data', array());

		if (empty($data))
		{
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('questionnaire.id') == 0)
			{
				$app = JFactory::getApplication();
				$data->set('catid', $app->input->get('catid', $app->getUserState('com_jmgquestionnaire.jmgquestionnaire.filter.category_id'), 'int'));
			}
		}

		$this->preprocessData('com_jmgquestionnaire.questionnaire', $data);

		return $data;
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
	 * Insert new question.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public function questionAdd($data)
	{		
		$data = (json_decode(json_encode($data), FALSE));
		$data->alias = JFilterOutput::stringURLSafe($data->name).'-'.$data->ordering;
		$data->id = '';

		// Insert the object into the styles table.
		if($result = JFactory::getDbo()->insertObject('#__jmgquestionnaire_questions', $data)){
			JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_QUESTION_INSERTED'));
		}
		
		return true;
	}
	/**
	 * Insert new invitation.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public function invitationAdd($data)
	{		
		$data = (json_decode(json_encode($data), FALSE));
		$date = Date::getInstance();
		$data->created = $date->toSQL();
		$data->id = '';

		// Insert the object into the styles table.
		if($result = JFactory::getDbo()->insertObject('#__jmgquestionnaire_invitations', $data)){
			JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_INVITATION_SENT'));
		}
		
		return true;
	}
}
