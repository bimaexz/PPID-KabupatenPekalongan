<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$saveOrderingUrl = 'index.php?option=com_jmgquestionnaire&task=questions.saveOrderAjax&tmpl=component';
echo JHtml::_('sortablelist.sortable', 'questionlist', 'questionaddform', 'asc', $saveOrderingUrl, false, true);
$questionid = JFactory::getApplication()->input->get('questionid');
$questions = JmgQuestionnaireHelper::getQuestionsByQuestionnaireId($this->item->id);
?>
<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=questionnaire.questionadd'); ?>" id="questionaddform" class="form-horizontal" name="questionaddform" method="post" enctype="multipart/form-data">
<div class="jmg-answers form-horizomtal">
<?php echo $this->form->renderFieldset('questionsettings'); ?>
	
<div class="control-group">
	<div class="control-label"><label></label>
	</div>
	<div class="controls">
		<button type="submit" class="btn btn-success validate">
		<?php echo JText::_('COM_JMGQUESTIONNAIRE_SAVE_QUESTION'); ?>
		</button>	
	</div>
</div>
	
</div>
<input type="hidden" name="option" value="com_jmgquestionnaire" />
<input type="hidden" name="task" value="questionnaire.questionadd" />
<input type="hidden" name="jform[state]" id="jform_state" value="1" />
<input type="hidden" name="jform[description]" id="jform_description" value="" />
<input type="hidden" name="jform[ordering]" id="jform_ordering" value="<?php echo count($questions) + 1; ?>" />
<input type="hidden" name="jform[metakey]" id="jform_metakey" value="" />
<input type="hidden" name="jform[params]" id="jform_params" value="" />
<input type="hidden" name="jform[language]" id="jform_language" value="*" />
<input type="hidden" name="jform[questionnaireid]" id="jform_questionnaireid" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>

