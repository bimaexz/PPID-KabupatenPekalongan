<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_10F
	* Creation date: février 2023
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$item = $displayData['item'];

if (!empty($item->email)) :
	echo HTMLHelper::_(
		'bootstrap.renderModal',
		'GmapfpEmailModal'.$item->id,
		array(
			'url'        => Uri::base() . 'index.php?option=com_gmapfp&view=email&tmpl=component&id='.$item->id,
			'title'      => $item->title.' / '.$item->ville,
			'height'     => '700',
			'width'      => '100%',
			'footer'     => '<a href="//gmapfp.org" target="_blank" >GMapFP</a>'
		)
	);
?>
<div class="gmapfp_icons">
	<button class="mail btn" title="<?php echo Text::_('COM_GMAPFP_DISPLAY_MSG'); ?>" data-bs-target="#GmapfpEmailModal<?php echo $item->id; ?>" data-bs-toggle="modal">
		<span class=" fa fa-3x fa-mail-bulk" aria-hidden="true"></span>
	</button>
</div>
<?php
endif;
?>
