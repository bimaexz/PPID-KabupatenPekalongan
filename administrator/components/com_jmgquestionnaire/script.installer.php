<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class Com_JmgQuestionnaireInstallerScript
{ 
	/**
	 * method to run after an install/update/uninstall method
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		$this->checkAndCreateDefaultCategory();
		$this->checkAndCreateRootRecordForQuestions();
	}
	
	protected function checkAndCreateDefaultCategory()
    {
        $db = JFactory::getDBO();

        // Make sure we have at least one category
        $query = $db->getQuery(true)
            ->select('count(*)')
            ->from('#__categories')
            ->where(
                array(
                    'extension = ' . $db->quote('com_jmgquestionnaire'),
                    'published >= 0'
                )
            );
        $db->setQuery($query);
        $total = (int) $db->loadResult();

        if ($total === 0) {
            $row = JTable::getInstance('category');

            $data = array(
                'title'     => 'Uncategorised',
                'parent_id' => 1,
                'extension' => 'com_jmgquestionnaire',
                'published' => 1,
				'path' 		=> 'uncategorised',
                'language'  => '*'
            );

            $row->setLocation($data['parent_id'], 'last-child');
            $row->bind($data);
            if ($row->check()) {
                $row->store();
				JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_INSTALL_GENERAL_CATEGORY_CREATED'));
				
            } else {
				JFactory::getApplication()->enqueueMessage();
            }
        } else {
            // Make sure to fix the undefined language
            $query = $db->getQuery(true)
                ->update('#__categories')
                ->set($db->quoteName('language') . '=' . $db->quote('*'))
                ->where(
                    array(
                        $db->quoteName('extension') . ' = ' . $db->quote('com_jmgquestionnaire'),
                        '(' . $db->quoteName('language') . ' IS NULL OR ' . $db->quoteName('language') . ' = ' . $db->quote('') . ')',
                    )
                );
            $db->setQuery($query);
            $db->execute();
        }
    }
	
	protected function checkAndCreateRootRecordForQuestions()
    {
	
		$db = JFactory::getDbo();
		
		echo '<p>Checking if the root record is already present ...</p>';
		
		$query = $db->getQuery(true);
		$query->select('id');
		$query->from('#__jmgquestionnaire_questions');
		$query->where('id = 1');
		$query->where('alias = "questions-root-alias"');
		$db->setQuery($query);
		$id = $db->loadResult();
		
		if ($id == '1')
		{   // assume tree structure already built
			echo '<p>Root record already present, install program exiting ...</p>';
			return;
		}

		echo '<p>Checking if there is a record with id = 1 ...</p>';
		
		$query = $db->getQuery(true);
		$query->select('id');
		$query->from('#__jmgquestionnaire_questions');
		$query->where('id = 1');
		$db->setQuery($query);
		$id = $db->loadResult();
			
		if ($id)
		{
			echo '<p>Record with id = 1 found</p>';
			
			// get new id
			$query = $db->getQuery(true)
				->select('max(id) + 1')
				->from('#__jmgquestionnaire_questions');
			$db->setQuery($query);
			$newid = $db->loadResult(); 
			echo "<p>Changing id to $newid</p>";
			
			// update id in helloworld table
			$query = $db->getQuery(true)
				->update('#__jmgquestionnaire_questions')
				->set("id = $newid")
				->where("id = $id");
			$db->setQuery($query);
			$result = $db->execute();
			if ($result)
			{
				$nrows = $db->getAffectedRows();
				echo "<p>Id in questions table changed, records updated: $nrows</p>";
			}
			else
			{
				echo "<p>Error: Id in questions table not changed</p>";
				var_dump($result);
			}
			
			// update id in the associations table
			$query = $db->getQuery(true)
				->update('#__associations')
				->set("id = $newid")
				->where("id = $id")
				->where('context = "com_jmgquestionnaire.question"');
			$db->setQuery($query);
			$result = $db->execute();
			if ($result)
			{
				$nrows = $db->getAffectedRows();
				echo "<p>Id in associations table changed, records updated: $nrows</p>";
			}
			else
			{
				echo "<p>Error: Id in associations table not changed</p>";
				var_dump($result);
			}
			
			// update id in the assets table
			$query = $db->getQuery(true)
				->update('#__assets')
				->set('name = "com_jmgquestionnaire.questions.' . $newid . '"')
				->where('name = "com_jmgquestionnaire.questions.' . $id . '"');
			$db->setQuery($query);
			$result = $db->execute();
			if ($result)
			{
				$nrows = $db->getAffectedRows();
				echo "<p>Id in assets table changed, records updated: $nrows</p>";
			}
			else
			{
				echo "<p>Error: Id in assets table not changed</p>";
				var_dump($result);
			}
		}
		else 
		{
			echo '<p>No record with id = 1 found</p>';
		}
		
		// find number of records in helloworld table
		$query = $db->getQuery(true)
			->select('count(*)')
			->from('#__jmgquestionnaire_questions');
		$db->setQuery($query);
		$total = $db->loadResult(); 
		
		// insert root record
		$columns = array('id','name','alias','state','parent_id','rgt');
		$values = array(1, 'questions root','questions-root-alias',1,0, 2 * (int)$total + 1);

		$query = $db->getQuery(true)
			->insert('#__jmgquestionnaire_questions')
			->columns($db->quoteName($columns))
			->values(implode(',', $db->quote($values)));
		$db->setQuery($query);
		$result = $db->execute();
		if ($result)
		{
			$nrows = $db->getAffectedRows();
			echo "<p>$nrows inserted into questions table</p>";
		}
		else
		{
			echo "<p>Error creating root record</p>";
			var_dump($result);
		}
		
		// update lft and rgt for each of the other records (ie not root)
		$query = $db->getQuery(true)
			->select('id')
			->from('#__jmgquestionnaire_questions')
			->where('id > 1');
		$db->setQuery($query);
		$ids = $db->loadColumn(); 
		for ($i = 0; $i < $total; $i++)
		{
			$lft = 2 * (int)$i + 1;
			$rgt = 2 * (int)$i + 2;
			$query = $db->getQuery(true)
				->update('#__jmgquestionnaire_questions')
				->set("lft = {$lft}")
				->set("rgt = {$rgt}")
				->where("id = {$ids[$i]}");
			$db->setQuery($query);
			$result = $db->execute();
			if ($result)
			{
				$nrows = $db->getAffectedRows();
				echo "<p>$nrows updated in questions table, for id = {$ids[$i]}</p>";
			}
			else
			{
				echo "<p>Error updating record</p>";
				var_dump($result);
			}
		}	
	}
}
?>