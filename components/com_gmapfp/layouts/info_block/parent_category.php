<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Gmapfp\Site\Helper\RouteHelper as GmapfpRoute;

?>
<dd class="parent-category-name">
	<?php $title = $this->escape($displayData['item']->parent_title); ?>
	<?php if ($displayData['params']->get('link_parent_category') && !empty($displayData['item']->parent_id)) : ?>
		<?php $url = '<a href="' . Route::_(
			GmapfpRoute::getCategoryRoute($displayData['item']->parent_id, $displayData['item']->parent_language)
			)
			. '" itemprop="genre">' . $title . '</a>'; ?>
		<?php echo Text::sprintf('COM_GMAPFP_PARENT', $url); ?>
	<?php else : ?>
		<?php echo Text::sprintf('COM_GMAPFP_PARENT', '<span itemprop="genre">' . $title . '</span>'); ?>
	<?php endif; ?>
</dd>