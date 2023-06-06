<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$questionid = JFactory::getApplication()->input->get('questionid');
$question = JmgQuestionnaireHelper::getQuestionByQuestionId($questionid);
$answers = JmgQuestionnaireHelper::getAnswersByQuestionId($questionid);
$i = -1;
?>
<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=questionnaire.answeradd'); ?>" id="answeraddform" class="form-inline" name="answeraddform" method="post" enctype="multipart/form-data">

<div class="jmg-answers">
	<?php if ($question->image) : ?>
	<img src="<?php echo JURI::root().$question->image; ?>" />
	<?php endif; ?>
	<h3><?php echo $question->name; ?></h3>
	<?php if ($question->questioningid == 1 || $question->questioningid == 2) : ?>
	<ul>
		<?php foreach ($answers as $i => $answer) : ?>
		<li>
			<a class="select-answer" data-id="<?php echo $answer->id; ?>">
				<?php if ($question->questioningid == 1) : ?>
					<?php if ($answer->statement == 1) : ?>
					<span class="icon icon-radio-checked"></span>
					<?php else : ?>
					<span class="icon icon-radio-unchecked"></span>
					<?php endif; ?>
				<?php elseif ($question->questioningid == 2) : ?>
					<?php if ($answer->statement == 1) : ?>
					<span class="icon icon-checkbox-partial"></span>
					<?php else : ?>
					<span class="icon icon-checkbox-unchecked"></span>
					<?php endif; ?>
				<?php else : ?>
					
				<?php endif; ?>
			</a>
			<?php echo $i + 1; ?>. 
			<?php echo $answer->name; ?>
			<?php if ($answer->statement == 1) : ?>
				<span class="small break-word gray"><?php echo JText::_('COM_JMGQUESTIONNAIRE_CORRECT'); ?></span>
				<?php if ($answer->score) : ?>
					<span class="small break-word gray"><?php echo $answer->score; ?> <?php echo JText::_('COM_JMGQUESTIONNAIRE_POINTS'); ?></span>
				<?php endif; ?>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
		<li>
			<input type="text" class="form-control input-large" name="jform[name]" id="jform_name" placeholder="<?php echo JText::_('COM_JMGQUESTIONNAIRE_ANSWER'); ?>" value="" size="40"/>
			<button type="submit" class="btn btn-primary validate"><span class="icon-plus-2" title=""></span></button>
		</li>
	</ul>
	<?php elseif ($question->questioningid == 3) : ?>
	<textarea disabled><?php echo JText::_('COM_JMGQUESTIONNAIRE_FREE_ANSWER'); ?></textarea>
	<?php else : ?>
	<ul>
		<li><?php echo JText::_('JYES'); ?></li>
		<li><?php echo JText::_('JNO'); ?></li>
	</ul>
	<?php endif; ?>
</div>
	
<input type="hidden" name="option" value="com_jmgquestionnaire" />
<input type="hidden" name="task" value="questionnaire.answeradd" />
<input type="hidden" name="jform[state]" id="jform_state" value="1" />
<input type="hidden" name="jform[description]" id="jform_description" value="" />
<input type="hidden" name="jform[image]" id="jform_image" value="" />
<input type="hidden" name="jform[image_alt]" id="jform_image_alt" value="" />
<input type="hidden" name="jform[image_title]" id="jform_image_title" value="" />
<input type="hidden" name="jform[ordering]" id="jform_ordering" value="<?php echo $i + 2; ?>" />
<input type="hidden" name="jform[metakey]" id="jform_metakey" value="" />
<input type="hidden" name="jform[params]" id="jform_params" value="" />
<input type="hidden" name="jform[language]" id="jform_language" value="*" />
<input type="hidden" name="jform[questionid]" id="jform_questionid" value="<?php echo $questionid; ?>" />
<input type="hidden" name="jform[id]" id="jform_id" value="<?php echo $this->item->id; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>

<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=questionnaire.setcorrectanswer'); ?>" id="setcorrectanswerform" class="form-inline" name="setcorrectanswerform" method="post" enctype="multipart/form-data">	
<input type="hidden" name="option" value="com_jmgquestionnaire" />
<input type="hidden" name="task" value="questionnaire.setcorrectanswer" />
<input type="hidden" name="jform[state]" id="jform_state" value="1" />
<input type="hidden" name="jform[description]" id="jform_description" value="" />
<input type="hidden" name="jform[image]" id="jform_image" value="" />
<input type="hidden" name="jform[image_alt]" id="jform_image_alt" value="" />
<input type="hidden" name="jform[image_title]" id="jform_image_title" value="" />
<input type="hidden" name="jform[metakey]" id="jform_metakey" value="" />
<input type="hidden" name="jform[params]" id="jform_params" value="" />
<input type="hidden" name="jform[questionnaireid]" id="jform_questionnaireid" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="jform[questionid]" id="jform_questionid" value="<?php echo $questionid; ?>" />
<input type="hidden" name="jform[questioningid]" id="jform_questioningid" value="<?php echo $question->questioningid; ?>" />
<input type="hidden" name="jform[answerid]" id="jform_answerid" value="" />
<input type="hidden" name="jform[id]" id="jform_id" value="<?php echo $this->item->id; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>