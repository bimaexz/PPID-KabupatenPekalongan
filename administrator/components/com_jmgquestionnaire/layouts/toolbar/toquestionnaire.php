<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2022 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$questionid = JFactory::getApplication()->input->get('id');
$questionnaire = JmgQuestionnaireHelper::getQuestionnaireByQuestionId($questionid);
$title = JText::_('COM_JMGQUESTIONNAIRE_TO_QUESTIONNAIRE');
?>
<joomla-toolbar-button>
	<form class="jmg-toolbar-form" action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=questionnaire.edit&id=' . (int) $questionnaire->id . '&tab=questions'); ?>" method="post">
		<button type="submit" class="btn btn-small btn-save-new">
			<span class="icon-file icon-white" title="<?php echo $title; ?>"></span> <?php echo $title; ?>
		</button>
	</form>
</joomla-toolbar-button>
