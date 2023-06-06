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

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$params    = $displayData['params'];
$item      = $displayData['item'];
$direction = Factory::getLanguage()->isRtl() ? 'left' : 'right';
?>

<p class="readmore">
	<?php if (!$params->get('access-view')) : ?>
		<a class="btn btn-secondary" href="<?php echo $displayData['link']; ?>" itemprop="url" aria-label="<?php echo Text::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
			<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
			<?php echo '<span class="fa fa-chevron-' . $direction . '" aria-hidden="true"></span>'; ?>
			<?php echo Text::_('COM_GMAPFP_REGISTER_TO_READ_MORE'); ?>
		</a>
	<?php elseif ($readmore = $item->alternative_readmore) : ?>
		<a class="btn btn-secondary" href="<?php echo $displayData['link']; ?>" itemprop="url" aria-label="<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
			<?php echo '<span class="fa fa-chevron-' . $direction . '" aria-hidden="true"></span>'; ?> 
			<?php echo $readmore; ?>
			<?php if ($params->get('show_readmore_title',1) != 0) : ?>
				<?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit',100)); ?>
			<?php endif; ?>
		</a>
	<?php elseif ($params->get('show_readmore_title',1) == 0) : ?>
		<a class="btn btn-secondary" href="<?php echo $displayData['link']; ?>" itemprop="url" aria-label="<?php echo Text::_('COM_CONTENT_READ_MORE'); ?> <?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
			<?php echo '<span class="fa fa-chevron-' . $direction . '" aria-hidden="true"></span>'; ?> 
			<?php echo Text::sprintf('COM_GMAPFP_READ_MORE_TITLE'); ?>
		</a>
	<?php else : ?>
		<a class="btn btn-secondary" href="<?php echo $displayData['link']; ?>" itemprop="url" aria-label="<?php echo Text::_('COM_CONTENT_READ_MORE'); ?> <?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
			<?php echo '<span class="fa fa-chevron-' . $direction . '" aria-hidden="true"></span>'; ?> 
			<?php echo Text::_('COM_GMAPFP_READ_MORE'); ?>
			<?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit',100)); ?>
		</a>
	<?php endif; ?>
</p>
