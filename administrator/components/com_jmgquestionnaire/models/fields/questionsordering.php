<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');
JLoader::register('JmgQuestionnaireHelper', JPATH_ADMINISTRATOR . '/components/com_jmgquestionnaire/helpers/jmgquestionnaire.php');

/**
 * QuestionsOrdering Field class.
 */
class JFormFieldQuestionsOrdering extends JFormFieldList
{
	/**
	 * The form field type.
	 */
	protected $type = 'questionsordering';

	/**
	 * Method to get the questions ordering options.
	 */
	public function getOptions()
	{
		$options = array();
		
		// Get the parent
		$parent_id = ($this->form->getValue('parent_id', 0))? $this->form->getValue('parent_id', 0) : 1;
		$questionnaireid = ($this->form->getValue('questionnaireid', 0))? $this->form->getValue('questionnaireid', 0) : JFactory::getApplication()->input->get('id');

		if (empty($parent_id) && empty($questionnaireid))
		{
			return false;
		}
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS value',  'a.name AS text'))
			->from($db->quoteName('#__jmgquestionnaire_questions', 'a'))
			->where($db->quoteName('a.parent_id') . ' = ' . $db->quote($parent_id))
			->where($db->quoteName('a.questionnaireid') . ' = ' . $db->quote($questionnaireid))
			->order('a.lft ASC');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage('Error');
		}

		$options = array_merge(
			array(array('value' => '-1', 'text' => JText::_('COM_JMGQUESTIONNAIRE_ORDERING_VALUE_FIRST'))),
			$options,
			array(array('value' => '-2', 'text' => JText::_('COM_JMGQUESTIONNAIRE_ORDERING_VALUE_LAST')))
		);

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
	
	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * This method returns the input element except if a new record is being created, in which case a text string is output
	 */
	protected function getInput()
	{
		if ($this->form->getValue('id', 0) == 0)
		{
			return '<input type="text" class="form-control readonly" readonly="readonly"/>';
		}
		else
		{
			return parent::getInput();
		}
	}
}
