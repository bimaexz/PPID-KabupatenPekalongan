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
class JmgQuestionnaireTableQuestion extends JTableNested
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
		parent::__construct('#__jmgquestionnaire_questions', 'id', $db);

		$this->setColumnAlias('published', 'state');

		//JTableObserverContenthistory::createObserver($this, array('typeAlias' => 'com_jmgquestionnaire.question'));
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
		else{
			$this->metakey = '';
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
		
		$table = JTable::getInstance('Question', 'JmgQuestionnaireTable', array('dbo' => $this->_db));

		if ($table->load(array('alias' => $this->alias, 'catid' => $this->catid)) && ($table->id != $this->id || $this->id == 0))
		{
			$this->setError(JText::_('COM_JMGQUESTIONNAIRE_ERROR_UNIQUE_ALIAS'));

			return false;
		}

		// Save links as punycode.
		$this->link = JStringPunycode::urlToPunycode($this->link);
		
		return parent::store($updateNulls);
	}
	/**
	 * Overloaded bind function
	 *
	 * @param       array           named array
	 * @return      null|string     null is operation was satisfactory, otherwise returns an error
	 * @see JTable:bind
	 * @since 1.5
	 */
	public function bind($array, $ignore = '')
	{
		if (isset($array['params']) && is_array($array['params']))
		{
			// Convert the params field to a string.
			$parameter = new JRegistry;
			$parameter->loadArray($array['params']);
			$array['params'] = (string)$parameter;
		}

		if (isset($array['imageinfo']) && is_array($array['imageinfo']))
		{
			// Convert the imageinfo array to a string.
			$parameter = new JRegistry;
			$parameter->loadArray($array['imageinfo']);
			$array['image'] = (string)$parameter;
		}

		// Bind the rules.
		if (isset($array['rules']) && is_array($array['rules']))
		{
			$rules = new JAccessRules($array['rules']);
			$this->setRules($rules);
		}

		if (isset($array['parent_id']))
		{
			if (!isset($array['id']) || $array['id'] == 0)
			{   // new record
				$this->setLocation($array['parent_id'], 'last-child');
			}
			elseif (isset($array['questionsordering']))
			{
				// when saving a record load() is called before bind() so the table instance will have properties which are the existing field values
				if ($this->parent_id == $array['parent_id'])
				{
					// If first is chosen make the item the first child of the selected parent.
					if ($array['questionsordering'] == -1)
					{
						$this->setLocation($array['parent_id'], 'first-child');
					}
					// If last is chosen make it the last child of the selected parent.
					elseif ($array['questionsordering'] == -2)
					{
						$this->setLocation($array['parent_id'], 'last-child');
					}
					// Don't try to put an item after itself. All other ones put after the selected item.
					elseif ($array['questionsordering'] && $this->id != $array['questionsordering'])
					{
						$this->setLocation($array['questionsordering'], 'after');
					}
					// Just leave it where it is if no change is made.
					elseif ($array['questionsordering'] && $this->id == $array['questionsordering'])
					{
						unset($array['questionsordering']);
					}
				}
				// Set the new parent id if parent id not matched and put in last position
				else
				{
					$this->setLocation($array['parent_id'], 'last-child');
				}
			}
		}

		return parent::bind($array, $ignore);
	}

}
