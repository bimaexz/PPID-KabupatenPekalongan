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
 * ParentQuestionsOptions Field class.
 */
class JFormFieldParentQuestionsOptions extends JFormFieldList
{
	/**
	 * The form field type.
	 */
	protected $type = 'parentquestionsoptions';

	/**
	 * Method to get the Questions options.
	 */
	public function getOptions()
	{
		$id = ($this->form->getValue('questionnaireid',$group=null,$default=null))? $this->form->getValue('questionnaireid',$group=null,$default=null) : JFactory::getApplication()->input->get('id');
		return JmgQuestionnaireHelper::getParentQuestionsOptions($id);
	}
}
