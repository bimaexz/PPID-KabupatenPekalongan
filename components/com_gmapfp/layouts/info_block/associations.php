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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

?>

<?php if (!empty($displayData['item']->associations)) : ?>
<?php $associations = $displayData['item']->associations; ?>

<dd class="association">
	<?php echo Text::_('JASSOCIATIONS'); ?>
	<?php foreach ($associations as $association) : ?>
		<?php if ($displayData['item']->params->get('flags', 1) && $association['language']->image) : ?>
			<?php $flag = HTMLHelper::_('image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, array('title' => $association['language']->title_native), true); ?>
			&nbsp;<a href="<?php echo Route::_($association['item']); ?>"><?php echo $flag; ?></a>&nbsp;
		<?php else : ?>
			<?php $class = 'badge badge-secondary badge-' . $association['language']->sef; ?>
			&nbsp;<a class="<?php echo $class; ?>" href="<?php echo Route::_($association['item']); ?>"><?php echo strtoupper($association['language']->sef); ?></a>&nbsp;
		<?php endif; ?>
	<?php endforeach; ?>
</dd>
<?php endif; ?>
