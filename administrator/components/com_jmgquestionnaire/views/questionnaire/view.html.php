<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('JmgQuestionnaireHelper', JPATH_ADMINISTRATOR . '/components/com_jmgquestionnaire/helpers/jmgquestionnaire.php');

/**
 * View to edit a questionnaire.
 *
 * @since  1.5
 */
class JmgQuestionnaireViewQuestionnaire extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Display the view
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 * @return  mixed  A string if successful, otherwise an Error object.
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form  = $this->get('Form');
		$this->item  = $this->get('Item');
		$this->state = $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}
		
		// Set the toolbar, but not on the modal window
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
		}

		return parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 * @return  void
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$isNew      = ($this->item->id == 0);
		
		JLoader::register('JmgQuestionnaireHelper', JPATH_ADMINISTRATOR . '/components/com_jmgquestionnaire/helpers/jmgquestionnaire.php');
		JToolbarHelper::title($isNew ? JText::_('COM_JMGQUESTIONNAIRE_QUESTIONNAIRE_NEW_TITLE') : JText::_('COM_JMGQUESTIONNAIRE_QUESTIONNAIRE_EDIT_TITLE'));
		JToolbarHelper::apply('questionnaire.apply');
		JToolbarHelper::save('questionnaire.save');
		
		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('questionnaire.cancel');
		}
		else
		{
			if (JComponentHelper::isEnabled('com_contenthistory') && $this->state->params->get('save_history', 0) && $canDo->get('core.edit'))
			{
				JToolbarHelper::versions('com_jmgquestionnaire.questionnaire', $this->item->id);
			}
			JToolbarHelper::cancel('questionnaire.cancel', 'JTOOLBAR_CLOSE');
			$layout = new JLayoutFile('toolbar.questionaddmodal');
			$bar  = JToolbar::getInstance('toolbar');
			$bar->appendButton('Custom', $layout->render(array()), 'questionaddmodal');
			//$layout = new JLayoutFile('toolbar.questionstrash');
			//$bar  = JToolbar::getInstance('toolbar');
			//$bar->appendButton('Custom', $layout->render(array()), 'questionstrash');
			JToolbarHelper::trash('questionnaire.trashquestion');
		}
		
		JToolbarHelper::divider();
		JToolbarHelper::preferences('com_jmgquestionnaire');
		JToolbarHelper::help("JHELP_COMPONENTS", false, "https://joomega.com/en/documentation/jmg-questionnaire");
	}
}
