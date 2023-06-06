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
use Joomla\CMS\Uri\Uri;

class MarqueursField extends FormField
{

	protected $type = 'Marqueurs';

	protected function getInput()
	{
		$doc = Factory::getDocument();
		
		$css = ''
			.'.marqueurs {'
			.'	border: 1px solid #ccc;'
			.'	border-radius: 0.25rem;'
			.'	background-color: #f8f8f8;'
			.'	cursor:pointer; '
			.'	text-align:center; '
			.'	padding:0; '
			.'	min-width:40px; '
			.'}'
			.'.marqueurs.active {'
			.'	background-color: #438243;'
			.'}'
			.''
			.''."\r\n";
		$doc->addStyleDeclaration($css);

		$js = ''
			.'function select_marqueur(e){'
			.'if(e.id) {'
			.'jQuery("#' . $this->id . '").val(e.id);'
			.'jQuery(".marqueurs").removeClass("active");'
			.'jQuery("#"+e.id).addClass("active");'
			.'}'
			.'}'
			.''."\r\n";
		$doc->addScriptDeclaration($js);

		$marqueurs = array();
		$db	= Factory::getDBO();

		$query = $db->getQuery(true);
		$query
			->select($db->quoteName(array('id', 'nom', 'url')))
			->from($db->quoteName('#__gmapfp_marqueurs'))
			->where($db->quoteName('state')." = 1")
			->order($db->quoteName('ordering'));
		$db->setQuery( $query );
		$marqueurs = $db->loadObjectList('id');
		
		if (!empty($marqueurs))
		{
			$html = '<div id="markers" class="row">'."\r\n";
			$cn = 0;
			foreach($marqueurs as $marqueur) {
				$checked = '';
				if (($this->value == $marqueur->url) || $this->value == $marqueur->id || (empty($this->value) && $cn == '0')) { 
					$class = 'active"'; 
					$this->value = $marqueur->id;
				} else $class = '';
				if (substr($marqueur->url,0,2)!='//' and substr($marqueur->url,0,4)!='http')
					$marqueur->url = Uri::root().$marqueur->url;
				$html .= '<div onclick="select_marqueur(this);" id="' . $marqueur->id . '" class="col-md-1 marqueurs ' . $class . '">';
					$html .= '<img onclick="select_marqueur(this);" src="'.$marqueur->url.'" title="'.$marqueur->nom.'" />';
				$html .= '</div>'."\r\n";
				$cn++;
			}
			$html .= '<input type="hidden" name="' . $this->name . '" id="' . $this->id . '" value="'.$this->value.'"/>'."\r\n";
			$html .= '</div>'."\r\n";
		} else {
			$html = 'Error : no existing markers';
		}
		
		return $html;
	}
}
?>