<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2020 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('stylesheet', 'com_jmgquestionnaire/jmgadmin.css', array('version' => 'auto', 'relative' => true));
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
		if (task == "record.cancel" || document.formvalidator.isValid(document.getElementById("record-form")))
		{
			Joomla.submitform(task, document.getElementById("record-form"));
		}
	};
');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="record-form" class="form-validate">
	<div class="form-horizontal">
	<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
	
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_JMGQUESTIONNAIRE_NEW') : JText::_('COM_JMGQUESTIONNAIRE_RESULT')); ?>
		<div class="<?php echo ($jversion == 3)? 'row-fluid' : 'row'; ?>">
			<div class="span9 col-lg-9">
				<div class="form-horizomtal">
					<?php echo $this->loadTemplate('record'); ?>
				</div>
			</div>
			<div class="span3 col-lg-3">
				
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
