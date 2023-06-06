<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_9F
	* Creation date: Octobre 2022
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\GMapFP\Administrator\Table;

defined('_JEXEC') or die;

use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\String\PunycodeHelper;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;
use Joomla\Registry\Registry;
use Joomla\String\StringHelper;
use Joomla\Utilities\ArrayHelper;

class ItemTable extends Table
{
	public function __construct(DatabaseDriver $db)
	{
		$this->typeAlias = 'com_gmapfp.item';

		parent::__construct('#__gmapfp', 'id', $db);
		$this->setColumnAlias('published', 'state');
	}

	public function store($updateNulls = true)
	{
		$date   = Factory::getDate()->toSql();
		$userId = Factory::getUser()->id;

		if ($this->id)
		{
			// Existing item
			$this->modified_by = $userId;
			$this->modified    = $date;
		}

		// Store utf8 email as punycode
		$this->email = PunycodeHelper::emailToPunycode($this->email);

		// Convert IDN urls to punycode
		$this->web = PunycodeHelper::urlToPunycode($this->web);

		// Verify that the alias is unique
		$table = Table::getInstance('ItemTable', __NAMESPACE__ . '\\', array('dbo' => $this->getDbo()));

		if ($table->load(array('alias' => $this->alias, 'catid' => $this->catid)) && ($table->id != $this->id || $this->id == 0))
		{
			$this->setError(Text::_('GMAPFP_ERROR_UNIQUE_ALIAS'));

			return false;
		}

		return parent::store($updateNulls);
	}

	public function bind($array, $ignore = '')
	{
		// Search for the {readmore} tag and split the text up accordingly.
		if (isset($array['itemtext']))
		{
			$pattern = '#<hr\s+id=("|\')system-readmore("|\')\s*\/*>#i';
			$tagPos = preg_match($pattern, $array['itemtext']);

			if ($tagPos == 0)
			{
				$this->introtext = $array['itemtext'];
				$this->fulltext = '';
			}
			else
			{
				list ($this->introtext, $this->fulltext) = preg_split($pattern, $array['itemtext'], 2);
			}
		}

		if (isset($array['attribs']) && \is_array($array['attribs']))
		{
			$registry = new Registry($array['attribs']);
			$array['attribs'] = (string) $registry;
		}

		if (isset($array['metadata']) && \is_array($array['metadata']))
		{
			$registry = new Registry($array['metadata']);
			$array['metadata'] = (string) $registry;
		}

		// Bind the rules.
		if (isset($array['rules']) && \is_array($array['rules']))
		{
			$rules = new Rules($array['rules']);
			$this->setRules($rules);
		}

		return parent::bind($array, $ignore);
	}

	public function check()
	{
		$date   = Factory::getDate()->toSql();
		$userId = Factory::getUser()->id;

		try
		{
			parent::check();
		}
		catch (\Exception $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		// Check for valid name
		if (trim($this->title) == '')
		{
			$this->setError(Text::_('GMAPFP_WARNING_PROVIDE_VALID_NAME'));

			return false;
		}

		// Generate a valid alias
		$this->generateAlias();

		// Check for valid category
		if (trim($this->catid) == '')
		{
			$this->setError(Text::_('GMAPFP_WARNING_CATEGORY'));

			return false;
		}

		// Set publish_up, publish_down to null if not set
		if (!$this->publish_up)
		{
			$this->publish_up = $date;
		}

		if (!$this->publish_down)
		{
			$this->publish_down = null;
		}

        // Check the publish down date is not earlier than publish up.
        if (!is_null($this->publish_up) && !is_null($this->publish_down) && $this->publish_down < $this->publish_up) {
            // Swap the dates.
            $temp = $this->publish_up;
            $this->publish_up = $this->publish_down;
            $this->publish_down = $temp;
        }

		if (!$this->id)
		{
			// Images can be an empty json string
			if (!isset($this->img))
			{
				$this->img = '{}';
			}

			// Hits must be zero on a new item
			$this->hits = 0;
			
			// Attributes (article params) can be an empty json string
			if (!isset($this->attribs))
			{
				$this->attribs = '{}';
			}
		}

		$this->article_id	= (int)$this->article_id;
		$this->glat			= substr($this->glat, 0, 10);
		$this->glng			= substr($this->glng, 0, 10);
		$this->version		= (int)$this->version;
		
		if (!(int) $this->created)
		{
			$this->created = $date;
		}

		if (empty($this->created_by))
		{
			$this->created_by = $userId;
		}
		
		/*
		 * Clean up keywords -- eliminate extra spaces between phrases
		 * and cr (\r) and lf (\n) characters from string.
		 * Only process if not empty.
		 */
		if (!empty($this->metakey))
		{
			// Array of characters to remove.
			$badCharacters = array("\n", "\r", "\"", '<', '>');

			// Remove bad characters.
			$afterClean = StringHelper::str_ireplace($badCharacters, '', $this->metakey);

			// Create array using commas as delimiter.
			$keys = explode(',', $afterClean);
			$cleanKeys = array();

			foreach ($keys as $key)
			{
				// Ignore blank keywords.
				if (trim($key))
				{
					$cleanKeys[] = trim($key);
				}
			}

			// Put array back together delimited by ", "
			$this->metakey = implode(', ', $cleanKeys);
		}
		else
		{
			$this->metakey = '';
		}

		// Clean up description -- eliminate quotes and <> brackets
		if (!empty($this->metadesc))
		{
			// Only process if not empty
			$badCharacters = array("\"", '<', '>');
			$this->metadesc = StringHelper::str_ireplace($badCharacters, '', $this->metadesc);
		}
		else
		{
			$this->metadesc = '';
		}

		if (empty($this->params))
		{
			$this->params = '{}';
		}

		if (empty($this->metadata))
		{
			$this->metadata = '{}';
		}

		// Set ordering
		if ($this->state < 0)
		{
			// Set ordering to 0 if state is archived or trashed
			$this->ordering = 0;
		}
		elseif (empty($this->ordering))
		{
			// Set ordering to last if ordering was 0
			$this->ordering = self::getNextOrder($this->_db->quoteName('catid') . '=' . $this->_db->quote($this->catid) . ' AND state>=0');
		}

		// Set modified to created if not set
		if (!$this->modified)
		{
			$this->modified = $this->created;
		}
		
		if (trim(str_replace('&nbsp;', '', $this->fulltext)) == '')
		{
			$this->fulltext = '';
		}

		return true;
	}
	
	/**
	 * Generate a valid alias from title / date.
	 * Remains public to be able to check for duplicated alias before saving
	 *
	 * @return  string
	 */
	public function generateAlias()
	{
		if (empty($this->alias))
		{
			$this->alias = $this->title;
		}

		$this->alias = ApplicationHelper::stringURLSafe($this->alias, $this->language);

		if (trim(str_replace('-', '', $this->alias)) == '')
		{
			$this->alias = Factory::getDate()->format('Y-m-d-H-i-s');
		}

		return $this->alias;
	}
}
