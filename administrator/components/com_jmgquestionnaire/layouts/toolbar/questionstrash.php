<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2022 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$questionnaireid = JFactory::getApplication()->input->get('id');
$questionid = JFactory::getApplication()->input->get('questionid');
$title = JText::_('COM_JMGQUESTIONNAIRE_TRASH_QUESTIONS');
$j = new JVersion();
$jversion = substr($j->getShortVersion(), 0,1);
?>
<joomla-toolbar-button id="toolbar-trash">
	<?php if ($jversion == 3) : ?>
	<button type="submit" class="btn btn-small button-trash" disabled onClick="if (document.adminForm.boxchecked.value == 0) { alert(Joomla.JText._('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')); } else { Joomla.submitbutton('questionnaire.trashquestion'); }">
		<span class="icon-trash icon-white" title="<?php echo $title; ?>"></span> <?php echo $title; ?>
	</button>
	<?php else : ?>
	<button type="submit" class="btn button-trash btn-danger" disabled onClick="if (document.adminForm.boxchecked.value == 0) { alert(Joomla.JText._('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')); } else { Joomla.submitbutton('questionnaire.trashquestion'); }">
		<span class="icon-trash icon-white" title="<?php echo $title; ?>"></span> <?php echo $title; ?>
	</button>
	<?php endif; ?>
</joomla-toolbar-button>
