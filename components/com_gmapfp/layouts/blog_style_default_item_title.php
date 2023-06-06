<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_9F
	* Creation date: Octobre 2022
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Component\Gmapfp\Site\Helper\RouteHelper as GmapfpRoute;

// Create a shortcut for params.
$params  = $displayData->params;
$canEdit = $displayData->params->get('access-edit');
$app = Factory::getApplication();
$view_blog = ($app->input->get('view') === 'category');
$currentDate = Factory::getDate()->format('Y-m-d H:i:s');

?>

<?php if ($displayData->state == 0 || $params->get('show_title',1) || ($params->get('show_author',1) && !empty($displayData->author ))) : ?>
	<div class="page-header">
		<?php if ($params->get('show_title',1)) : ?>
			<h2 itemprop="name">
				<?php if ($params->get('link_titles', 1) && ($params->get('access-view') || $params->get('show_noauth', '0') == '1') && $view_blog) : ?>
					<a href="<?php echo Route::_(
						GmapfpRoute::getItemRoute($displayData->slug, $displayData->catid, $displayData->language)
					); ?>" itemprop="url">
						<?php echo $this->escape($displayData->title); ?>
					</a>
				<?php else : ?>
					<?php echo $this->escape($displayData->title); ?>
				<?php endif; ?>
			</h2>
		<?php endif; ?>

		<?php if ($displayData->state == 0) : ?>
			<span class="badge badge-warning"><?php echo Text::_('JUNPUBLISHED'); ?></span>
		<?php endif; ?>

        <?php if ($displayData->publish_up > $currentDate) : ?>
			<span class="badge badge-warning"><?php echo Text::_('JNOTPUBLISHEDYET'); ?></span>
		<?php endif; ?>

        <?php if ($displayData->publish_down !== null && $displayData->publish_down < $currentDate) : ?>
			<span class="badge badge-warning"><?php echo Text::_('JEXPIRED'); ?></span>
		<?php endif; ?>
		<div class="gmapfp_main_icons d-flex">
			<?php if ($params->get('show_map_form', 1)) : ?>
				<?php echo LayoutHelper::render('icon_map', array('params' => $params, 'item' => $displayData)); ?>
			<?php endif; ?>
			<?php if ($params->get('show_hp_form', 1)) : ?>
				<?php echo LayoutHelper::render('icon_hp', array('params' => $params, 'item' => $displayData)); ?>
			<?php endif; ?>
			<?php if ($params->get('show_email_form', 1)) : ?>
				<?php echo LayoutHelper::render('icon_email', array('params' => $params, 'item' => $displayData)); ?>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
