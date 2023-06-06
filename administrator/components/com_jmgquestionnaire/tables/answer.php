<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Factory;

/**
 * JMG Questionnaire Table class.
 *
 * @since  1.6
 */
class JmgQuestionnaireTableAnswer extends JTable
{
	/**
	 * Ensure the params, metadata and images are json encoded in the bind method
	 * @var    array
	 * @since  3.3
	 */

	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  A database connector object
	 */
	public function __construct(&$db)
	{	
		$this->checked_out_time = $db->getNullDate();
		parent::__construct('#__jmgquestionnaire_answers', 'id', $db);

		$this->setColumnAlias('published', 'state');

		//JTableObserverContenthistory::createObserver($this, array('typeAlias' => 'com_jmgquestionnaire.answer'));
	}

	/**
	 * Overloaded check method to ensure data integrity.
	 *
	 * @return  boolean  True on success.
	 */
	public function check()
	{
		// Check for valid name.
		if (trim($this->name) == '')
		{
			$this->setError(JText::_('COM_JMGQUESTIONNAIRE_WARNING_PROVIDE_VALID_NAME'));

			return false;
		}

		if (empty($this->alias))
		{
			$this->alias = $this->name.'-'.JFactory::getDate()->format('Y-m-d-H-i-s');
		}

		$this->alias = JApplicationHelper::stringURLSafe($this->alias, $this->language);

		if (trim(str_replace('-', '', $this->alias)) == '')
		{
			$this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
		}
		
		// Set created date if not set.
		if (!(int) $this->created)
		{
			$this->created = Factory::getDate()->toSql();
		}
		
		// Set publish_up, publish_down to null if not set
		if (!$this->publish_up)
		{
			//$this->publish_up = null;
			$this->publish_up = $this->_db->getNullDate();
		}

		if (!$this->publish_down)
		{
			//$this->publish_down = null;
			$this->publish_down = $this->_db->getNullDate();
		}

		// Check the publish down date is not earlier than publish up.
		if ((int) $this->publish_down > 0 && $this->publish_down < $this->publish_up)
		{
			$this->setError(JText::_('JGLOBAL_START_PUBLISH_AFTER_FINISH'));

			return false;
		}

		// Clean up keywords -- eliminate extra spaces between phrases
		// and cr (\r) and lf (\n) characters from string if not empty
		if (!empty($this->metakey))
		{
			// Array of characters to remove
			$bad_characters = array("\n", "\r", "\"", '<', '>');

			// Remove bad characters
			$after_clean = StringHelper::str_ireplace($bad_characters, '', $this->metakey);

			// Create array using commas as delimiter
			$keys = explode(',', $after_clean);
			$clean_keys = array();

			foreach ($keys as $key)
			{
				if (trim($key))
				{
					// Ignore blank keywords
					$clean_keys[] = trim($key);
				}
			}

			// Put array back together delimited by ", "
			$this->metakey = implode(', ', $clean_keys);
		}

		// Clean up description -- eliminate quotes and <> brackets
		if (!empty($this->metadesc))
		{
			// Only process if not empty
			$bad_characters = array("\"", '<', '>');
			$this->metadesc = StringHelper::str_ireplace($bad_characters, '', $this->metadesc);
		}
		
		// Set params
		$this->params = '';

		return true;
	}

	/**
	 * Overriden JTable::store to set modified data.
	 * @param   boolean  $updateNulls  True to update fields even if they are null.
	 * @return  boolean  True on success.
	 * @since   1.6
	 */
	public function store($updateNulls = false)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		$this->modified = $date->toSql();

		if ($this->id)
		{
			// Existing item
			$this->modified_by = $user->get('id');
		}
		else
		{
			// New newsfeed. A feed created and created_by field can be set by the user,
			// so we don't touch either of these if they are set.
			if (!(int) $this->created)
			{
				$this->created = $date->toSql();
			}

			if (empty($this->created_by))
			{
				$this->created_by = $user->get('id');
			}
		}

		// Verify that the alias is unique
		
		$table = JTable::getInstance('Answer', 'JmgQuestionnaireTable', array('dbo' => $this->_db));

		if ($table->load(array('alias' => $this->alias, 'catid' => $this->catid)) && ($table->id != $this->id || $this->id == 0))
		{
			$this->setError(JText::_('COM_JMGQUESTIONNAIRE_ERROR_UNIQUE_ALIAS'));

			return false;
		}

		// Save links as punycode.
		$this->link = JStringPunycode::urlToPunycode($this->link);
		
		return parent::store($updateNulls);
	}
}
