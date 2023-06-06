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

$params  = $displayData['params'];
$width  = $displayData['width'];
$images  = json_decode($displayData['item']->img);
?>
<?php if (!empty($images->image)) : ?>
	<figure class="pull-left item-image col-md-<?php echo $width; ?>">
		<?php if ($params->get('fancy_effect', 1)) : ?>
		<a data-fancybox="gmapfp_image" href="<?php echo $images->image; ?>">
		<?php endif; ?>
			<img loading="lazy" src="<?php echo htmlspecialchars($images->image, ENT_COMPAT, 'UTF-8'); ?>"
				 alt="<?php echo htmlspecialchars($images->image_alt, ENT_COMPAT, 'UTF-8'); ?>"
				 itemprop="image" class="gmapfp-thumbnail img-thumbnail"/>
		<?php if ($params->get('fancy_effect', 1)) : ?>
		</a>
		<?php endif; ?>
		<?php if (isset($images->image_caption) && $images->image_caption !== '') : ?>
			<figcaption class="caption"><?php echo htmlspecialchars($images->image_caption, ENT_COMPAT, 'UTF-8'); ?></figcaption>
		<?php endif; ?>
	</figure>
<?php endif; ?>
