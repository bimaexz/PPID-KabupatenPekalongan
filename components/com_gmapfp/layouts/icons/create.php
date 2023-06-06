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

use Joomla\CMS\Language\Text;

$params = $displayData['params'];

?>
<?php if ($params->get('show_icons')) : ?>
	<span class="fas fa-plus fa-fw" aria-hidden="true"></span>
	<?php echo Text::_('JNEW'); ?>
<?php else : ?>
	<?php echo Text::_('JNEW') . '&#160;'; ?>
<?php endif; ?>
