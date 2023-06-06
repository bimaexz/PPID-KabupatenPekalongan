<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

?>
<div class="entry-header-block" itemprop="author" itemscope itemtype="http://schema.org/Person">

	<div class="article-info-item-wrap">
		<i class="fa fa-user"></i>
		<?php $author = ($displayData->created_by_alias ? $displayData->created_by_alias : $displayData->author); ?>
		<?php $author = '<span itemprop="name" data-toggle="tooltip" title="' . JText::sprintf('COM_CONTENT_WRITTEN_BY', '') . '">' . $author . '</span>'; ?>
		<div class="entry-time-wrapper">
			<?php if (!empty($displayData->contact_link ) && $displayData->params->get('link_author') == true) : ?>
				<?php echo JHtml::_('link', $displayData->contact_link, $author, array('itemprop' => 'url')); ?>
			<?php else :?>
				<?php echo $author; ?>
			<?php endif; ?>

			<time datetime="<?php echo JHtml::_('date', $displayData->publish_up, 'c'); ?>" itemprop="datePublished" data-toggle="tooltip" title="<?php echo JText::_('COM_CONTENT_PUBLISHED_DATE'); ?>">
				<?php echo JHtml::_('date', $displayData->publish_up, JText::_('DATE_FORMAT_LC3')); ?>
			</time>			
		</div>
		
	</div> <!-- /.article-info-item-wrap -->
</div>














