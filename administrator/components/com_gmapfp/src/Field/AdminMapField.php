<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_1F
	* Creation date: Avril 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\GMapFP\Administrator\Field;

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Component\ComponentHelper;

class AdminMapField extends FormField
{

	protected $type = 'AdminMap';

	protected function getInput()
	{
		$doc = Factory::getDocument();
		$wa = $doc->getWebAssetManager();
		$params = ComponentHelper::getParams('com_gmapfp');

		$lat = $this->form->getValue('glat');
		$lng = $this->form->getValue('glng');
		$zoom = $this->form->getValue('gzoom');

		$js = ''
			.'  var lat = "'.$lat.'";'
			.'  var lng = "'.$lng.'";'
			.'  var zoom_carte = "'.$zoom.'";'
			.''
			."\r\n";
		$wa->addInlineScript($js);
		
		//appel le script de la carte
		$plugin_name = $params->get('plugin_map_name', 'google');
		include_once PluginHelper::getLayoutPath('gmapfp-map', $plugin_name, $plugin_name.'_admin');
		
		$html = '<div class="control-label">';
		$html .= '	<label id="localisation-lbl" for="localisation">'.Text::_('COM_GMAPFP_MAJ_ADRESSE').'</label>';
		$html .= '</div>';
		$html .= '<div class="controls has-success row">';
		$html .= '	<input class="form-control valid col-md-12" type="text" name="localisation" id="localisation" value="" />';
		$html .= '	<input class="btn btn-action" type="button" onclick="showAddress();" value="'.Text::_('COM_GMAPFP_CHERCHER').'" />';
		$html .= '</div>';
		
		$html .= '<div class="control-label">';
		$html .= '	<label id="jform_glat-lbl" for="jform_glat">'.Text::_('COM_GMAPFP_LAT').' - '.Text::_('COM_GMAPFP_LON').' - Zoom</label>';
		$html .= '</div>';
		$html .= '<div class="controls has-success row">';
		$html .= '	<input class="form-control valid validate-numeric col-md-5" onblur="IsReal(this);" type="text" name="jform[glat]" id="jform_glat" size="20" value="'.$lat.'" />';
		$html .= '	<input class="form-control valid validate-numeric col-md-5" onblur="IsReal(this);" type="text" name="jform[glng]" id="jform_glng" size="20" value="'.$lng.'" />';
		$html .= '	<input class="form-control valid validate-numeric col-md-2" onblur="IsReal(this);" type="text" name="jform[gzoom]" id="jform_gzoom" size="2" value="'.$zoom.'" />';
		$html .= '	<input class="btn btn-action" type="button" onclick="setCoordinate();" value="'.Text::_('COM_GMAPFP_CHERCHER_COORDONNEES').'" />';
		$html .= '</div>';
		$html .= '<div id="map" style="width: 100%; height: 350px; overflow:hidden;"></div>';
		$html .= '<input type="hidden" name="'. $this->name .'" id="'. $this->id .'" value="'. $this->value .'" />';
		
		return $html;
	}
}
?>