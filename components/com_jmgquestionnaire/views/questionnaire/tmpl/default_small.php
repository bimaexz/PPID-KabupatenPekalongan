<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmqquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JHtml::_('stylesheet', 'com_jmgquestionnaire/small/questionnaire.css', array('version' => 'auto', 'relative' => true));
// Prepare a mapping from parent id to the ids of its children
$mapping = array();
foreach ($this->questions as $question)
{
    $mapping[$question->parent_id][] = $question->id;
}
?>
<div class="jmg-questionnaire-body">
	<ol class="question">
	<?php foreach ($this->questions as $i => $question) : ?>
		<?php if ($question->level == 1) : ?>
		<li>
			<div class="jmgq <?php echo $question->imagepos; ?>">
				<?php if ($question->image && $question->imagepos != 'bottom') : ?>
				<div class="area img">
					<img src="<?php echo JURI::root().$question->image; ?>" />
				</div>
				<?php endif; ?>
				<div class="area txt">
					<h4><?php echo $question->name; ?></h4>
					<p class="explaination"><?php echo $question->explanation; ?></p>
					<?php if ($question->image && $question->imagepos == 'bottom') : ?>
					<div class="img">	
						<img src="<?php echo JURI::root().$question->image; ?>" />
					</div>	
					<?php endif; ?>
					<?php switch($question->questioningid) : case 1 : ?>
						<?php // single choice ?>
						<?php $answers = JmgQuestionnaireHelper::getAnswersByQuestionId($question->id); ?>
						<ul class="answer">
						<?php foreach ($answers as $i => $answer) : ?>
						<input type="hidden" id="jform_question<?php echo $question->id; ?>" name="jform[questionnaire][questions][question<?php echo $question->id; ?>][questionid]" value="<?php echo $question->id; ?>">
						<li>
							<input class="main" type="radio" id="jform_question<?php echo $question->id; ?>" name="jform[questionnaire][questions][question<?php echo $question->id; ?>][answers][answer<?php echo $question->id; ?>]" value="<?php echo $answer->id; ?>"> <?php echo $answer->name; ?>
						</li>
						<?php endforeach; ?>
						</ul>
					<?php break; case 2 : ?>
						<?php // multiple choice ?>
						<?php $answers = JmgQuestionnaireHelper::getAnswersByQuestionId($question->id); ?>
						<ul class="answer">
						<?php foreach ($answers as $i => $answer) : ?>
						<input type="hidden" id="jform_question<?php echo $question->id; ?>" name="jform[questionnaire][questions][question<?php echo $question->id; ?>][questionid]" value="<?php echo $question->id; ?>">
						<li>
							<input type="checkbox" id="jform_question<?php echo $question->id; ?>" name="jform[questionnaire][questions][question<?php echo $question->id; ?>][answers][answer<?php echo $answer->id; ?>]" value="<?php echo $answer->id; ?>"> <?php echo $answer->name; ?>
						</li>
						<?php endforeach; ?>
						</ul>
					<?php break; case 3 : ?>
					<?php // open question ?>
						<input type="hidden" id="jform_question<?php echo $question->id; ?>" name="jform[questionnaire][questions][question<?php echo $question->id; ?>][questionid]" value="<?php echo $question->id; ?>">
						<textarea id="jform_question<?php echo $question->id; ?>" name="jform[questionnaire][questions][question<?php echo $question->id; ?>][answer]"></textarea>
					<?php break; case 4 : ?>
					<?php // closed question ?>
						<ul class="answer">
						<input type="hidden" id="jform_question<?php echo $question->id; ?>" name="jform[questionnaire][questions][question<?php echo $question->id; ?>][questionid]" value="<?php echo $question->id; ?>">
						<li>
							<input class="main" type="radio" id="jform_question<?php echo $question->id; ?>" name="jform[questionnaire][questions][question<?php echo $question->id; ?>][answers][answer<?php echo $question->id; ?>]" value="-1"> <?php echo JText::_('JYES'); ?>
						</li>
						<li>
							<input class="main" type="radio" id="jform_question<?php echo $question->id; ?>" name="jform[questionnaire][questions][question<?php echo $question->id; ?>][answers][answer<?php echo $question->id; ?>]" value="-2"> <?php echo JText::_('JNO'); ?>
						</li>
						</ul>
					<?php break; default : ?>
					<?php endswitch; ?>
					<?php if (isset($mapping[$question->id])) : ?>
						<ol class="subquestion question-<?php echo $question->id; ?>">
							<?php foreach ($this->questions as $i => $subquestion) : ?>
							<?php if (in_array($subquestion->id, $mapping[$question->id])) : ?>
							<?php $class = ($subquestion->showon)? 'qstn-0' : 'qstn-1'; ?>
							<li class="sqstn <?php echo $class; ?>" data-showon="<?php echo $subquestion->showon; ?>">
								<h5><?php echo $subquestion->name; ?></h5>
								<p class="explaination"><?php echo $subquestion->explanation; ?></p>
								<?php switch($subquestion->questioningid) : case 1 : ?>
									<?php // single choice ?>
									<?php $answers = JmgQuestionnaireHelper::getAnswersByQuestionId($subquestion->id); ?>
									<ul class="answer">
									<?php foreach ($answers as $i => $answer) : ?>
									<input type="hidden" id="jform_question<?php echo $subquestion->id; ?>" name="jform[questionnaire][questions][question<?php echo $subquestion->id; ?>][questionid]" value="<?php echo $subquestion->id; ?>">
									<li>
										<input type="radio" id="jform_question<?php echo $subquestion->id; ?>" name="jform[questionnaire][questions][question<?php echo $subquestion->id; ?>][answers][answer<?php echo $subquestion->id; ?>]" value="<?php echo $answer->id; ?>"> <?php echo $answer->name; ?>
									</li>
									<?php endforeach; ?>
									</ul>
								<?php break; case 2 : ?>
									<?php // multiple choice ?>
									<?php $answers = JmgQuestionnaireHelper::getAnswersByQuestionId($subquestion->id); ?>
									<ul class="answer">
									<?php foreach ($answers as $i => $answer) : ?>
									<input type="hidden" id="jform_question<?php echo $subquestion->id; ?>" name="jform[questionnaire][questions][question<?php echo $subquestion->id; ?>][questionid]" value="<?php echo $subquestion->id; ?>">
									<li>
										<input type="checkbox" id="jform_question<?php echo $subquestion->id; ?>" name="jform[questionnaire][questions][question<?php echo $subquestion->id; ?>][answers][answer<?php echo $answer->id; ?>]" value="<?php echo $answer->id; ?>"> <?php echo $answer->name; ?>
									</li>
									<?php endforeach; ?>
									</ul>
								<?php break; case 3 : ?>
								<?php // open question ?>
									<input type="hidden" id="jform_question<?php echo $subquestion->id; ?>" name="jform[questionnaire][questions][question<?php echo $subquestion->id; ?>][questionid]" value="<?php echo $subquestion->id; ?>">
									<textarea id="jform_question<?php echo $subquestion->id; ?>" name="jform[questionnaire][questions][question<?php echo $subquestion->id; ?>][answer]"></textarea>
								<?php break; case 4 : ?>
								<?php // closed question ?>
									<ul class="answer">
									<input type="hidden" id="jform_question<?php echo $subquestion->id; ?>" name="jform[questionnaire][questions][question<?php echo $subquestion->id; ?>][questionid]" value="<?php echo $subquestion->id; ?>">
									<li>
										<input type="radio" id="jform_question<?php echo $subquestion->id; ?>" name="jform[questionnaire][questions][question<?php echo $subquestion->id; ?>][answers][answer]" value="-1"> <?php echo JText::_('JYES'); ?>
									</li>
									<li>
										<input type="radio" id="jform_question<?php echo $subquestion->id; ?>" name="jform[questionnaire][questions][question<?php echo $subquestion->id; ?>][answers][answer]" value="-2"> <?php echo JText::_('JNO'); ?>
									</li>
									</ul>
								<?php break; default : ?>
								<?php endswitch; ?>
							</li>
							<?php endif; ?>
							<?php endforeach; ?>
						</ol>
					<?php endif; ?>
				</div>
			</div>
		</li>
		<?php endif; ?>
	<?php endforeach; ?>
	</ol>
</div>