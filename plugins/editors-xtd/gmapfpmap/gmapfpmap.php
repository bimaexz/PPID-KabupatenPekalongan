<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_5_0F
	* Creation date: Novembre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Session\Session;

class PlgButtonGmapfpmap extends CMSPlugin
{
	protected $autoloadLanguage = true;

	public function onDisplay($name)
	{
		$user  = Factory::getUser();

		if ($user->authorise('core.create', 'com_gmapfp')
			|| $user->authorise('core.edit', 'com_gmapfp')
			|| $user->authorise('core.edit.own', 'com_gmapfp'))
		{
			// The URL for the contacts list
			$link = 'index.php?option=com_gmapfp&amp;view=xtd_button&amp;layout=modal&amp;tmpl=component&amp;'
				. Session::getFormToken() . '=1&amp;editor=' . $name;

		$button = new CMSObject;
		$button->modal   = true;
		$button->link    = $link;
		$button->text    = Text::_('PLG_EDITORS-XTD_GMAPFP_MAP_BUTTON');
		$button->name    = $this->_type . '_' . $this->_name;
		$button->icon    = 'map';
		$button->iconSVG = '<svg viewBox="0 0 1792 1792" width="24" height="24"><path d="M1152 640q0-106-75-181t-181-75-181 75-75 181 75 181 181 75'
							. ' 181-75 75-181zm256 0q0 109-33 179l-364 774q-16 33-47.5 52t-67.5 19-67.5-19-46.5-52l-365-774q-33-70-33-179 0-212'
							. ' 150-362t362-150 362 150 150 362z">'
							. '</path></svg>';

		$button->options = [
			'height' => '300px',
			'width'  => '800px',
			'bodyHeight'  => '70',
			'modalWidth'  => '80',
		];

			return $button;
		}
	}
}
