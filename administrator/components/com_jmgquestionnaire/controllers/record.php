<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

class JmgQuestionnaireControllerRecord extends JControllerForm
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_JMGQUESTIONNAIRE_RECORD';

	/**
	 * Method override to check if you can add a new record.
	 * @param   array  $data  An array of input data.
	 * @return  boolean
	 * @since   1.6
	 */
	protected function allowAdd($data = array())
	{
		$filter     = $this->input->getInt('filter_category_id');
		$categoryId = ArrayHelper::getValue($data, 'catid', $filter, 'int');
		$allow      = null;

		if ($categoryId)
		{
			// If the category has been passed in the URL check it.
			$allow = JFactory::getUser()->authorise('core.create', $this->option . '.category.' . $categoryId);
		}

		if ($allow !== null)
		{
			return $allow;
		}

		// In the absence of better information, revert to the component permissions.
		return parent::allowAdd($data);
	}

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId   = (int) isset($data[$key]) ? $data[$key] : 0;
		$categoryId = 0;

		if ($recordId)
		{
			$categoryId = (int) $this->getModel()->getItem($recordId)->catid;
		}

		if ($categoryId)
		{
			// The category has been set. Check the category permissions.
			return JFactory::getUser()->authorise('core.edit', $this->option . '.category.' . $categoryId);
		}

		// Since there is no asset tracking, revert to the component permissions.
		return parent::allowEdit($data, $key);
	}

	/**
	 * Method to run batch operations.
	 * @param   string  $model  The model
	 * @return  boolean  True on success.
	 * @since   2.5
	 */
	public function batch($model = null)
	{
		$this->checkToken();

		// Set the model
		$model = $this->getModel('JmgQuestionnaire', '', array());

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_jmgquestionnaire&view=records' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}
}
