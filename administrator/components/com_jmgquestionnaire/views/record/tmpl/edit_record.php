<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$record = JmgQuestionnaireHelper::getRecordById($this->item->id);
$respondent = JmgQuestionnaireHelper::getRespondentByUniqueId($this->item->uniqueid);
?>
<div class="jmg-header-box">
<?php if ($respondent->respondent) : ?>
<p><span><?php echo JText::_('COM_JMGQUESTIONNAIRE_RESPONDENT'); ?>:</span> <?php echo $respondent->respondent; ?></p>
<?php else : ?>
<p><span><?php echo JText::_('COM_JMGQUESTIONNAIRE_RESPONDENT'); ?>:</span> <?php echo JText::_('COM_JMGQUESTIONNAIRE_ANONYMOUS'); ?></p>
<?php endif; ?>
<p><span><?php echo JText::_('COM_JMGQUESTIONNAIRE_UNIQUEID'); ?>:</span> <?php echo $this->item->uniqueid; ?></p>
</div>
	<table class="table table-striped" id="articleList">
		<thead>
			<tr>
				<th class="nowrap">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_QUESTIONNAIRE'); ?>
				</th>
				<th>
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_QUESTION'); ?>
				</th>
				<th>
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_RESPONDENT_ANSWER'); ?>
				</th>
				<th class="nowrap">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_STATEMENT'); ?>
				</th>
				<th class="nowrap center">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_POINTS'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
							
				</td>
			</tr>
		</tfoot>
		<tbody>



	<tr>
		<td>
			<?php echo $record->questionnaire; ?>
		</td>
		<td>
			<?php echo $record->question; ?>
		</td>
		<td>
			<?php if ($record->answerid == -1) : ?>
			<?php echo JText::_('JYES'); ?>
			<?php elseif ($record->answerid == -2) : ?>
			<?php echo JText::_('JNO'); ?>
			<?php else: ?>
			<?php //echo $record->recordid; ?>
			<?php echo $record->answer; ?>
			<?php echo $record->openanswer; ?> 
			<?php endif; ?>
		</td>
		<td>
			<span class="jmg-questionnaire-statement-<?php echo $record->statement; ?>"><?php echo JmgQuestionnaireHelper::getSatementById($record->statement); ?></span>	
		</td>
		<td class="center">
			<?php if ($record->score) : ?>
					<?php echo $record->score; ?>
			<?php else: ?>
			 - 
			<?php endif; ?>
		</td>
	</tr>
	</tbody>
</table>







		
		