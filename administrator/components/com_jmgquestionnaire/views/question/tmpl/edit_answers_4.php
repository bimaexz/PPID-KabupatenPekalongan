<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$questionnaire = JmgQuestionnaireHelper::getQuestionnaireByQuestionnaireId($this->item->questionnaireid);
$answers = JmgQuestionnaireHelper::getAnswersByQuestionId($this->item->id);
$i = 0;
?>
<div class="jmg-header-box">
<p><span><?php echo JText::_('COM_JMGQUESTIONNAIRE_QUESTIONNAIRE'); ?>:</span> <a href="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&view=questionnaire&layout=edit&id='.$this->item->questionnaireid, false); ?>"><?php echo $questionnaire->name; ?></a></p>
<p><span><?php echo JText::_('COM_JMGQUESTIONNAIRE_QUESTIONING_TECHNIQUE'); ?>:</span> <?php echo JmgQuestionnaireHelper::getQuestioningTechniques($this->item->questioningid); ?></p>
</div>
<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=question.answeradd'); ?>" id="answeraddForm" class="form-inline" name="answeraddForm" method="post" enctype="multipart/form-data">
	<table class="table table-striped" id="articleList">
		<thead>
			<tr>
				<th class="nowrap">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_ANSWER_NR'); ?>
				</th>
				<th class="nowrap">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_ANSWER'); ?>
				</th>
				<th class="nowrap right">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_STATEMENT'); ?>
				</th>
				<th class="nowrap center">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_POINTS'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4">
							
				</td>
			</tr>
		</tfoot>
		<tbody>
		<tr>
			<td>
				1.
			</td>
			<td>
				<?php echo JText::_('JYES'); ?>
			</td>
			<td>
			</td>
			<td class="center">

			</td>
		</tr>
		<tr>
			<td>
				2.
			</td>
			<td>
				<?php echo JText::_('JNO'); ?>
			</td>
			<td>
			</td>
			<td class="center">

			</td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="option" value="com_jmgquestionnaire" />
<input type="hidden" name="task" value="question.answeradd" />
<input type="hidden" name="jform[state]" id="jform_state" value="1" />
<input type="hidden" name="jform[description]" id="jform_description" value="" />
<input type="hidden" name="jform[image]" id="jform_image" value="" />
<input type="hidden" name="jform[image_alt]" id="jform_image_alt" value="" />
<input type="hidden" name="jform[image_title]" id="jform_image_title" value="" />
<input type="hidden" name="jform[metakey]" id="jform_metakey" value="" />
<input type="hidden" name="jform[params]" id="jform_params" value="" />
<input type="hidden" name="jform[questionid]" id="jform_questionid" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>		