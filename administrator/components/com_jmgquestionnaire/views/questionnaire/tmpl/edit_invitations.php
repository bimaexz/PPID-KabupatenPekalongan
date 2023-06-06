<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$invitations = JmgQuestionnaireHelper::getInvitationsByQuestionnaireId($this->item->id);
$bytes = random_bytes(30);
$invitationid = bin2hex($bytes);
?>
<?php //echo JPATH_SITE . '/components/com_jmgquestionnaire/'; ?>
<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=questionnaire.invitationadd'); ?>" id="invitationaddForm" class="form-inline" name="invitationaddForm" method="post" enctype="multipart/form-data">
	<table class="table table-striped" id="articleList">
		<thead>
			<tr>
				<th class="nowrap">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_QUESTION_NR'); ?>
				</th>
				<th class="nowrap">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_EMAIL'); ?>
				</th>
				<th class="nowrap">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_INVITATION_ID'); ?>
				</th>
				<th class="nowrap">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_INVITATION_DATE'); ?>
				</th>
				<th class="nowrap center">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_INVITATION_ACCEPTED'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
							
				</td>
			</tr>
		</tfoot>
		<tbody>


<?php foreach ($invitations as $i => $invitation) : ?>
	<tr>
		<td>
			<?php echo $i + 1; ?>.
		</td>
		<td>
			<?php if ($invitation->accepted) : ?>
			<a href="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=survey.edit&id=' . (int) $invitation->surveyid); ?>">
			<?php echo $invitation->email; ?>
			</a>
			<?php else : ?>
			<?php echo $invitation->email; ?>
			<?php endif; ?>
		</td>
		<td>
			<?php echo substr($invitation->invitationid, 0, 15); ?>...
		</td>
		<td>
			<?php echo JHtml::_('date', $invitation->created, 'd.m.Y H:i', 'utc'); ?>
		</td>
		<td class="center">
			<?php if ($invitation->accepted) : ?>
			<span class="icon icon-checkbox-partial"></span>
			<?php else : ?>
			<span class="icon icon-checkbox-unchecked"></span>	
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
	<tr>
		<td>
			
		</td>
		<td>
			<input type="text" class="form-control input-large" name="jform[email]" id="jform_email"  value="" size="40"/>
			<button type="submit" class="btn btn-primary validate">
			<?php echo JText::_('COM_JMGQUESTIONNAIRE_INVITE'); ?>
			</button>
		</td>
		<td>
			
		</td>
		<td>
			
		</td>
		<td>
		
		</td>
	</tr>			
	</tbody>
</table>
<input type="hidden" name="option" value="com_jmgquestionnaire" />
<input type="hidden" name="task" value="questionnaire.invitationadd" />
<input type="hidden" name="jform[questionnaireid]" id="jform_questionnaireid" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="jform[invitationid]" id="jform_invitationid" value="<?php echo $invitationid; ?>" />
<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>