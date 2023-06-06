<?php
/**
 * @package    PdfEmbed
 *
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (C) 2010 - 2020 Techjoomla. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Object\CMSObject;

/**
 * Class for PlgButtonPdf_Btn plugin
 *
 * @package  Editor-xtd
 * @since    1.0
 */
class PlgButtonPdf_Btn extends CMSPlugin
{
	protected $autoloadLanguage = true;

	/**
	 * Takes the parameter for
	 *
	 * @param   string  $name  The subject being passed to the plugin.
	 *
	 * @return   html for the pdf
	 *
	 * @since   1.0
	 */
	public function onDisplay($name)
	{
		$js = "
			function buttonPdf_btnClick(editor)
			{
				txt = prompt('" . Text::_('PLG_PDF_BTN_PDF_NAME_PROMPT') . "','example.pdf');
				if (!txt) return;
				if(txt)
				{
					txt1 = prompt('" . Text::_('PLG_PDF_BTN_PDF_VIEWER_PROMPT') . "','');
				}
				if(!txt1)
				{
					txt1 = 'native';
				}
				Joomla.editors.instances[editor].replaceSelection('{pdf='+txt+'|100%|300|'+txt1+'}')
			}";
			$doc = Factory::getdocument();
			$doc ->addScriptDeclaration($js);

			$button = new CMSObject;
			$button->set('modal', false);
			$button->set('link', '#');
			$button->set('text', Text::_('PLG_PDF_BTN_BUTTON'));
			$button->set('name', 'file');
			$button->set('class', 'btn');
			$button->set('onclick', 'buttonPdf_btnClick(\'' . $name . '\');return false;');
			$button->set('icon', 'file');
			$button->set('iconSVG', '<svg viewBox="0 0 32 32" width="24" height="24"><path d="M28 24v-4h-4v4h-4v4h4v4h4v-4h4v-4zM2 2h18v6h6v10h2v-10l-8-'
			. '8h-20v32h18v-2h-16z"></path></svg>');

			return $button;
	}
}
