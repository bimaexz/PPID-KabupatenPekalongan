<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
if($this->item){
	JHtml::_('jquery.framework');
	JHtml::_('stylesheet', 'com_jmgquestionnaire/inputstyles/'.$this->item->style.'.css', array('version' => 'auto', 'relative' => true));
	JLoader::register('JmgQuestionnaireHelper', JPATH_ADMINISTRATOR . '/components/com_jmgquestionnaire/helpers/jmgquestionnaire.php');
	$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
	$invitation = JmgQuestionnaireHelper::checkInvitationId($this->app->input->getString('invitationid'));

	$style = array();
	$style[] = '.jmg-questionnaire-body ol.question li h4:before {';
	$style[] = 'color: ' . $this->item->nrtextcolor . ';';
	$style[] = 'background: ' . $this->item->nrbgcolor . ';';
	$style[] = '}';	
	$style[] = '.jmg-questionnaire-body ol.subquestion li h5:before {';
	$style[] = 'color: ' . $this->item->nrtextcolor . ';';
	$style[] = 'background: ' . $this->item->nrbgcolor . ';';
	$style[] = '}';
	$style[] = 'input[type="checkbox"]:checked,';
	$style[] = 'input[type="radio"]:checked {';
	$style[] = 'background-color: ' . $this->item->color . ';';
	$style[] = 'border-color: ' . $this->item->color . ';';
	$style[] = '}';

	$style = implode("\n", $style);
	JFactory::getDocument()->addStyleDeclaration( $style );	
}

?>
<?php if ($this->item) : ?>
<?php if ($this->item->showtitle) : ?>
<div class="item-title">
<h1 class="article-title"><?php echo $this->item->name; ?></h1>
</div>
<?php endif; ?>
<div class="jmg-questionnaire-body">
<?php if ($this->item->description) : ?>
	<div class="description">
	<?php echo $this->item->description; ?>
	</div>
<?php endif; ?>
	<?php // if user is authorised ?>
	<?php if (in_array($this->item->access,$authorised)) : ?>
		<?php // if only with invitation ?>
		<?php if ($this->item->invitation && !$invitation) : ?>
		<?php echo JText::_('COM_JMGQUESTIONNAIRE_INVITATION_REQUIRED'); ?>
		<?php else : ?>
		<form data-ajax="false" action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=questionnaire.submit'); ?>" method="post" enctype="multipart/form-data" class="form-validate form-horizontal" accept-charset="utf-8">
		<?php if (!$this->item->anonymous && $this->item->default_fields != '') : ?>
		<?php echo $this->loadTemplate('fields'); ?>
		<?php endif; ?>
		<?php echo $this->loadTemplate($this->item->template); ?>	
			<div class="control-group">
				<div class="control-label">&nbsp;</div>
				<div class="controls">
					<button type="submit" class="btn btn-primary validate">
						<?php echo JText::_('COM_JMGQUESTIONNAIRE_SEND'); ?>
					</button>
					<input type="hidden" name="option" value="com_jmgquestionnaire" />
					<input type="hidden" name="task" value="questionnaire.submit" />
					<input type="hidden" name="jform[questionnaire][invitationid]" value="<?php echo $this->app->input->getString('invitationid'); ?>" />
					<input type="hidden" name="jform[questionnaire][id]" value="<?php echo $this->item->id; ?>" />
					<input type="hidden" name="jform[questionnaire][userid]" value="<?php echo JFactory::getUser()->id; ?>" />
				</div>
			</div>
		<?php echo JHtml::_('form.token'); ?>
		</form>	
		<?php endif; ?>
	<?php else : ?>
	<?php echo JText::_('COM_JMGQUESTIONNAIRE_LOGIN_FIRST'); ?>
	<div class="moduletable">
		<?php	
		$doc	= JFactory::getDocument();
		$renderer	= $doc->loadRenderer('module');
		$params	= array();
		echo $renderer->render(JModuleHelper::getModule('mod_login'), $params);
		?>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>
<?php echo $this->loadTemplate('footer'); ?>