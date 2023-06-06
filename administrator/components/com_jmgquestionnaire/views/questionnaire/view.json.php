<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2020 - 2029 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View class for a questionnaire.
 *
 * @since  1.6
 */
class JmgQuestionnaireViewQuestionnaire extends JViewLegacy
{
	protected $state;
	protected $item;

	public function display($tpl = null)
	{
		$app 					= JFactory::getApplication();
		$this->state         	= $this->get('State');
		$this->item  			= $this->get('Item');
		$this->item->id 		= $app->input->get('id');
		return parent::display($tpl);
	}
}
