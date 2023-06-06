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
 * ShowonOptions Field class.
 */
class JFormFieldShowonOptions extends JFormFieldList
{
	/**
	 * The form field type.
	 */
	protected $type = 'showonoptions';
	protected $questionid;

	/**
	 * Method to get the Showon options.
	 */
	public function getOptions()
	{
		$this->questionid = $this->form->getFieldAttribute('showon','questionid', '', '');
		$this->questioningid = $this->form->getFieldAttribute('showon','questioningid', '', '');
		return JmgQuestionnaireHelper::getShowonOptions($this->questionid,$this->questioningid);
	}
}
