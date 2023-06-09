<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$blockPosition = $displayData['params']->get('info_block_position', 0);

?>


		<?php if ($displayData['position'] == 'above' && ($blockPosition == 0 || $blockPosition == 2)
				|| $displayData['position'] == 'below' && ($blockPosition == 1)
				) : ?>

			<!-- <dt class="article-info-term"></dt> -->	
			<?php if ($displayData['params']->get('show_category')) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block_details.category', $displayData); ?>
			<?php endif; ?>
			
			

			<!-- <?php //if ($displayData['params']->get('show_publish_date')) : ?>
				<?php //echo JLayoutHelper::render('joomla.content.info_block_details.publish_date', $displayData); ?>
			<?php //endif; ?> -->

			<!--
			<?php //if ($displayData['params']->get('show_author') && !empty($displayData['item']->author )) : ?>
				<?php //echo JLayoutHelper::render('joomla.content.info_block_details.author', $displayData); ?>
			<?php //endif; ?> -->
			
			<!-- <?php //if ($displayData['params']->get('show_parent_category') && !empty($displayData['item']->parent_slug)) : ?>
				<?php //echo JLayoutHelper::render('joomla.content.info_block_details.parent_category', $displayData); ?>
			<?php //endif; ?> -->

			

			<?php echo JLayoutHelper::render('joomla.content.comments.comments_count', $displayData); //Helix Comment Count ?>
			<?php echo JLayoutHelper::render('joomla.content.info_block_details.rating', $displayData) ?>
			

		<?php endif; ?>

		<?php if ($displayData['position'] == 'above' && ($blockPosition == 0)
				|| $displayData['position'] == 'below' && ($blockPosition == 1 || $blockPosition == 2)
				) : ?>
			
			<?php if ($displayData['params']->get('show_hits')) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block_details.hits', $displayData); ?>
			<?php endif; ?>

			<?php if ($displayData['params']->get('show_create_date')) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block_details.create_date', $displayData); ?>
			<?php endif; ?>

			<?php if ($displayData['params']->get('show_modify_date')) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block_details.modify_date', $displayData); ?>
			<?php endif; ?>
			<?php if ($displayData['params']->get('show_tags') && !empty($displayData['item']->tags->itemTags) ) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block_details.tags', $displayData['item']->tags->itemTags); ?>
			<?php endif; ?>

		<?php endif; ?>
