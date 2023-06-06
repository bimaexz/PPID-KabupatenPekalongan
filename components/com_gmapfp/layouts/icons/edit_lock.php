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

if (isset($displayData['article']))
{
	$article = $displayData['article'];
	$aria_described = 'editarticle-' . (int) $article->id;
}

if (isset($displayData['contact']))
{
	$contact = $displayData['contact'];
	$aria_described = 'editcontact-' . (int) $contact->id;
}

$tooltip = $displayData['tooltip'];

?>
<span class="hasTooltip fas fa-lock" aria-hidden="true"></span>
	<?php echo Text::_('JLIB_HTML_CHECKED_OUT'); ?>
<div role="tooltip" id="<?php echo $aria_described; ?>">
	<?php echo $tooltip; ?>
</div>
