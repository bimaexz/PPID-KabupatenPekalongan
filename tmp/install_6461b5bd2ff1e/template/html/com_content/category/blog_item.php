<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Create a shortcut for params.
$params = $this->item->params;
$tpl_params 	= JFactory::getApplication()->getTemplate(true)->params;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$canEdit 	 = $this->item->params->get('access-edit');
$info    	 = $params->get('info_block_position', 0);
$useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
	|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') );

// Post Format
$post_attribs = new JRegistry(json_decode( $this->item->attribs ));
$post_format = $post_attribs->get('post_format', 'standard');

?>

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
	|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate())) : ?>
	<div class="system-unpublished">
<?php endif; ?>

<?php
	if($post_format=='standard') { ?>
		<div class="entry-image-wrap">
			<?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item ); ?>

			<div class="entry-header<?php echo $tpl_params->get('show_post_format') ? ' has-post-format': ''; ?> entry-title-wrap">
				<?php echo JLayoutHelper::render('joomla.content.post_formats.icons',  $post_format); ?>
				<div class="entry-title-box">
					<?php echo JLayoutHelper::render('joomla.content.info_block.category', array('item' => $this->item, 'params' => $params)); ?>
					<?php echo JLayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>
				</div> <!-- /.entry-title-wrap" -->
			</div> <!-- /.entry-header -->

		</div> <!-- /.entry-image-wrap -->
	<?php
	} else {
		echo JLayoutHelper::render('joomla.content.post_formats.post_' . $post_format, array('params' => $post_attribs, 'item' => $this->item));
	}
?>

<div class="entry-info-wrap">
	
	<?php if ($useDefList && ($info == 0 || $info == 2) && $tpl_params->get('blog_show_info')) : ?>
		<div class="entry-header-info-block">
			<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
		</div>
	<?php endif; ?>

	

	<?php if ($tpl_params->get('blog_show_info')): ?>
		
	
		<?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
			<?php echo JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false)); ?>
		<?php endif; ?>

		<?php if (!$params->get('show_intro')) : ?>
			<?php echo $this->item->event->afterDisplayTitle; ?>
		<?php endif; ?>
		<?php echo $this->item->event->beforeDisplayContent; ?>

		<?php $rating = (int) $this->item->rating; ?>

		<?php echo $this->item->introtext; ?>

		<?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
			<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
		<?php  endif; ?>

		<?php if ($params->get('show_readmore') && $this->item->readmore) :
			if ($params->get('access-view')) :
				$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
			else :
				$menu = JFactory::getApplication()->getMenu();
				$active = $menu->getActive();
				$itemId = $active->id;
				$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
				$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
				$link = new JUri($link1);
				$link->setVar('return', base64_encode($returnURL));
			endif; ?>

			<?php echo JLayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>

		<?php endif; ?>

		<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
			|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate())) : ?>
		</div>
		<?php endif; ?>

		<!-- <?php //if ($params->get('show_tags') && !empty($this->item->tags->itemTags)) : ?>
			<?php //echo JLayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
		<?php //endif; ?> -->

		<?php echo $this->item->event->afterDisplayContent; ?>
	<?php endif ?>
</div> <!-- /.entry-info-wrap -->