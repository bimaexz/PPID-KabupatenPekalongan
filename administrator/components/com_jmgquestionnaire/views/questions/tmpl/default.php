<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

HTMLHelper::_('behavior.multiselect');

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
$ordering   = ($listOrder == 'a.lft');
$saveOrder  = ($listOrder == 'a.lft' && strtolower($listDirn) == 'asc');

if ($saveOrder)
{
	if($jversion == 3){
		$saveOrderingUrl = 'index.php?option=com_jmgquestionnaire&task=questions.saveOrderAjax&tmpl=component';
		JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl, false, true);
	}
	else{
		$saveOrderingUrl = 'index.php?option=com_jmgquestionnaire&task=questions.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
		HTMLHelper::_('draggablelist.draggable');
	}
}
$contenttypes = array('',JText::_('COM_JMGQUESTIONNAIRE_CONTENTTYPE_OFFER'),JText::_('COM_JMGQUESTIONNAIRE_CONTENTTYPE_MODULE'))
?>		
<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&view=questions'); ?>" method="post" name="adminForm" id="adminForm">
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
							<?php echo JHtml::_('searchtools.sort', '', 'a.lft', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
						</th>
						<th width="1%" class="center">
							<?php echo JHtml::_('grid.checkall'); ?>
						</th>
						<th width="1%" class="nowrap center">
							<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_QUESTION', 'a.name', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_QUESTIONING_TECHNIQUE', 'a.questioningid', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_ANSWERS', 'a.answers', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'COM_JMGQUESTIONNAIRE_QUESTIONNAIRE_LABEL', 'a.questionnaireid', $listDirn, $listOrder); ?>
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
						<td colspan="10">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<?php if ($jversion == 3) : ?>
				<tbody>
				<?php else : ?>
				<tbody <?php if ($saveOrder) :?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" 
					   data-direction="<?php echo strtolower($listDirn); ?>" data-nested="false"<?php endif; ?>>
				<?php endif; ?>
					<?php foreach ($this->items as $i => $item) :
						$orderkey   = array_search($item->id, $this->ordering[$item->parent_id]);
						$item->cat_link = JRoute::_('index.php?option=com_categories&extension=com_jmgquestionnaire&task=edit&type=other&cid[]=' . $item->catid);
						$canCreate  = $user->authorise('core.create',     'com_jmgquestionnaire.category.' . $item->catid);
						$canEdit    = $user->authorise('core.edit',       'com_jmgquestionnaire.category.' . $item->catid);
						$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
						$canChange  = $user->authorise('core.edit.state', 'com_jmgquestionnaire.category.' . $item->catid) && $canCheckin;
					
						// create a list of the parents up the hierarchy to the root 
                        if ($item->level > 1)
                        {
                            $parentsStr = '';
                            $_currentParentId = $item->parent_id;
                            $parentsStr = ' ' . $_currentParentId;
                            for ($j = 0; $j < $item->level; $j++)
                            {
                                foreach ($this->ordering as $k => $v)
                                {
                                    $v = implode('-', $v);
                                    $v = '-' . $v . '-';
                                    if (strpos($v, '-' . $_currentParentId . '-') !== false)
                                    {
                                        $parentsStr .= ' ' . $k;
                                        $_currentParentId = $k;
                                        break;
                                    }
                                }
                            }
                        }
                        else
                        {
                            $parentsStr = '';
                        }
					
						?>
						<?php if ($jversion == 3) : ?>
						<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->parent_id; ?>"  
							item-id="<?php echo $item->id; ?>" parents="<?php echo $parentsStr; ?>" 
							level="<?php echo $item->level; ?>">
						<?php else : ?>
						<tr class="row<?php echo $i % 2; ?>" data-draggable-group="<?php echo $item->parent_id; ?>"
							data-item-id="<?php echo $item->id; ?>" data-parents="<?php echo $parentsStr; ?>"
							data-level="<?php echo $item->level; ?>">
						<?php endif; ?>
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
										value="<?php echo $item->lft; ?>" class="width-20 text-area-order" />
								<?php endif; ?>
							</td>
							<td class="center">
								<?php echo JHtml::_('grid.id', $i, $item->id); ?>
							</td>
							<td class="center">
								<div class="btn-group">
									<?php echo JHtml::_('jgrid.published', $item->state, $i, 'questions.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
									<?php // Create dropdown items and render the dropdown list.
									if ($canChange)
									{
										JHtml::_('actionsdropdown.' . ((int) $item->state === 2 ? 'un' : '') . 'archive', 'cb' . $i, 'questions');
										JHtml::_('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'questions');
										echo JHtml::_('actionsdropdown.render', $this->escape($item->name));
									}
									?>
								</div>
							</td>
							<td class="has-context">
								<div class="pull-left break-word">
									
									<?php $prefix = JLayoutHelper::render('joomla.html.treeprefix', array('level' => $item->level)); ?>
                                	<?php echo $prefix; ?>
									
									
									<?php if ($item->checked_out) : ?>
										<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'questions.', $canCheckin); ?>
									<?php endif; ?>
									<?php if ($canEdit) : ?>
										<a href="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=question.edit&id=' . (int) $item->id); ?>">
											<?php echo $this->escape($item->name); ?></a>
									<?php else : ?>
										<?php echo $this->escape($item->name); ?>
									<?php endif; ?>
									<span class="small break-word">
										<?php //echo $this->escape($item->ordering); ?>
									</span>
									<div class="small">
										
									</div>
								</div>
							</td>
							<td>
								<?php echo JmgQuestionnaireHelper::getQuestioningTechniques($item->questioningid); ?>
							</td>
							<td>
								<?php if ($item->questioningid == 1 || $item->questioningid == 2) : ?>
									<?php if ($item->answers) : ?>
									<?php echo $item->answers; ?>
									<?php else : ?>
									-
									<?php endif; ?>
								<?php elseif ($item->questioningid == 3) : ?>
									<?php echo JText::_('COM_JMGQUESTIONNAIRE_FREE_ANSWER'); ?>
								<?php elseif ($item->questioningid == 4) : ?>
									<?php echo JText::_('COM_JMGQUESTIONNAIRE_YES_OR_NO'); ?>
								<?php endif; ?>	
							</td>
							<td>
								<?php if ($canEdit) : ?>
								<a href="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=questionnaire.edit&id=' . (int) $item->questionnaireid); ?>">
								<?php echo $this->escape($item->questionnaire); ?></a>
								<?php else : ?>
								<?php echo $this->escape($item->questionnaire); ?>
								<?php endif; ?>
							</td>
							<td>
								<?php echo $this->escape($item->category_title); ?>
							</td>
							<td class="small nowrap hidden-phone">
								<?php echo JLayoutHelper::render('joomla.content.language', $item); ?>
							</td>
							<td class="hidden-phone">
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