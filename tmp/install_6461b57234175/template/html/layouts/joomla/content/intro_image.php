<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$params  = $displayData->params;

//get article image
$images = json_decode($displayData->images);

//Article Attribute 
$art_attribs	= new JRegistry(json_decode( $displayData->attribs ));
$art_image 	= $art_attribs->get('spfeatured_image');

// get article type

if ($displayData->item_type == 'leading') {
	$img_size = "_large";
} else {
	$img_size = "_thumbnail";
}

//Basename
$basename = basename($art_image);
//Thumb
$thumbnail = JPATH_ROOT . '/' . dirname($art_image) . '/' . JFile::stripExt($basename) . $img_size . '.' . JFile::getExt($basename);
if(file_exists($thumbnail)) {
	$item_image = JURI::root(true) . '/' . dirname($art_image) . '/' . JFile::stripExt($basename) . $img_size . '.' . JFile::getExt($basename);
}elseif(isset($images->image_intro) && !empty($images->image_intro)){
	$item_image = htmlspecialchars($images->image_intro);
}

//$params->get('num_leading_articles')

?>

<?php if ( (isset($images->image_intro) && !empty($images->image_intro)) || file_exists($thumbnail) ) : ?>
	<div class="entry-image intro-image match-height"> 
		<div class="overlay"></div>
		<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language)); ?>"><img
				<?php if ($images->image_intro_caption):
					echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
				endif; ?>
			src="<?php echo $item_image; ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>" itemprop="thumbnailUrl"/></a>
		<?php else : ?><img
			<?php if ($images->image_intro_caption):
				echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
			endif; ?>
			src="<?php echo $item_image; ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>" itemprop="thumbnailUrl"/>
		<?php endif; ?> 

	</div>
<?php else: ?>
	<div class="entry-image intro-image no-image match-height"></div>
<?php endif; ?>

