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
JHtml::_('jquery.framework');
JHtml::_('stylesheet', 'com_jmgquestionnaire/jmgadmin.css', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'com_jmgquestionnaire/answermanager.js', array('version' => 'auto', 'relative' => true));
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.formvalidator');

$j = new JVersion();
$jversion = substr($j->getShortVersion(), 0,1);
if($jversion == 3){
	//JHtml::_('formbehavior.chosen', '#jform_catid', null, array('disable_search_threshold' => 0 ));
	JHtml::_('formbehavior.chosen', 'select');
	JHtml::_('behavior.tabstate');
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
<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="question-form" class="form-validate">
	<?php //echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
	<div class="form-horizontal">
	<?php if ($jversion == 3) : ?>
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'questions')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', ['active' => 'questions', 'recall' => true, 'breakpoint' => 768]); ?>
	<?php endif; ?>
		
	<?php if ($jversion == 3) : ?>	
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('COM_JMGQUESTIONNAIRE_SETTINGS')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'details', Text::_('COM_JMGQUESTIONNAIRE_SETTINGS')); ?>
	<?php endif; ?>
	
		<div class="<?php echo ($jversion == 3)? 'row-fluid' : 'row'; ?>">
			<div class="span9 col-lg-9">
				<div class="form-horizomtal">
					<?php $this->form->setFieldAttribute('showon','questionid',$this->item->parent_id); ?>
					<?php $this->form->setFieldAttribute('showon','questioningid',JmgQuestionnaireHelper::getParentQuestioningIdByParentId($this->item->parent_id)); ?>
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
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'answers', JText::_('COM_JMGQUESTIONNAIRE_ANSWERS')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'answers', Text::_('COM_JMGQUESTIONNAIRE_ANSWERS')); ?>
	<?php endif; ?>
		
		<div class="<?php echo ($jversion == 3)? 'row-fluid' : 'row'; ?> form-horizontal-desktop">
			<div class="span9 col-lg-9">
				<?php if ($this->item->id) : ?>
					<?php echo $this->loadTemplate('answers_'.$this->item->questioningid); ?>
				<?php endif; ?>
			</div>
			<div class="span3 col-lg-3">
				
			</div>
		</div>
	<?php echo ($jversion == 3)? JHtml::_('bootstrap.endTab') : HTMLHelper::_('uitab.endTab'); ?>
	<?php echo ($jversion == 3)? JHtml::_('bootstrap.endTabSet') : HTMLHelper::_('uitab.endTabSet'); ?>
	</div>
