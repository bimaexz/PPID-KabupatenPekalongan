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
	JLoader::register('JmgQuestionnaireHelper', JPATH_ADMINISTRATOR . '/components/com_jmgquestionnaire/helpers/jmgquestionnaire.php');
	JHtml::_('jquery.framework');
	JHtml::_('script', 'com_jmgquestionnaire/multistep.js', array('version' => 'auto', 'relative' => true));
	JHtml::_('stylesheet', 'com_jmgquestionnaire/inputstyles/'.$this->item->style.'.css', array('version' => 'auto', 'relative' => true));
	$app = JFactory::getApplication('site');
	$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
	$invitation = JmgQuestionnaireHelper::checkInvitationId($this->app->input->getString('invitationid'));
	$steps = (!$this->item->anonymous && $this->item->default_fields != '')? count($this->steps) + 1 : count($this->steps);
	$currentstep = $this->state->get('questionnaire.step');

	$style = array();
	if($this->item->numbering){
		$style[] = '.jmg-questionnaire-body ol.question li h4:before{';
		$style[] = 'content:"' . ($currentstep + 1) . '.";';
		$style[] = 'color: ' . $this->item->nrtextcolor . ';';
		$style[] = 'background: ' . $this->item->nrbgcolor . ';';
		$style[] = '}';	
		$style[] = '.jmg-questionnaire-body ol.subquestion li h5:before{';
		$style[] = 'content:"' . ($currentstep + 1) . '." counter(list-item, lower-alpha)".";';
		$style[] = 'color: ' . $this->item->nrtextcolor . ';';
		$style[] = 'background: ' . $this->item->nrbgcolor . ';';
		$style[] = '}';	
	}
	$style[] = '.jmg-questionnaire-body .question-steps .step.active::after{';
	$style[] = 'background: ' . $this->item->nrbgcolor . ' none repeat scroll 0% 0%;';
	$style[] = '}';
	$style[] = '.jmg-questionnaire-body .question-steps .step.done{';
	$style[] = 'background: ' . $this->item->nrbgcolor . ' url("'.JURI::root().'media/com_jmgquestionnaire/img/check.png") no-repeat scroll center center / 20px;';
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
		
		<div class="question-steps">
			<div class="line"></div>
			<?php for($i = 0; $i < $steps; $i++) : ?>
			<?php if ($i < $currentstep) : ?>
			<div class="step done"></div>
			<?php elseif ($i == $currentstep) : ?>
			<div class="step active"></div>
			<?php else : ?>
			<div class="step"></div>
			<?php endif; ?>
			<?php endfor; ?>
		</div>
	
		<?php if (($currentstep + 1) > $steps) : ?>
			<h2 style="text-align: center; margin-bottom: 100px; "><?php echo JText::_('COM_JMGQUESTIONNAIRE_FINISHED'); ?></h2>
		<?php endif; ?>
	
		<form data-ajax="false" action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&view=question&task=question.step'); ?>" method="post" enctype="multipart/form-data" class="form-validate form-horizontal" id="multistepform" accept-charset="utf-8">
		<?php if (!$this->item->anonymous && $this->item->default_fields != '' && ($currentstep + 1) == $steps) : ?>
		<?php echo $this->loadTemplate('fields'); ?>
		<?php endif; ?>
		<?php echo $this->loadTemplate($this->item->template); ?>	
			<div class="control-group">
					<?php if ($currentstep == 0) : ?>
					<button type="button" class="btn btn-default validate" disabled>
						<?php echo JText::_('COM_JMGQUESTIONNAIRE_BACK'); ?>
					</button>
					<?php elseif ($currentstep == $steps) : ?>
					
					<?php else : ?>
					<button type="button" class="btn btn-default validate back">
						<?php echo JText::_('COM_JMGQUESTIONNAIRE_BACK'); ?>
					</button>
					<?php endif; ?>
					<?php if ($currentstep < $steps - 1) : ?>
					<button type="submit" class="btn btn-primary validate">
						<?php echo JText::_('COM_JMGQUESTIONNAIRE_CONTINUE'); ?>
					</button>
					<?php elseif ($currentstep == $steps) : ?>
					
					<?php else : ?>
					<button type="submit" class="btn btn-primary validate">
						<?php echo JText::_('COM_JMGQUESTIONNAIRE_SEND'); ?>
					</button>
					<?php endif; ?>
					<input type="hidden" name="option" value="com_jmgquestionnaire" />
					<input type="hidden" name="task" value="question.step" />
					<input type="hidden" id="currentstep" name="currentstep" value="<?php echo $currentstep; ?>" />
					<input type="hidden" id="nextstep" name="nextstep" value="<?php echo $currentstep + 1; ?>" />
					<input type="hidden" id="laststep" name="laststep" value="<?php echo $steps; ?>" />
					<input type="hidden" name="jform[questionnaire][invitationid]" value="<?php echo $this->app->input->getString('invitationid'); ?>" />
					<input type="hidden" name="jform[questionnaire][id]" value="<?php echo $this->item->id; ?>" />
					<input type="hidden" name="jform[questionnaire][userid]" value="<?php echo JFactory::getUser()->id; ?>" />
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