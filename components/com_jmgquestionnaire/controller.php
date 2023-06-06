<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class JmgQuestionnaireController extends JControllerLegacy
{
	/**
	 * Method to show a jmgquestionnaire view
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe URL parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 * @return  JController		This object to support chaining.
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		
		// Set the default view name and format from the Request.
		$view   = $this->input->get('view', 'jmgquestionnaire');
		$layout = $this->input->get('layout', 'default');
		$id     = $this->input->getInt('id');

		parent::display();
	}
}
