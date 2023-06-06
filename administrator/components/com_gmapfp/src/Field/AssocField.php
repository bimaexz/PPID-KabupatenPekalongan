<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Administrator\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\Language\Associations;

class AssocField extends ListField
{
	protected $type = 'Assoc';

	public function setup(\SimpleXMLElement $element, $value, $group = null)
	{
		if (!Associations::isEnabled())
		{
			return false;
		}

		return parent::setup($element, $value, $group);
	}
}
