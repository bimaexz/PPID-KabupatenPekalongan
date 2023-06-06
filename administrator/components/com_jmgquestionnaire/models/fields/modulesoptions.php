<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgpromobar
 *
 * @copyright   Copyright (C) 2020 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');
JLoader::register('JmgPromoBarHelper', JPATH_ADMINISTRATOR . '/components/com_jmgpromobar/helpers/jmgpromobar.php');

/**
 * CountryOptions Field class.
 */
class JFormFieldModulesOptions extends JFormFieldList
{
	/**
	 * The form field type.
	 */
	protected $type = 'modulesoptions';

	/**
	 * Method to get the Modules options.
	 */
	public function getOptions()
	{
		return JmgPromoBarHelper::getModulesOptions();
	}
}
