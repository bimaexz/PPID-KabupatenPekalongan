<?php
/**
 * @package    PdfEmbed
 *
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (C) 2010 - 2021 Techjoomla. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined('_JEXEC') or die();

use Joomla\CMS\Form\FormField;

/**
 * Class for adding note for getting client id
 *
 * @package     PdfEmbed
 * @subpackage  plugin
 * @since       2.3.0
 */
class JFormFieldNote extends FormField
{
	/**
	 * The form field type.
	 *
	 * @var String
	 * @since 2.3.0
	 */
	public $type = 'note';

	/**
	 * Get html of the element
	 *
	 * @return  string   Html
	 *
	 * @since  2.3.0
	 */
	public function getInput()
	{
		$html  = '';
		$html .= '<div class="span9 alert alert-info">' . JText::_('PLG_CONTENT_PDF_EMBED_ADOBE_CLIENT_ID_NOTE') . '</div>';

		return $html;
	}
}
