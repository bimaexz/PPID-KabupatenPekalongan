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
		if (task == "respondent.cancel" || document.formvalidator.isValid(document.getElementById("respondent-form")))
		{
			Joomla.submitform(task, document.getElementById("respondent-form"));
		}
	};
');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="respondent-form" class="form-validate">
	<?php //echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
	<div class="form-horizontal">
	<?php if ($jversion == 3) : ?>
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', ['active' => 'details', 'recall' => true, 'breakpoint' => 768]); ?>
	<?php endif; ?>
	
	<?php if ($jversion == 3) : ?>	
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('COM_JMGQUESTIONNAIRE_RESPONDENT')); ?>
	<?php else : ?>
		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'details', Text::_('COM_JMGQUESTIONNAIRE_RESPONDENT')); ?>
	<?php endif; ?>
		<div class="<?php echo ($jversion == 3)? 'row-fluid' : 'row'; ?>">
			<div class="span1 col-lg-1">
				<div class="image">
					<?php if ($this->item->image) : ?>
					<img src="<?php echo JURI::root().$this->item->image; ?>" />
					<?php else : ?>
					<img src="<?php echo JURI::root().'/media/com_jmgquestionnaire/img/avatar.png'; ?>" />	
					<?php endif; ?>
				</div>
			</div>
			<div class="span3 col-lg-3">
				<div class="form-horizomtal">
					<h3>
						<?php if ($this->item->name) : ?>
						<?php echo $this->item->name; ?>
						<?php elseif ($this->item->firstname || $this->item->surname) : ?>
						<?php echo $this->item->firstname; ?> <?php echo $this->item->surname; ?>
						<?php else : ?>
						<?php echo JText::_('COM_JMGQUESTIONNAIRE_NONAME'); ?>
						<?php endif; ?>		
					</h3>
					<p><?php echo $this->item->street; ?></p>
					<p><?php echo $this->item->postal_code; ?> <?php echo $this->item->city; ?></p>
					<p><?php echo $this->item->stateid; ?></p>
					<p><?php echo $this->item->countryid; ?></p>
					<p><?php echo $this->item->phone; ?></p>
					<p><?php echo $this->item->email; ?></p>
				</div>
			</div>
			<div class="span8 col-lg-8">
				<?php echo $this->loadTemplate('questionnaires'); ?>
			</div>
		</div>
	<?php echo ($jversion == 3)? JHtml::_('bootstrap.endTab') : HTMLHelper::_('uitab.endTab'); ?>
	<?php echo ($jversion == 3)? JHtml::_('bootstrap.endTabSet') : HTMLHelper::_('uitab.endTabSet'); ?>
	</div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
