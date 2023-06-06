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
// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('jquery.framework');
JHtml::_('behavior.formvalidator');
$j = new JVersion();
$jversion = substr($j->getShortVersion(), 0,1);
if($jversion == 3){
	//JHtml::_('formbehavior.chosen', '#jform_catid', null, array('disable_search_threshold' => 0 ));
	JHtml::_('formbehavior.chosen', 'select');
}

JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "answer.cancel" || document.formvalidator.isValid(document.getElementById("answer-form")))
		{
			Joomla.submitform(task, document.getElementById("answer-form"));
		}
	};
');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="answer-form" class="form-validate">
	<?php //echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
	<div class="form-horizontal">
	<?php if ($jversion == 3) : ?>
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', ['active' => 'details', 'recall' => true, 'breakpoint' => 768]); ?>
	<?php endif; ?>
	
	<?php if ($jversion == 3) : ?>	
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('COM_JMGQUESTIONNAIRE_SETTINGS')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'details', Text::_('COM_JMGQUESTIONNAIRE_SETTINGS')); ?>
	<?php endif; ?>
		<div class="<?php echo ($jversion == 3)? 'row-fluid' : 'row'; ?>">
			<div class="span9 col-lg-9">
				<div class="form-horizomtal">
					<?php echo $this->form->renderFieldSet('settings'); ?>
				</div>
			</div>
			<div class="span3 col-lg-3">
				<?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
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
	<?php echo ($jversion == 3)? JHtml::_('bootstrap.endTab') : HTMLHelper::_('uitab.endTab'); ?>
	<?php echo ($jversion == 3)? JHtml::_('bootstrap.endTabSet') : HTMLHelper::_('uitab.endTabSet'); ?>
	</div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
