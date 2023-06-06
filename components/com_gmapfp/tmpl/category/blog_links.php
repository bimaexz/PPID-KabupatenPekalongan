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

use Joomla\CMS\Router\Route;
use Joomla\Component\Gmapfp\Site\Helper\RouteHelper as GmapfpRoute;

?>

<ol class="com-gmapfp-category-blog__links nav nav-tabs nav-stacked">
	<?php foreach ($this->link_items as &$item) : ?>
		<li class="com-gmapfp-category-blog__link">
			<a href="<?php echo Route::_(GmapfpRoute::getItemRoute($item->slug, $item->catid, $item->language)); ?>">
				<?php echo $item->title; ?></a>
		</li>
	<?php endforeach; ?>
</ol>
