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
 * QuestionsOptions Field class.
 */
class JFormFieldQuestionsOptions extends JFormFieldList
{
	/**
	 * The form field type.
	 */
	protected $type = 'questionsoptions';

	/**
	 * Method to get the Questions options.
	 */
	public function getOptions()
	{
		return JmgQuestionnaireHelper::getQuestionsOptions();
	}
}
