<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_5_0F
	* Creation date: Novembre 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;

$app = Factory::getApplication();

$this->category->text = $this->category->description;
$app->triggerEvent('onContentPrepare', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$this->category->description = $this->category->text;

$results = $app->triggerEvent('onContentAfterTitle', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayTitle = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentBeforeDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$beforeDisplayContent = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentAfterDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayContent = trim(implode("\n", $results));

$this->params->set('source', 'category');
?>
<div class="com-gmapfp-category-blog blog" itemscope itemtype="https://schema.org/Blog">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
		</div>
	<?php endif; ?>

	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
		<h2> <?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title')) : ?>
				<span class="subheading-category"><?php echo $this->category->title; ?></span>
			<?php endif; ?>
		</h2>
	<?php endif; ?>
	<?php echo $afterDisplayTitle; ?>

	<?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
		<?php $this->category->tagLayout = new FileLayout('joomla.content.tags'); ?>
		<?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
	<?php endif; ?>

	<?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
		<div class="category-desc clearfix">
			<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
				<img src="<?php echo $this->category->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($this->category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>">
			<?php endif; ?>
			<?php echo $beforeDisplayContent; ?>
			<?php if ($this->params->get('show_description') && $this->category->description) : ?>
				<?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_gmapfp.category'); ?>
			<?php endif; ?>
			<?php echo $afterDisplayContent; ?>
		</div>
	<?php endif; ?>

	<?php
		if($this->params->get('map_position',1) == 1){
			if(isset($this->perso->intro_carte))
				echo '<div class="com_gmapfp_perso_avant_carte">'.$this->perso->intro_carte.'</div>';
			$catid = $this->get('category'); 
			echo LayoutHelper::render('map', array('category_id'=>$catid->id, 'params'=>$this->params));
			if(isset($this->perso->conclusion_carte))
				echo '<div class="com_gmapfp_perso_apres_carte">'.$this->perso->conclusion_carte.'</div>';
		}
	?>

	<?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
		<?php if ($this->params->get('show_no_articles', 1)) : ?>
			<p><?php echo Text::_('COM_GMAPFP_NO_ITEMS'); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php if(isset($this->perso->intro_detail))
			echo '<div class="com_gmapfp_perso_apres_items">'.$this->perso->intro_detail.'</div>';?>
	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
		<div class="com-gmapfp-category-blog__items blog-items items-leading <?php echo $this->params->get('blog_class_leading'); ?>">
			<?php foreach ($this->lead_items as &$item) : ?>
				<div class="com-gmapfp-category-blog__item blog-item"
					itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
					<div class="blog-item-gmapfp"><!-- Double divs required for IE11 grid fallback -->
						<?php
						$this->item = & $item;
						echo $this->loadTemplate('item');
						?>
					</div>
				</div>
				<?php $leadingcount++; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php
	$introcount = count($this->intro_items);
	$counter = 0;
	?>

	<?php if (!empty($this->intro_items)) : ?>
		<div class="com-gmapfp-category-blog__items blog-items <?php echo $this->params->get('blog_class'); ?>">
		<?php foreach ($this->intro_items as $key => &$item) : ?>
			<div class="com-gmapfp-category-blog__item blog-item"
				itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
				<div class="blog-item-gmapfp"><!-- Double divs required for IE11 grid fallback -->
					<?php
					$this->item = & $item;
					echo $this->loadTemplate('item');
					?>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if (!empty($this->link_items)) : ?>
		<div class="com-gmapfp-category-blog__items-more items-more">
			<?php echo $this->loadTemplate('links'); ?>
		</div>
	<?php endif; ?>
	<?php if(isset($this->perso->conclusion_detail))
			echo '<div class="com_gmapfp_perso_apres_items">'.$this->perso->conclusion_detail.'</div>';?>

	<?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) : ?>
		<div class="com-gmapfp-category-blog__children cat-children">
			<?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
				<h3> <?php echo Text::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
			<?php endif; ?>
			<?php echo $this->loadTemplate('children'); ?> </div>
	<?php endif; ?>
	<?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
		<div class="com-gmapfp-category-blog__navigation w-100">
			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="com-gmapfp-category-blog__counter counter float-right pt-3 pr-2">
					<?php echo $this->pagination->getPagesCounter(); ?>
				</p>
			<?php endif; ?>
			<div class="com-gmapfp-category-blog__pagination">
				<?php echo $this->pagination->getPagesLinks(); ?>
			</div>
		</div>
	<?php endif; ?>
	<?php
		if($this->params->get('map_position',1) == 2){
			if(isset($this->perso->intro_carte))
				echo '<div class="com_gmapfp_perso_avant_carte">'.$this->perso->intro_carte.'</div>';
			$catid = $this->get('category'); 
			echo LayoutHelper::render('map', array('category_id'=>$catid->id, 'params'=>$this->params));
			if(isset($this->perso->conclusion_carte))
				echo '<div class="com_gmapfp_perso_apres_carte">'.$this->perso->conclusion_carte.'</div>';
		}
	?>
</div>
