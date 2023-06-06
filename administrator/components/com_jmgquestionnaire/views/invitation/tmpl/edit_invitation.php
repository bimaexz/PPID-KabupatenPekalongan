<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$answers = JmgQuestionnaireHelper::getSurveyByUniqueId($this->item->uniqueid);
$respondent = JmgQuestionnaireHelper::getRespondentByUniqueId($this->item->uniqueid);
$questionnaire = JmgQuestionnaireHelper::getQuestionnaireByQuestionnaireId($this->item->questionnaireid);
?>
<div class="jmg-header-box">
<p><span><?php echo JText::_('COM_JMGQUESTIONNAIRE_QUESTIONNAIRE'); ?>:</span> <?php echo $questionnaire->name; ?></p>
<?php if ($respondent->respondent) : ?>
<p><span><?php echo JText::_('COM_JMGQUESTIONNAIRE_RESPONDENT'); ?>:</span> <?php echo $respondent->respondent; ?></p>
<?php elseif ($respondent->invitationid) : ?>	
<p><span><?php echo JText::_('COM_JMGQUESTIONNAIRE_RESPONDENT'); ?>:</span> <?php echo JText::_('COM_JMGQUESTIONNAIRE_INVITED'); ?></p>
<?php else : ?>
<p><span><?php echo JText::_('COM_JMGQUESTIONNAIRE_RESPONDENT'); ?>:</span> <?php echo JText::_('COM_JMGQUESTIONNAIRE_ANONYMOUS'); ?></p>
<?php endif; ?>
<p><span><?php echo JText::_('COM_JMGQUESTIONNAIRE_UNIQUEID'); ?>:</span> <?php echo $this->item->uniqueid; ?></p>
</div>
	<table class="table table-striped" id="articleList">
		<thead>
			<tr>
				<th class="nowrap">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_ANSWER_NR'); ?>
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


<?php foreach ($answers as $i => $answer) : ?>
	<tr>
		<td>
			<?php echo $i + 1; ?>.
		</td>
		<td>
			<?php echo $answer->question; ?>
		</td>
		<td>
			<?php if ($answer->answerid == -1) : ?>
			<?php echo JText::_('JYES'); ?>
			<?php elseif ($answer->answerid == -2) : ?>
			<?php echo JText::_('JNO'); ?>
			<?php else: ?>
			<?php //echo $answer->answerid; ?>
			<?php echo $answer->answer; ?>
			<?php echo $answer->openanswer; ?> 
			<?php endif; ?>
		</td>
		<td>
			<?php if ($answer->questioningid != 3) : ?>
			<span class="jmg-questionnaire-statement-<?php echo $answer->statement; ?>"><?php echo JmgQuestionnaireHelper::getSatementById($answer->statement); ?></span>
			<?php endif; ?>
		</td>
		<td class="center">
			<?php if ($answer->score) : ?>
					<?php echo $answer->score; ?>
			<?php else: ?>
			 - 
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
</table>







		
		