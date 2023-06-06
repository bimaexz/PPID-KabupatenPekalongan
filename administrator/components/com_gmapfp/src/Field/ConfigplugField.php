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
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;

class ConfigplugField extends FormField
{

	protected $type = 'Configplug';

	protected function getInput()
	{
		$params = ComponentHelper::getParams('com_gmapfp');

		$doc = Factory::getDocument();
		$wa = $doc->getWebAssetManager();
		$wa->useScript('jquery');

		$js = ''
			.'var plug_name_'.$this->layout.' ="'.$params->get('plugin_'.$this->layout.'_name', 'google').'";'
			.'jQuery("#jform_plugin_'.$this->layout.'_name").change(function() {'
			.'plug_name_'.$this->layout.' = jQuery("#jform_plugin_'.$this->layout.'_name").val();'
			.'jQuery("#'.$this->id.'-name").html(plug_name_'.$this->layout.');'
			.'})'
			.''."\r\n";
		$doc->addScriptDeclaration($js);

		$html = '<button id="'.$this->id.'" name="'.$this->name.'" data-toggle="modal" class=" '.$this->class.'" target="_blank" onclick="Joomla.popupWindow(\'index.php?option=com_gmapfp&view=config&layout=edit&tmpl=components&plug_type='.$this->layout.'&plug_name=\'+plug_name_'.$this->layout.', \'Config\', 900, 700, 1);return false;">'
			.'<span class="fa fa-'.$this->default.'" aria-hidden="true"></span>&nbsp;'
			.TEXT::_('JFIELD_PARAMS_LABEL').' / '.'<i id="'.$this->id.'-name">'.$params->get('plugin_'.$this->layout.'_name', 'google').'</i></button>';
		return $html;
	}
}
?>