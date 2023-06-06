<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_5F
	* Creation date: Novembre 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\Component\Gmapfp\Site\Helper\RouteHelper as GmapfpRouteHelper;
use Joomla\CMS\Table\Table;

HTMLHelper::_('behavior.multiselect');

$app = Factory::getApplication();

if ($app->isClient('site'))
{
	Session::checkToken('get') or die(Text::_('JINVALID_TOKEN'));
}

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa ->useScript('keepalive')
	->useScript('com_gmapfp.admin-plugin-modal');

$function  = $app->input->getCmd('function', 'jSelectItems');
$editor    = $app->input->getCmd('editor', '');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$catlistOrder = $this->escape($this->state->get('catlist.ordering'));
$catlistDirn  = $this->escape($this->state->get('catlist.direction'));
$onclick   = $this->escape($function);
$multilang = Multilanguage::isEnabled();

if (!empty($editor))
{
	// This view is used also in com_menus. Load the xtd script only if the editor is set!
	$this->document->addScriptOptions('xtd-gmapfpmap', array('editor' => $editor));
	$onclick = "jSelectItems";
}
?>
<div class="container-popup ">
	<form onsubmit="window.<?php echo $function; ?>(this)" action="<?php echo Route::_('index.php?option=com_gmapfp&view=xtd_button&layout=modal&tmpl=component&function=' . $function . '&' . Session::getFormToken() . '=1'); ?>" method="post" name="adminForm" id="adminForm">
		<?php echo Text::_('COM_GMAPFP_SELECT_XTD_BUTTON_DESC'); ?>
		<button class="btn btn-primary" onclick="submit()"><?php echo Text::_('JSUBMIT'); ?></button>
		<div class="row">
			<div class="col-lg-6">
				<fieldset id="j-main-container" class="options-form">
					<legend><?php echo Text::_('COM_GMAPFP_LIEUX'); ?></legend>
					<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

					<?php if (empty($this->items)) : ?>
						<div class="alert alert-info">
							<span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
							<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
						</div>
					<?php else : ?>
						<table class="table table itemList" id="itemList">
							<caption id="captionTable" class="sr-only">
								<?php echo Text::_('COM_GMAPFP_ARTICLES_TABLE_CAPTION'); ?>, <?php echo Text::_('JGLOBAL_SORTED_BY'); ?>
							</caption>
							<thead>
								<tr>
									<th class="w-1 text-center">
										<div style="display:none;"><?php echo HTMLHelper::_('grid.checkall'); ?></div>
									</th>
									<th scope="col" style="width:1%" class="text-center">
										<?php echo HTMLHelper::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
									</th>
									<th scope="col" class="title">
										<?php echo HTMLHelper::_('searchtools.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
									</th>
									<th scope="col" class="w-10 d-none d-md-table-cell">
										<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ACCESS', 'access_level', $listDirn, $listOrder); ?>
									</th>
									<th scope="col" class="w-15 d-none d-md-table-cell">
										<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_LANGUAGE', 'language_title', $listDirn, $listOrder); ?>
									</th>
									<th scope="col" style="width:1%" class="d-none d-md-table-cell">
										<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$iconStates = array(
								-2 => 'fas fa-trash',
								0  => 'fas fa-times',
								1  => 'fas fa-check',
								2  => 'fas fa-folder',
							);
							?>
							<?php foreach ($this->items as $i => $item) : ?>
								<?php if ($item->language && $multilang)
								{
									$tag = strlen($item->language);
									if ($tag == 5)
									{
										$lang = substr($item->language, 0, 2);
									}
									elseif ($tag == 6)
									{
										$lang = substr($item->language, 0, 3);
									}
									else {
										$lang = '';
									}
								}
								elseif (!$multilang)
								{
									$lang = '';
								}
								?>
								<tr class="row<?php echo $i % 2; ?>"
									data-transitions=""
								>
									<td class="text-center">
										<?php echo HTMLHelper::_('grid.id', $i, $item->id, false, 'cid', 'cb', $item->title); ?>
									</td>
									<td class="text-center">
										<span class="tbody-icon">
											<span class="<?php echo $iconStates[$this->escape($item->state)]; ?>" aria-hidden="true"></span>
										</span>
									</td>
									<td scope="row">
										<div>
											<?php echo $this->escape($item->title); ?>
										</div>
										<div class="small">
											<?php echo Text::_('JCATEGORY') . ': ' . $this->escape($item->category_title); ?>
										</div>
									</td>
									<td class="small d-none d-md-table-cell">
										<?php echo $this->escape($item->access_level); ?>
									</td>
									<td class="small d-none d-md-table-cell">
										<?php echo LayoutHelper::render('joomla.content.language', $item); ?>
									</td>
									<td>
										<?php echo (int) $item->id; ?>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>

					<?php endif; ?>
				</fieldset>
			</div>
			<div class="col-lg-6">
				<fieldset id="j-main-catcontainer" class="options-form">
					<legend><?php echo Text::_('JCATEGORIES'); ?></legend>
					<?php if (empty($this->categories)) : ?>
						<div class="alert alert-info">
							<span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
							<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
						</div>
					<?php else : ?>
						<table class="table  table itemList" id="categoryList">
							<thead>
								<tr>
									<th class="w-1 text-center">
										<?php echo Text::_(''); ?>
									</th>
									<th scope="col" class="w-1 text-center">
										<?php echo Text::_('JSTATUS'); ?>
									</th>
									<th scope="col">
										<?php echo Text::_('JGLOBAL_TITLE'); ?>
									</th>
									<th scope="col" class="w-10 d-none d-md-table-cell">
										<?php echo Text::_('JGRID_HEADING_ACCESS'); ?>
									</th>
									<th scope="col" class="w-15 d-none d-md-table-cell">
										<?php echo Text::_('JGRID_HEADING_LANGUAGE'); ?>
									</th>
									<th scope="col" class="w-1 d-none d-md-table-cell">
										<?php echo Text::_('JGRID_HEADING_ID'); ?>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$iconStates = array(
									-2 => 'icon-trash',
									0  => 'icon-times',
									1  => 'icon-check',
									2  => 'icon-folder',
								);
								?>
								<?php foreach ($this->categories as $i => $categorie) : ?>
									<?php if ($categorie->language && Multilanguage::isEnabled())
									{
										$tag = strlen($categorie->language);
										if ($tag == 5)
										{
											$lang = substr($categorie->language, 0, 2);
										}
										elseif ($tag == 6)
										{
											$lang = substr($categorie->language, 0, 3);
										}
										else
										{
											$lang = '';
										}
									}
									elseif (!Multilanguage::isEnabled())
									{
										$lang = '';
									}
									?>
									<tr class="row<?php echo $i % 2; ?>">
										<td class="text-center">
											<?php echo HTMLHelper::_('grid.id', $i, $categorie->id, false, 'catid', 'catcb', $categorie->title); ?>
										</td>
										<td class="text-center">
											<span class="tbody-icon">
												<span class="<?php echo $iconStates[$this->escape($categorie->published)]; ?>" aria-hidden="true"></span>
											</span>
										</td>
										<td scope="row">
											<?php echo LayoutHelper::render('joomla.html.treeprefix', array('level' => $categorie->level)); ?>
											<div>
												<?php echo $this->escape($categorie->title); ?>
											</div>
										</td>
										<td class="small d-none d-md-table-cell">
											<?php echo $this->escape($categorie->access_level); ?>
										</td>
										<td class="small d-none d-md-table-cell">
											<?php echo LayoutHelper::render('joomla.content.language', $categorie); ?>
										</td>
										<td class="d-none d-md-table-cell">
											<?php echo (int) $categorie->id; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>

					<?php endif; ?>
				</fieldset>
				<input type="hidden" name="task" value="">
				<input type="hidden" name="boxchecked" value="0">
				<input type="hidden" name="forcedLanguage" value="<?php echo $app->input->get('forcedLanguage', '', 'CMD'); ?>">
				<?php echo HTMLHelper::_('form.token'); ?>
			</div>
		</div>
	</form>
</div>