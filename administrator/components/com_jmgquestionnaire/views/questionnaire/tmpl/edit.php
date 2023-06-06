<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
JHtml::_('jquery.framework');
$questionid = JFactory::getApplication()->input->get('questionid');

JHtml::_('stylesheet', 'com_jmgquestionnaire/jmgadmin.css', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'com_jmgquestionnaire/questionmanager.js', array('version' => 'auto', 'relative' => true));
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.formvalidator');
$j = new JVersion();
$jversion = substr($j->getShortVersion(), 0,1);
if($jversion == 3){
	JHtml::_('formbehavior.chosen', 'select');
}

JHtml::_('bootstrap.modal');

JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if(task == "questionnaire.trashquestion")
		{
			//alert(document.getElementById("adminForm").innerHTML;
			//Joomla.submitform(task, document.getElementById("adminForm"));
			document.getElementById("adminForm").submit();
		}
		else if (task == "questionnaire.cancel" || document.formvalidator.isValid(document.getElementById("questionnaire-form")))
		{
			Joomla.submitform(task, document.getElementById("questionnaire-form"));
		}
	};
	Joomla.childsubmitbutton = function(task)
	{
		document.getElementById("question_modal").getElementsByTagName("iframe")[0].contentWindow.Joomla.submitbutton(task);
	};
	
	function questionsrefresh() {	
	var request = {
              "option" 		: "com_jmgquestionnaire",
              "view" 		: "questionnaire",
			  "tmpl"		: "component",
			  "layout"		: "edit_questions",
              "id" 			: "'.$this->item->id.'",
			  "format" 		: "json"
          };
	jQuery.ajax({
			//url: "index.php",
			type: "post",
			data: request,
			dataType: "html",
			async: true,
			success: function(response){
				jQuery(".jmg-questions-area").html(jQuery(response));
				jQuery(".select-question").on("click", function(){
					var id = jQuery(this).attr("data-id");
					jQuery( "#jform_questionid" ).val(id);
					jQuery("#questioneditform").submit();
				});
			}
	});	
}
');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm1" id="questionnaire-form" class="form-validate">
	<?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
	<div class="form-horizontal">
		
	<?php if ($jversion == 3) : ?>
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'questions')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', ['active' => 'questions', 'recall' => true, 'breakpoint' => 768]); ?>
	<?php endif; ?>
	
	<?php if ($jversion == 3) : ?>	
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'settings', JText::_('COM_JMGQUESTIONNAIRE_SETTINGS')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'settings', Text::_('COM_JMGQUESTIONNAIRE_SETTINGS')); ?>
	<?php endif; ?>
		
		<div class="<?php echo ($jversion == 3)? 'row-fluid' : 'row'; ?> form-horizontal-desktop">
			<div class="span9 col-lg-9">
				<?php echo $this->form->renderFieldset('settings'); ?>
				<?php //echo $this->form->renderFieldset('request'); ?>
			</div>
			<div class="span3 col-lg-3">
				<?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
			</div>
		</div>
	<?php echo ($jversion == 3)? JHtml::_('bootstrap.endTab') : HTMLHelper::_('uitab.endTab'); ?>
		
	<?php if ($jversion == 3) : ?>	
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'description', JText::_('JGLOBAL_DESCRIPTION')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'description', Text::_('JGLOBAL_DESCRIPTION')); ?>
	<?php endif; ?>

	<div class="<?php echo ($jversion == 3)? 'row-fluid' : 'row'; ?>">
			<div class="span9 col-lg-9">
				<div class="form-vertical">
					<?php echo $this->form->renderField('description'); ?>
				</div>
			</div>
			<div class="span3 col-lg-3">
				
			</div>
		</div>
	<?php echo ($jversion == 3)? JHtml::_('bootstrap.endTab') : HTMLHelper::_('uitab.endTab'); ?>
		
	<?php if ($jversion == 3) : ?>	
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'style', JText::_('COM_JMGQUESTIONNAIRE_STYLE')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'style', Text::_('COM_JMGQUESTIONNAIRE_STYLE')); ?>
	<?php endif; ?>

	<div class="<?php echo ($jversion == 3)? 'row-fluid' : 'row'; ?>">
			<div class="span9 col-lg-9">
				<div class="form-horizontal-desktop">
					<?php echo $this->form->renderFieldset('style'); ?>
				</div>
			</div>
			<div class="span3 col-lg-3">
				
			</div>
		</div>
	<?php echo ($jversion == 3)? JHtml::_('bootstrap.endTab') : HTMLHelper::_('uitab.endTab'); ?>
		
	<?php if ($jversion == 3) : ?>	
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('JGLOBAL_FIELDSET_PUBLISHING')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'publishing', Text::_('JGLOBAL_FIELDSET_PUBLISHING')); ?>
	<?php endif; ?>

		<div class="<?php echo ($jversion == 3)? 'row-fluid' : 'row'; ?> form-horizontal-desktop">
			<div class="span6 col-lg-6">
				<?php echo JLayoutHelper::render('joomla.edit.publishingdata', $this); ?>
			</div>
			<div class="span6 col-lg-6">
				<?php echo JLayoutHelper::render('joomla.edit.metadata', $this); ?>
			</div>
		</div>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php echo ($jversion == 3)? JHtml::_('bootstrap.endTab') : HTMLHelper::_('uitab.endTab'); ?>
	
	<?php if ($jversion == 3) : ?>	
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'questions', JText::_('COM_JMGQUESTIONNAIRE_QUESTIONS')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'questions', Text::_('COM_JMGQUESTIONNAIRE_QUESTIONS')); ?>
	<?php endif; ?>
		
		<div class="<?php echo ($jversion == 3)? 'row-fluid' : 'row'; ?> form-horizontal-desktop">
			<div class="span8 col-lg-8">
				<div class="jmg-questions-area">
				<?php if ($this->item->id) : ?>
					<?php echo $this->loadTemplate('questions'); ?>
				<?php endif; ?>
				</div>
			</div>
			<div class="span4 col-lg-4">
				<?php if ($this->item->id && !$questionid) : ?>
					<?php //echo $this->loadTemplate('newquestions'); ?>
				<?php elseif ($this->item->id && $questionid) : ?>
					<?php echo $this->loadTemplate('answers'); ?>
				<?php endif; ?>
			</div>
		</div>
	<?php echo ($jversion == 3)? JHtml::_('bootstrap.endTab') : HTMLHelper::_('uitab.endTab'); ?>
	
	<?php if ($jversion == 3) : ?>	
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'invitations', JText::_('COM_JMGQUESTIONNAIRE_INVITATIONS')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'invitations', Text::_('COM_JMGQUESTIONNAIRE_INVITATIONS')); ?>
	<?php endif; ?>
	
		<div class="<?php echo ($jversion == 3)? 'row-fluid' : 'row'; ?> form-horizontal-desktop">
			<div class="span9 col-lg-9">
				<?php if ($this->item->id) : ?>
					<?php echo $this->loadTemplate('invitations'); ?>
				<?php endif; ?>
			</div>
			<div class="span3 col-lg-3">
				
			</div>
		</div>
	<?php echo ($jversion == 3)? JHtml::_('bootstrap.endTab') : HTMLHelper::_('uitab.endTab'); ?>
	<?php echo ($jversion == 3)? JHtml::_('bootstrap.endTabSet') : HTMLHelper::_('uitab.endTabSet'); ?>
	</div>

<?php echo HTMLHelper::_(
	'bootstrap.renderModal',
	'question_modal', // selector
	array( // options
		'modal-dialog-scrollable' => true,
		'title'  => JText::_('COM_JMGQUESTIONNAIRE_ADD_QUESTION'),
		'bodyHeight'  => '70',
		'modalWidth'  => '80',
		'url'         => 'index.php?option=com_jmgquestionnaire&view=question&tmpl=component&layout=modal&questionnaireid='.$this->item->id,
		'footer'      => '<button id="closeBtn" type="button" class="btn" data-bs-dismiss="modal" data-dismiss="modal" aria-hidden="true">' . JText::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>
		<button id="saveBtn" type="button" class="btn btn-primary" data-dismiss="" aria-hidden="" onclick="Joomla.childsubmitbutton(\'question.save2new\');">' . JText::_('COM_JMGQUESTIONNAIRE_SAVE2NEW') . '</button>
		<button id="applyBtn" type="button" class="btn btn-success" data-dismiss="" aria-hidden="" onclick="Joomla.childsubmitbutton(\'question.apply\');">' . JText::_('JSAVE') . '</button>',
	)
); ?>
