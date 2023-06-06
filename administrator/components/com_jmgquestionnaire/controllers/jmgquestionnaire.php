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

/**
 * JmgQuestionnaire list controller class.
 *
 * @since  1.6
 */
class JmgQuestionnaireControllerJmgQuestionnaire extends JControllerAdmin
{
	public function getModel($name = 'JmgQuestionnaire', $prefix = 'JmgQuestionnaireModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}
	
}
