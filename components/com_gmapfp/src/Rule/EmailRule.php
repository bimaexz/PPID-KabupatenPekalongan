<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\Rule;

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\Rule\EmailRule as JoomlaEmailRule;
use Joomla\Registry\Registry;
use Joomla\String\StringHelper;

class EmailRule extends JoomlaEmailRule
{
	public function test(\SimpleXMLElement $element, $value, $group = null, Registry $input = null, Form $form = null)
	{
		if (!parent::test($element, $value, $group, $input, $form))
		{
			return false;
		}

		$params = ComponentHelper::getParams('com_gmapfp');
		$banned = $params->get('banned_email');

		if ($banned)
		{
			foreach (explode(';', $banned) as $item)
			{
				if ($item != '' && StringHelper::stristr($value, $item) !== false)
				{
					return false;
				}
			}
		}

		return true;
	}
}
