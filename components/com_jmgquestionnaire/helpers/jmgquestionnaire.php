<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2020 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.categories');

/**
 * Content Component Category Tree
 *
 * @since  1.6
 */
class JmgQestionnaireQuestionnaire extends JCategories
{
	/**
	 * Class constructor
	 * @param   array  $options  Array of options
	 * @since   1.7.0
	 */
	public function __construct($options = array())
	{
		$options['table'] = '#__content';
		$options['extension'] = 'com_jmgquestionnaire';

		parent::__construct($options);
	}
}
