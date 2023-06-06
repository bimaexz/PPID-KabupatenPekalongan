<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2020 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('jquery.framework');
JHtml::_('behavior.formvalidator');

$j = new JVersion();
$jversion = substr($j->getShortVersion(), 0,1);

$messages = JFactory::getApplication()->getMessageQueue();

if($messages && is_array($messages[0]) && $messages[0]['type'] == 'message'){
	if(isset($this->item->id)){
		JFactory::getDocument()->addScriptDeclaration('
			window.parent.questionsrefresh();
			window.parent.jQuery("#question_modal").modal("hide");
		');		
	}
	else{
		JFactory::getDocument()->addScriptDeclaration('
			window.parent.questionsrefresh();
		');
	}
}

JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "question.cancel" || document.formvalidator.isValid(document.getElementById("question-form")))
		{
			Joomla.submitform(task, document.getElementById("question-form"));
		}
	};
');
?>
<div class="container-popup">
	<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&tmpl=component&layout=modal&questionnaireid='.JFactory::getApplication()->input->get('questionnaireid')); ?>" method="post" name="adminForm" id="question-form" class="form-validate">
		<div class="form-horizontal">
			<div class="<?php echo ($jversion == 3)? 'row-fluid' : 'row'; ?>">
				<div class="span9 col-lg-9">
					<div class="form-horizomtal">
						<?php $this->form->setValue('questionnaireid', $group = NULL, JFactory::getApplication()->input->get('questionnaireid')); ?>
						<?php echo $this->form->renderFieldSet('settings'); ?>
					</div>
				</div>
				<div class="span3 col-lg-3 form-vertical">
					<?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
					<?php echo $this->form->renderField('questionsordering'); ?>
					<?php echo $this->form->renderField('image'); ?>
					<?php echo $this->form->renderField('imagepos'); ?>
					<?php echo $this->form->renderField('level'); ?>
					<?php echo $this->form->renderField('lft'); ?>
					<?php echo $this->form->renderField('rgt'); ?>
				</div>
			</div>
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</form>
</div>