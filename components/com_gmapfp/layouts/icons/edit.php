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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$article = $displayData['article'];
$tooltip = $displayData['overlib'];
$nowDate = strtotime(Factory::getDate());

$icon = $article->state ? 'edit' : 'eye-slash';

if (($article->publish_up !== null && strtotime($article->publish_up) > $nowDate)
	|| ($article->publish_down !== null && strtotime($article->publish_down) < $nowDate
		&& $article->publish_down !== Factory::getDbo()->getNullDate()))
{
	$icon = 'eye-slash';
}
$aria_described = 'editarticle-' . (int) $article->id;

?>
<span class="fas fa-<?php echo $icon; ?>" aria-hidden="true"></span>
	<?php echo Text::_('JGLOBAL_EDIT'); ?>
<div role="tooltip" id="<?php echo $aria_described; ?>">
	<?php echo $tooltip; ?>
</div>
