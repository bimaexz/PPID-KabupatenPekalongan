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

use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Language\Text;
use Joomla\Component\Gmapfp\Site\Helper\GmapfpHelper;

$lat = $this->item->glat;
$lng = $this->item->glng;

if ($this->params->get('affichage_sexagesimale', 1)) {
	$lat = GmapfpHelper::getSexagesimale($this->item->glat);
	$lng = GmapfpHelper::getSexagesimale($this->item->glng);
}
?>

<div class="com-gmapfp-map item">
<?php
	$id = $this->item->id;
	$this->params->set('source', 'item');
	echo LayoutHelper::render('map', array('id'=>$id, 'params'=>$this->params, 'item'=>$this->item));
?>
</div>
<div class="com-gmapfp-coordonate">
	<p class="lat"><span class="label"><?php echo Text::_('COM_GMAPFP_LAT_LABEL'); ?></span><?php echo $lat; ?></p>
	<p class="lng"><span class="label"><?php echo Text::_('COM_GMAPFP_LNG_LABEL'); ?></span><?php echo $lng; ?></p>
</div>
