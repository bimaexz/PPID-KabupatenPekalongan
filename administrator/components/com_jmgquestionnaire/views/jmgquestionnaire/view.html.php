<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2020 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View class for a list of buttons.
 *
 * @since  1.6
 */
class JmgQuestionnaireViewJmgQuestionnaire extends JViewLegacy
{
	protected $categories;
	protected $items;
	protected $pagination;
	protected $state;
	public function display($tpl = null)
	{
		$this->categories    = $this->get('CategoryOrders');
		$this->items         = $this->get('Items');
		$this->pagination    = $this->get('Pagination');
		$this->state         = $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}
		
		JmgQuestionnaireHelper::addSubmenu('jmgquestionnaire');

		$this->addToolbar();

		// Include the component HTML helpers.
		JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

		$this->sidebar = JHtmlSidebar::render();

		return parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		JLoader::register('JmgQuestionnaireHelper', JPATH_ADMINISTRATOR . '/components/com_jmgquestionnaire/helpers/jmgquestionnaire.php');

		$canDo = JHelperContent::getActions('com_jmgquestionnaire', 'category', $this->state->get('filter.category_id'));
		$user  = JFactory::getUser();

		JToolBarHelper::title(JText::_('COM_JMGQUESTIONNAIRE'));
		
		//JToolbarHelper::addNew('jmgfood.add');
		
		if ($user->authorise('core.admin', 'com_jmgquestionnaire') || $user->authorise('core.options', 'com_jmgquestionnaire'))
		{
			JToolbarHelper::preferences('com_jmgquestionnaire');
		}
		
		JToolbarHelper::help("JHELP_COMPONENTS", false, "https://joomega.com/en/documentation/jmg-promobar");
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'ordering'    => JText::_('JGRID_HEADING_ORDERING'),
			'a.state'     => JText::_('JSTATUS'),
			'a.name'      => JText::_('COM_JMGQUESTIONNAIRE_HEADING_NAME'),
			'a.language'  => JText::_('JGRID_HEADING_LANGUAGE'),
			'a.id'        => JText::_('JGRID_HEADING_ID'),
		);
	}
}
