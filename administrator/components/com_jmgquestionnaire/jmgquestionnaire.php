<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

//JHtml::_('behavior.tabstate');

if (!JFactory::getUser()->authorise('core.manage', 'com_jmgquestionnaire'))
{
	throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
}

$controller = JControllerLegacy::getInstance('Jmgquestionnaire');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();