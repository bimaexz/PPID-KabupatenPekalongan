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

// get article image
$images = json_decode($displayData->images);

//Article Attribute 
$art_attribs	= new JRegistry(json_decode( $displayData->attribs ));
$art_image 	= $art_attribs->get('spfeatured_image');

$img_size = "_large";

//Basename
$basename = basename($art_image);
//Thumb
$thumbnail = JPATH_ROOT . '/' . dirname($art_image) . '/' . JFile::stripExt($basename) . $img_size . '.' . JFile::getExt($basename);
if(file_exists($thumbnail)) {
	$item_image = JURI::root(true) . '/' . dirname($art_image) . '/' . JFile::stripExt($basename) . $img_size . '.' . JFile::getExt($basename);
}elseif(isset($images->image_intro) && !empty($images->image_intro)){
	$item_image = htmlspecialchars($images->image_intro);
}

?>

<?php if ( (isset($images->image_fulltext) && !empty($images->image_fulltext)) || file_exists($thumbnail) || $images->image_intro ) : ?>
	<?php $imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
	<div class="entry-image full-image"> <img
		<?php if ($images->image_fulltext_caption):
		echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_fulltext_caption) . '"';
		endif; ?>
		src="<?php echo $item_image; ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>" itemprop="image"/> </div>
<?php endif; ?>