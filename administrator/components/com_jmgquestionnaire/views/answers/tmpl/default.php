<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('stylesheet', 'com_jmgquestionnaire/jmgadmin.css', array('version' => 'auto', 'relative' => true));
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
	$saveOrderingUrl = 'index.php?option=com_jmgquestionnaire&task=answers.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$contenttypes = array('',JText::_('COM_JMGQUESTIONNAIRE_CONTENTTYPE_OFFER'),JText::_('COM_JMGQUESTIONNAIRE_CONTENTTYPE_MODULE'))
?>		
<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&view=answers'); ?>" method="post" name="adminForm" id="adminForm">
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
						<th width="1%" class="nowrap center hidden-phone">
							<?php echo JHtml::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
						</th>
						<th width="1%" class="center">
							<?php echo JHtml::_('grid.checkall'); ?>
						</th>
						<th width="1%" class="nowrap center">
							<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_ANSWER', 'a.name', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_QUESTION', 'a.questionid', $listDirn, $listOrder); ?>
						</th>
						<th class="center">
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_CORRECT', 'a.statementid', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_POINTS', 'a.points', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_QUESTIONNAIRE_LABEL', 'a.contenttype', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'JCATEGORY', 'a.catid', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="nowrap hidden-phone">
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_LANGUAGE', 'a.language', $listDirn, $listOrder); ?>
						</th>
						<th width="1%" class="nowrap hidden-phone">
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_ID', 'a.id', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="11">
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
						<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->questionid; ?>">
							<td class="order nowrap center hidden-phone">
								<?php
								$iconClass = '';

								if (!$canChange)
								{
									$iconClass = ' inactive';
								}
								elseif (!$saveOrder)
								{
									$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::_('tooltipText', 'JORDERINGDISABLED');
								}
								?>
								<span class="sortable-handler <?php echo $iconClass ?>">
									<span class="icon-menu" aria-hidden="true"></span>
								</span>
								<?php if ($canChange && $saveOrder) : ?>
									<input type="text" style="display:none" name="order[]" size="5"
										value="<?php echo $item->ordering; ?>" class="width-20 text-area-order" />
								<?php endif; ?>
							</td>
							<td class="center">
								<?php echo JHtml::_('grid.id', $i, $item->id); ?>
							</td>
							<td class="center">
								<div class="btn-group">
									<?php echo JHtml::_('jgrid.published', $item->state, $i, 'answers.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
									<?php // Create dropdown items and render the dropdown list.
									if ($canChange)
									{
										JHtml::_('actionsdropdown.' . ((int) $item->state === 2 ? 'un' : '') . 'archive', 'cb' . $i, 'answers');
										JHtml::_('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'answers');
										echo JHtml::_('actionsdropdown.render', $this->escape($item->name));
									}
									?>
								</div>
							</td>
							<td class="has-context">
								<div class="pull-left break-word">
									<?php if ($item->checked_out) : ?>
										<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'answers.', $canCheckin); ?>
									<?php endif; ?>
									<?php if ($canEdit) : ?>
										<a href="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=answer.edit&id=' . (int) $item->id); ?>">
											<?php echo $this->escape($item->name); ?></a>
									<?php else : ?>
										<?php echo $this->escape($item->name); ?>
									<?php endif; ?>
									<span class="small break-word">
										
									</span>
									<div class="small">
										
									</div>
								</div>
							</td>
							<td>
								<?php echo $this->escape($item->question); ?>
							</td>
							<td class="center">
								<?php if ($item->questioningid == 1) : ?>
									<?php if ($item->statement == 1) : ?>
									<span class="icon icon-radio-checked"></span>
									<?php else : ?>
									<span class="icon-radio-unchecked"></span>	
									<?php endif; ?>
								<?php else : ?>
									<?php if ($item->statement == 1) : ?>
									<span class="icon icon-checkbox-partial"></span>
									<?php else : ?>
									<span class="icon icon-checkbox-unchecked"></span>	
									<?php endif; ?>
								<?php endif; ?>
							</td>
							<td>
								<?php if ($item->score && $item->statement == 1) : ?>
									<?php echo $item->score; ?>
								<?php else: ?>
								 - 
								<?php endif; ?>
							</td>
							<td>
								<?php echo $this->escape($item->questionnaire); ?>
							</td>
							<td>
								<?php echo $this->escape($item->category_title); ?>
							</td>
							<td>
								<?php echo JLayoutHelper::render('joomla.content.language', $item); ?>
							</td>
							<td>
								<?php echo $item->id; ?>
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