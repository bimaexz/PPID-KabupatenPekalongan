<?php 
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_1F
	* Creation date: Avril 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access'); 

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

$app = Factory::getApplication();

if ($app->isClient('site'))
{
	Session::checkToken('get') or die(Text::_('JINVALID_TOKEN'));
}


/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('com_gmapfp.admin-personnalisations-modal');

$function  = $app->input->getCmd('function', 'jSelectItem');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));

?>
<form action="<?php echo JRoute::_('index.php?option=com_gmapfp&view=personnalisations&layout=modal&tmpl=component&function=' . $function . '&' . Session::getFormToken() . '=1'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row">
		<div class="col-md-12">
			<div id="j-main-container" class="j-main-container">
				<?php
				echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this));
				?>
				<?php if (empty($this->items)) : ?>
					<div class="alert alert-info">
						<span class="fa fa-info-circle" aria-hidden="true"></span><span class="sr-only"><?php echo Text::_('INFO'); ?></span>
						<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
					</div>
				<?php else : ?>
					<table class="table table-striped" id="articleList">
						<thead>
							<tr>
								<th scope="col" style="width:1%; min-width:85px" class="text-center">
									<?php echo HTMLHelper::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
								</th>
								<th>
									<?php echo HTMLHelper::_('searchtools.sort', 'COM_GMAPFP_NOM', 'a.nom', $listDirn, $listOrder); ?>
								</th>
								<th style="width:5%" class="nowrap d-none d-md-table-cell text-center">
									<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
								</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td colspan="13">
									<?php echo $this->pagination->getListFooter(); ?>
								</td>
							</tr>
						</tfoot>
						<tbody>
							<?php
							$iconStates = array(
								-2 => 'fas fa-trash',
								0  => 'fas fa-times',
								1  => 'fas fa-check',
								2  => 'fas fa-folder',
							);
							?>
							<?php
							$k = 0;
							for ($i=0, $n=count( $this->items ); $i < $n; $i++)
							{
								$item = $this->items[$i];
							?>
								<tr class="<?php echo "row$k"; ?>">
									<td class="text-center tbody-icon">
										<span class="<?php echo $iconStates[$this->escape($item->state)]; ?>" aria-hidden="true"></span>
									</td>
									<td  class="nowrap">
										<div class="break-word">
											<a href="javascript:void(0)" onclick="if (window.parent) window.parent.<?php echo $this->escape($function); ?>('<?php echo $item->id; ?>', '<?php echo $this->escape(addslashes($item->name)); ?>', null, '<?php echo $this->escape($item->id); ?>', null, null);">
												<?php echo $this->escape($item->name); ?></a>
										</div>
									</td>
									<td align="center">
										<?php echo $item->id; ?>
									</td>
								</tr>
								<?php
								$k = 1 - $k;
							}
							?>
						</tbody>
					</table>
				<?php endif; ?>
				<div class="copyright" align="center">
					<br />
					<?php echo JText::_( 'COM_GMAPFP_COPYRIGHT' );?>
				</div>
				<input type="hidden" name="task" value="" />
				<input type="hidden" name="boxchecked" value="0" />
				<?php echo HTMLHelper::_('form.token'); ?>
			</div>
		</div>
	</div>
</form>
