<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
$j = new JVersion();
$jversion = substr($j->getShortVersion(), 0,1);
if($jversion == 3){
	JHtml::_('formbehavior.chosen', 'select');
}

$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'a.ordering';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_jmgquestionnaire&task=records.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$contenttypes = array('',JText::_('COM_JMGQUESTIONNAIRE_CONTENTTYPE_OFFER'),JText::_('COM_JMGQUESTIONNAIRE_CONTENTTYPE_MODULE'))
?>		
<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&view=records'); ?>" method="post" name="adminForm" id="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php
		// Search tools bar
		echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
		?>
		<?php if (empty($this->items)) : ?>
			<div class="alert alert-no-items">
				<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
			</div>
		<?php else : ?>
			<table class="table table-striped" id="articleList">
				<thead>
					<tr>
						<th width="1%" class="center">
							<?php echo JHtml::_('grid.checkall'); ?>
						</th>
						<th>
							<?php echo JText::_('COM_JMGQUESTIONNAIRE_UNIQUEID'); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_RESPONDENT', 'a.respondent', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_QUESTIONNAIRE_LABEL', 'a.questionnaireid', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_QUESTION', 'a.questionid', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'JCATEGORY', 'a.catid', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="nowrap hidden-phone">
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_LANGUAGE', 'a.language', $listDirn, $listOrder); ?>
						</th>
						<th width="1%" class="nowrap hidden-phone">
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_CREATED', 'a.created', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="8">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach ($this->items as $i => $item) :
						$ordering  = ($listOrder == 'ordering');
						$item->cat_link = JRoute::_('index.php?option=com_categories&extension=com_jmgquestionnaire&task=edit&type=other&cid[]=' . $item->catid);
						$canCreate  = $user->authorise('core.create',     'com_jmgquestionnaire.category.' . $item->catid);
						$canEdit    = $user->authorise('core.edit',       'com_jmgquestionnaire.category.' . $item->catid);
						$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
						$canChange  = $user->authorise('core.edit.state', 'com_jmgquestionnaire.category.' . $item->catid) && $canCheckin;
						?>
						<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->catid; ?>">
							<td class="center">
								<?php echo JHtml::_('grid.id', $i, $item->id); ?>
							</td>
							<td class="has-context">
								<div class="pull-left break-word">
									<?php if ($item->checked_out) : ?>
										<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'records.', $canCheckin); ?>
									<?php endif; ?>
									<?php if ($canEdit) : ?>
										<a href="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=record.edit&id=' . (int) $item->id); ?>">
											<?php echo substr($this->escape($item->uniqueid), 0, 15); ?>...
										</a>
									<?php else : ?>
										<?php echo substr($this->escape($item->uniqueid), 0, 15); ?>...
									<?php endif; ?>
									<span class="small break-word">
										
									</span>
									<div class="small">
										
									</div>
								</div>
							</td>
							<td>
								<?php if ($item->respondent) : ?>
								<?php echo $this->escape($item->respondent); ?>
								<?php else : ?>
								<?php echo JText::_('COM_JMGQUESTIONNAIRE_ANONYMOUS'); ?>
								<?php endif; ?>
							</td>
							<td>
								<?php echo $this->escape($item->questionnaire); ?>
							</td>
							<td>
								<?php echo $this->escape($item->question); ?>
							</td>
							<td>
								<?php echo $this->escape($item->category_title); ?>
							</td>
							<td class="small nowrap hidden-phone">
								<?php echo JLayoutHelper::render('joomla.content.language', $item); ?>
							</td>
							<td class="nowrap">
								<?php echo JHtml::_('date', $item->created, 'd.m.Y H:i', 'utc'); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		
		<?php endif; ?>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />	
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>