<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2020 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');
JLoader::register('JmgQuestionnaireHelper', JPATH_ADMINISTRATOR . '/components/com_jmgquestionnaire/helpers/jmgquestionnaire.php');

/**
 * QuestionnairesOptions Field class.
 */
class JFormFieldQuestionnairesOptions extends JFormFieldList
{
	/**
	 * The form field type.
	 */
	protected $type = 'questionnairesoptions';

	/**
	 * Method to get the Questionnaires options.
	 */
	public function getOptions()
	{
		return JmgQuestionnaireHelper::getQuestionnairesOptions();
	}
}
