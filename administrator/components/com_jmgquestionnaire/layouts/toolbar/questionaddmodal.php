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
$title = JText::_('COM_JMGQUESTIONNAIRE_ADD_QUESTION');
$j = new JVersion();
$jversion = substr($j->getShortVersion(), 0,1);
?>
<joomla-toolbar-button>
	<?php if ($jversion == 3) : ?>
	<button id="jform_question_modal" class="btn hasTooltip" type="button" data-toggle="modal" 
		data-target="#question_modal" data-id="" title="" data-original-title="">
		<span class="icon-plus-2" aria-hidden="true"></span> <?php echo $title; ?>
	</button>
	<?php else : ?>
		<button
			class="btn btn-sm btn-info w5rem mb-1" 
			data-bs-toggle="modal" 
			data-bs-target="#question_modal" 
			data-bs-title="Fixing the ice shelves" 
			data-bs-id="14794" 
			data-bs-action="showCampDescription" 
			onclick="return false;">
			<span class="icon-plus-2" aria-hidden="true"></span> <?php echo $title; ?>
		</button>
	<?php endif; ?>
</joomla-toolbar-button>