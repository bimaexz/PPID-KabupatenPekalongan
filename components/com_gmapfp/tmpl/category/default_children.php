<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Gmapfp\Site\Helper\RouteHelper as GmapfpRoute;

$lang   = Factory::getLanguage();
$user   = Factory::getUser();
$groups = $user->getAuthorisedViewLevels();
$perso='';
if($this->perso)
	$perso='&perso='.(int)$this->perso->id;
?>

<?php if (count($this->children[$this->category->id]) > 0) : ?>
	<?php foreach ($this->children[$this->category->id] as $id => $child) : ?>
		<?php // Check whether category access level allows access to subcategories. ?>
		<?php if (in_array($child->access, $groups)) : ?>
			<?php if ($this->params->get('show_empty_categories') || $child->getNumItems(true) || count($child->getChildren())) : ?>
			<div class="com-content-category__children">
				<?php if ($lang->isRtl()) : ?>
				<h3 class="page-header item-title">
					<?php if ( $this->params->get('show_cat_num_articles', 1)) : ?>
						<span class="badge badge-info tip hasTooltip" title="<?php echo HTMLHelper::_('tooltipText', 'COM_GMAPFP_NUM_ITEMS'); ?>">
							<?php echo $child->getNumItems(true); ?>
						</span>
					<?php endif; ?>
					<a href="<?php echo Route::_(GmapfpRoute::getCategoryRoute($child->id, $child->language, 'default')).$perso; ?>">
					<?php echo $this->escape($child->title); ?></a>

					<?php if (count($child->getChildren()) > 0 && $this->maxLevel > 1) : ?>
						<a href="#category-<?php echo $child->id; ?>" data-toggle="collapse" data-toggle="button" class="btn btn-sm float-right" aria-label="<?php echo Text::_('JGLOBAL_EXPAND_CATEGORIES'); ?>"><span class="icon-plus" aria-hidden="true"></span></a>
					<?php endif; ?>
				</h3>
				<?php else : ?>
				<h3 class="page-header item-title"><a href="<?php echo Route::_(GmapfpRoute::getCategoryRoute($child->id, $child->language, 'default')).$perso; ?>">
					<?php echo $this->escape($child->title); ?></a>
					<?php if ( $this->params->get('show_cat_num_articles', 1)) : ?>
						<span class="badge badge-info tip hasTooltip" title="<?php echo HTMLHelper::_('tooltipText', 'COM_GMAPFP_NUM_ITEMS'); ?>">
							<?php echo $child->getNumItems(true); ?>
						</span>
					<?php endif; ?>

					<?php if (count($child->getChildren()) > 0 && $this->maxLevel > 1) : ?>
						<a href="#category-<?php echo $child->id; ?>" data-toggle="collapse" data-toggle="button" class="btn btn-sm float-right" aria-label="<?php echo Text::_('JGLOBAL_EXPAND_CATEGORIES'); ?>"><span class="icon-plus" aria-hidden="true"></span></a>
					<?php endif; ?>
				</h3>
				<?php endif; ?>
				<?php if ($this->params->get('show_subcat_desc') == 1) : ?>
					<?php if ($child->description) : ?>
						<div class="category-desc">
							<?php echo HTMLHelper::_('content.prepare', $child->description, '', 'com_gmapfp.category'); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<?php if (count($child->getChildren()) > 0 && $this->maxLevel > 1) : ?>
				<div class="collapse fade" id="category-<?php echo $child->id; ?>">
					<?php
					$this->children[$child->id] = $child->getChildren();
					$this->category = $child;
					$this->maxLevel--;
					echo $this->loadTemplate('children');
					$this->category = $child->getParent();
					$this->maxLevel++;
					?>
				</div>
				<?php endif; ?>

			</div>
			<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
