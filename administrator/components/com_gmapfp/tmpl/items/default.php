<?php 
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_2F
	* Creation date: Juillet 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die;

use Joomla\CMS\Button\ActionButton;
use Joomla\CMS\Button\PublishedButton;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\Component\Content\Administrator\Helper\ContentHelper;

$app       = Factory::getApplication();
$user      = Factory::getUser();
$userId    = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'a.ordering';

if (strpos($listOrder, 'publish_up') !== false)
{
	$orderingColumn = 'publish_up';
}
elseif (strpos($listOrder, 'publish_down') !== false)
{
	$orderingColumn = 'publish_down';
}
elseif (strpos($listOrder, 'modified') !== false)
{
	$orderingColumn = 'modified';
}
else
{
	$orderingColumn = 'created';
}

if ($saveOrder && !empty($this->items))
{
	$saveOrderingUrl = 'index.php?option=com_gmapfp&task=items.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
	HTMLHelper::_('draggablelist.draggable');
}

$collection = new \stdClass;

$collection->publish = [];
$collection->unpublish = [];
$collection->archive = [];
$collection->trash = [];

$assoc = Associations::isEnabled();

?>
<form action="<?php echo JRoute::_('index.php?option=com_gmapfp&view=items'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row">
		<div class="col-md-12">
			<div id="j-main-container" class="j-main-container">
				<?php
				// Search tools bar
				echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this));
				?>
				<?php if (empty($this->items)) : ?>
					<div class="alert alert-info">
						<span class="fa fa-info-circle" aria-hidden="true"></span><span class="sr-only"><?php echo Text::_('INFO'); ?></span>
						<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
					</div>
				<?php else : ?>
					<table class="table" id="articleList">
						<caption id="captionTable" class="sr-only">
							<?php echo Text::_('COM_GMAPFP_ARTICLES_TABLE_CAPTION'); ?>, <?php echo Text::_('JGLOBAL_SORTED_BY'); ?>
						</caption>
						<thead>
							<tr>
								<td style="width:1%" class="text-center">
									<?php echo HTMLHelper::_('grid.checkall'); ?>
								</td>
								<td scope="col" style="width:1%" class="nowrap text-center d-none d-md-table-cell">
									<?php echo HTMLHelper::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
								</td>
								<td scope="col" style="width:1%" class="text-center d-none d-md-table-cell">
									<?php echo HTMLHelper::_('searchtools.sort', 'JFEATURED', 'a.featured', $listDirn, $listOrder); ?>
								</td>
								<td scope="col" style="width:1%" class="nowrap text-center">
									<?php echo HTMLHelper::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
								</td>
								<td scope="col" >
									<?php echo HTMLHelper::_('searchtools.sort', 'COM_GMAPFP_NOM', 'a.title', $listDirn, $listOrder); ?>
								</td>
								<td scope="col" >
									<?php echo HTMLHelper::_('searchtools.sort', 'COM_GMAPFP_VILLE', 'a.ville', $listDirn, $listOrder); ?>
								</td>
								<td scope="col" >
									<?php echo HTMLHelper::_('searchtools.sort', 'COM_GMAPFP_DEPARTEMENT', 'a.departement', $listDirn, $listOrder); ?>
								</td>
								<td scope="col" >
									<?php echo HTMLHelper::_('searchtools.sort', 'COM_GMAPFP_PAYS', 'a.pays', $listDirn, $listOrder); ?>
								</td>
								<td scope="col" >
									<?php echo HTMLHelper::_('searchtools.sort', 'JAUTHOR', 'u.name', $listDirn, $listOrder); ?>
								</td>
								<td scope="col" style="width:5%" class="nowrap d-none d-md-table-cell text-center">
									<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
								</td>
							</tr>
						</thead>
						<tbody <?php if ($saveOrder) :?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="<?php echo strtolower($listDirn); ?>" data-nested="true"<?php endif; ?>>
						<?php foreach ($this->items as $i => $item) :
							$item->max_ordering = 0;
							$ordering   = ($listOrder == 'a.ordering');
							$canCreate  = $user->authorise('core.create', 'com_gmapfp.category.' . $item->catid);
							$canEdit    = $user->authorise('core.edit', 'com_gmapfp.article.' . $item->id);
							$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
							$canEditOwn = $user->authorise('core.edit.own', 'com_gmapfp.article.' . $item->id) && $item->created_by == $userId;
							$canChange  = $user->authorise('core.edit.state', 'com_gmapfp.article.' . $item->id) && $canCheckin;
							$canEditCat       = $user->authorise('core.edit',       'com_gmapfp.category.' . $item->catid);
							$canEditOwnCat    = $user->authorise('core.edit.own',   'com_gmapfp.category.' . $item->catid) && $item->category_uid == $userId;
							$canEditParCat    = $user->authorise('core.edit',       'com_gmapfp.category.' . $item->parent_category_id);
							$canEditOwnParCat = $user->authorise('core.edit.own',   'com_gmapfp.category.' . $item->parent_category_id) && $item->parent_category_uid == $userId;

							$publish = 0;
							$unpublish = 0;
							$archive = 0;
							$trash = 0;

							?>
							<tr class="row<?php echo $i % 2; ?>" data-dragable-group="<?php echo $item->catid; ?>"
								data-condition-publish="<?php echo (int) $publish > 0; ?>"
								data-condition-unpublish="<?php echo (int) $unpublish > 0; ?>"
								data-condition-archive="<?php echo (int) $archive > 0; ?>"
								data-condition-trash="<?php echo (int) $trash > 0; ?>"
							>
								<td class="text-center">
									<?php echo HTMLHelper::_('grid.id', $i, $item->id, false, 'cid', 'cb', $item->title); ?>
								</td>
								<td class="text-center d-none d-md-table-cell">
									<?php
									$iconClass = '';
									if (!$canChange)
									{
										$iconClass = ' inactive';
									}
									elseif (!$saveOrder)
									{
										$iconClass = ' inactive" title="' . Text::_('JORDERINGDISABLED');
									}
									?>
									<span class="sortable-handler<?php echo $iconClass ?>">
										<span class="fa fa-ellipsis-v" aria-hidden="true"></span>
									</span>
									<?php if ($canChange && $saveOrder) : ?>
										<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order">
									<?php endif; ?>
								</td>
								<td class="text-center d-none d-md-table-cell">
									<?php echo HTMLHelper::_('gmapfpadministrator.featured', $item->featured, $i, $canChange); ?>
								</td>
								<td class="text-center">
									<div class="btn-group">
										<?php
											$options = [
												'task_prefix' => 'items.',
												'disabled' => !$canChange,
												'id' => $item->id
											];
											echo (new PublishedButton)->render((int) $item->state, $i, $options, $item->publish_up, $item->publish_down);
										?>
									</div>
								</td>
								<td  class="nowrap">
									<div class="break-word">
										<?php if ($item->checked_out) : ?>
											<?php echo HTMLHelper::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'items.', $canCheckin); ?>
										<?php endif; ?>
										<?php if ($canEdit || $canEditOwn) : ?>
											<?php $editIcon = $item->checked_out ? '' : '<span class="fa fa-pencil-square mr-2" aria-hidden="true"></span>'; ?>
											<a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_gmapfp&task=item.edit&id=' . (int) $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?> <?php echo $this->escape(addslashes($item->title)); ?>">
												<?php echo $editIcon; ?><?php echo $this->escape($item->title); ?></a>
										<?php else : ?>
											<?php echo $this->escape($item->nom); ?>
										<?php endif; ?>
										<span class="small break-word">
											<?php if (empty($item->note)) : ?>
												<?php echo Text::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias)); ?>
											<?php else : ?>
												<?php echo Text::sprintf('JGLOBAL_LIST_ALIAS_NOTE', $this->escape($item->alias), $this->escape($item->note)); ?>
											<?php endif; ?>
										</span>
										<div class="small">
											<?php echo JText::_('JCATEGORY') . ': ' . $this->escape($item->category_title); ?>
										</div>
									</div>
								</td>
								<td >
									<?php echo $item->ville; ?>
								</td>
								<td >
									<?php echo $item->departement; ?>
								</td>
								<td >
									<?php echo $item->pays; ?>
								</td>
								<td >
									<?php echo $item->auteur; ?>
								</td>
								<td class="d-none d-lg-table-cell">
									<?php echo (int) $item->id; ?>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>

					<?php // load the pagination. ?>
					<?php echo $this->pagination->getListFooter(); ?>

					<?php // Load the batch processing form. ?>
					<?php if ($user->authorise('core.create', 'com_gmapfp')
						&& $user->authorise('core.edit', 'com_gmapfp')
						&& $user->authorise('core.edit.state', 'com_gmapfp')) : ?>
						<?php echo HTMLHelper::_(
							'bootstrap.renderModal',
							'collapseModal',
							array(
								'title'  => Text::_('COM_GMAPFP_BATCH_OPTIONS'),
								'footer' => $this->loadTemplate('batch_footer')
							),
							$this->loadTemplate('batch_body')
						); ?>
					<?php endif; ?>
				<?php endif; ?>
				<div class="copyright" align="center">
					<br />
					<?php echo Text::_( 'COM_GMAPFP_COPYRIGHT' );?>
				</div>
				<input type="hidden" name="task" value="" />
				<input type="hidden" name="boxchecked" value="0" />
				<?php echo HTMLHelper::_( 'form.token' ); ?>
			</div>
		</div>
	</div>
</form>
