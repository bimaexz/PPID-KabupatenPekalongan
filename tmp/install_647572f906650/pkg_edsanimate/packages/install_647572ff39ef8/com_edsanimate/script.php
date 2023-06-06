<?php 

/**
  *	Component - Animate It!
  * Copyright (C) 2014 eLEOPARD Design Studios Pvt Ltd. All rights reserved

  * This program is free software: you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation, either version 3 of the License, or
  * (at your option) any later version.

  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.

  * You should have received a copy of the GNU General Public License
  * along with this program.  If not, see <http://www.gnu.org/licenses/>.

  * For any other query please contact us at contact[at]eleopard[dot]in
**/
?>

<?php
defined('_JEXEC') or die;

define('ROOT', dirname(__FILE__));

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class com_edsanimateInstallerScript
{
	protected $_ext = 'edsanimate';	
	function preflight($type, $parent)
	{
		try {
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->update($db->quoteName('#__extensions'));
			$query->set('enabled=1');
			$query->where($db->quoteName('type') . ' = ' . $db->quote('plugin'));
			$query->where($db->quoteName('element') . ' = ' . $db->quote('edsanimate'));
			$db->setQuery($query);
			$db->execute();			
		}
		catch(Exception $e)
		{
			JFactory::getApplication()->enqueueMessage(
				JText::_('Problem occured while enabling the plugins automaitically.'.
			 	'You can enable the same using plugin manager. '), 'warning');			
		}
		self::uninstallInstaller();		
	}
	
	private function uninstallInstaller()
	{
		$db = JFactory::getDBO();

		$query = $db->getQuery(true)
			->delete('#__menu')
			->where('title = ' . $db->quote('com_' . $this->_ext));
		$db->setQuery($query);
		$db->execute();
		if (in_array($db->name, array('mysql', 'mysqli')))
		{
			$db->setQuery('ALTER TABLE `#__menu` AUTO_INCREMENT = 1');
			$db->execute();
		}
		
		// Delete component folder
		$f = JPATH_ADMINISTRATOR . '/components/' . 'com_' . $this->_ext;
		if (JFolder::exists($f))
		{
			JFolder::delete($f);
		}
		JFactory::getApplication()->enqueueMessage(
			JText::_('All the plugins successfully'.
			' Installed and Enabled.'), 'message');
		JFactory::getApplication()->redirect('index.php?option=com_installer');
	}
	
}