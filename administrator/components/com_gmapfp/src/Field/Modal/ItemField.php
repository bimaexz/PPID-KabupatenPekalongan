<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_1F
	* Creation date: Avril 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Administrator\Field\Modal;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;
use Joomla\Database\ParameterType;

class ItemField extends FormField
{
	protected $type = 'Modal_Item';

	protected function getInput()
	{
		$allowNew       = ((string) $this->element['new'] == 'true');
		$allowEdit      = ((string) $this->element['edit'] == 'true');
		$allowClear     = ((string) $this->element['clear'] != 'false');
		$allowSelect    = ((string) $this->element['select'] != 'false');
		$allowPropagate = ((string) $this->element['propagate'] == 'true');

		$languages = LanguageHelper::getContentLanguages(array(0, 1), false);

		// Load language
		Factory::getLanguage()->load('com_gmapfp', JPATH_ADMINISTRATOR);

		// The active item id field.
		$value = (int) $this->value ?: '';

		// Create the modal id.
		$modalId = 'Item_' . $this->id;

		/** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
		$wa = Factory::getApplication()->getDocument()->getWebAssetManager();

		// Add the modal field script to the document head.
		$wa->useScript('field.modal-fields');

		// Script to proxy the select modal function to the modal-fields.js file.
		if ($allowSelect)
		{
			static $scriptSelect = null;

			if (is_null($scriptSelect))
			{
				$scriptSelect = array();
			}

			if (!isset($scriptSelect[$this->id]))
			{
				$wa->addInlineScript("
				window.jSelectItem_" . $this->id . " = function (id, title, object) {
					window.processModalSelect('Item', '" . $this->id . "', id, title, '', object);
				}",
					[],
					['type' => 'module']
				);

				Text::script('JGLOBAL_ASSOCIATIONS_PROPAGATE_FAILED');

				$scriptSelect[$this->id] = true;
			}
		}

		// Setup variables for display.
		$linkItems = 'index.php?option=com_gmapfp&amp;view=items&amp;layout=modal&amp;tmpl=component&amp;' . Session::getFormToken() . '=1';
		$linkItem  = 'index.php?option=com_gmapfp&amp;view=item&amp;layout=modal&amp;tmpl=component&amp;' . Session::getFormToken() . '=1';
		$modalTitle   = Text::_('COM_GMAPFP_SELECT_AN_ITEM');

		if (isset($this->element['language']))
		{
			$linkItems .= '&amp;forcedLanguage=' . $this->element['language'];
			$linkItem   .= '&amp;forcedLanguage=' . $this->element['language'];
			$modalTitle     .= ' &#8212; ' . $this->element['label'];
		}

		$urlSelect = $linkItems . '&amp;function=jSelectItem_' . $this->id;
		$urlEdit   = $linkItem . '&amp;task=item.edit&amp;id=\' + document.getElementById("' . $this->id . '_id").value + \'';
		$urlNew    = $linkItem . '&amp;task=item.add';

		if ($value)
		{
			$db    = Factory::getDbo();
			$query = $db->getQuery(true)
				->select($db->quoteName('title'))
				->from($db->quoteName('#__gmapfp'))
				->where($db->quoteName('id') . ' = :id')
				->bind(':id', $value, ParameterType::INTEGER);
			$db->setQuery($query);

			try
			{
				$title = $db->loadResult();
			}
			catch (\RuntimeException $e)
			{
				Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
			}
		}

		$title = empty($title) ? Text::_('COM_GMAPFP_SELECT_AN_ITEM') : htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

		// The current item display field.
		$html  = '';

		if ($allowSelect || $allowNew || $allowEdit || $allowClear)
		{
			$html .= '<span class="input-group">';
		}

		$html .= '<input class="form-control" id="' . $this->id . '_name" type="text" value="' . $title . '" readonly size="35">';

		if ($allowSelect || $allowNew || $allowEdit || $allowClear)
		{
			$html .= '<span class="input-group-append">';
		}

		// Select item button
		if ($allowSelect)
		{
			$html .= '<button'
				. ' class="btn btn-primary' . ($value ? ' hidden' : '') . '"'
				. ' id="' . $this->id . '_select"'
				. ' data-bs-toggle="modal"'
				. ' type="button"'
				. ' data-bs-target="#ModalSelect' . $modalId . '">'
				. '<span class="icon-file" aria-hidden="true"></span> ' . Text::_('JSELECT')
				. '</button>';
		}

		// New item button
		if ($allowNew)
		{
			$html .= '<button'
				. ' class="btn btn-secondary' . ($value ? ' hidden' : '') . '"'
				. ' id="' . $this->id . '_new"'
				. ' data-bs-toggle="modal"'
				. ' type="button"'
				. ' data-bs-target="#ModalNew' . $modalId . '">'
				. '<span class="icon-plus" aria-hidden="true"></span> ' . Text::_('JACTION_CREATE')
				. '</button>';
		}

		// Edit item button
		if ($allowEdit)
		{
			$html .= '<button'
				. ' class="btn btn-primary' . ($value ? '' : ' hidden') . '"'
				. ' id="' . $this->id . '_edit"'
				. ' data-bs-toggle="modal"'
				. ' type="button"'
				. ' data-bs-target="#ModalEdit' . $modalId . '">'
				. '<span class="icon-pen-square" aria-hidden="true"></span> ' . Text::_('JACTION_EDIT')
				. '</button>';
		}

		// Clear item button
		if ($allowClear)
		{
			$html .= '<button'
				. ' class="btn btn-secondary' . ($value ? '' : ' hidden') . '"'
				. ' id="' . $this->id . '_clear"'
				. ' type="button"'
				. ' onclick="window.processModalParent(\'' . $this->id . '\'); return false;">'
				. '<span class="icon-times" aria-hidden="true"></span> ' . Text::_('JCLEAR')
				. '</button>';
		}

		// Propagate item button
		if ($allowPropagate && count($languages) > 2)
		{
			// Strip off language tag at the end
			$tagLength = (int) strlen($this->element['language']);
			$callbackFunctionStem = substr("jSelectItem_" . $this->id, 0, -$tagLength);

			$html .= '<button'
			. ' class="btn btn-primary' . ($value ? '' : ' hidden') . '"'
			. ' type="button"'
			. ' id="' . $this->id . '_propagate"'
			. ' title="' . Text::_('JGLOBAL_ASSOCIATIONS_PROPAGATE_TIP') . '"'
			. ' onclick="Joomla.propagateAssociation(\'' . $this->id . '\', \'' . $callbackFunctionStem . '\');">'
			. '<span class="icon-sync" aria-hidden="true"></span> ' . Text::_('JGLOBAL_ASSOCIATIONS_PROPAGATE_BUTTON')
			. '</button>';
		}

		if ($allowSelect || $allowNew || $allowEdit || $allowClear)
		{
			$html .= '</span>';
		}

		// Select item modal
		if ($allowSelect)
		{
			$html .= HTMLHelper::_(
				'bootstrap.renderModal',
				'ModalSelect' . $modalId,
				array(
					'title'       => $modalTitle,
					'url'         => $urlSelect,
					'height'      => '400px',
					'width'       => '800px',
					'bodyHeight'  => 70,
					'modalWidth'  => 80,
					'footer'      => '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">'
										. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>',
				)
			);
		}

		// New item modal
		if ($allowNew)
		{
			$html .= HTMLHelper::_(
				'bootstrap.renderModal',
				'ModalNew' . $modalId,
				array(
					'title'       => Text::_('COM_GMAPFP_NEW_ITEM'),
					'backdrop'    => 'static',
					'keyboard'    => false,
					'closeButton' => false,
					'url'         => $urlNew,
					'height'      => '400px',
					'width'       => '800px',
					'bodyHeight'  => 70,
					'modalWidth'  => 80,
					'footer'      => '<button type="button" class="btn btn-secondary"'
							. ' onclick="window.processModalEdit(this, \''
							. $this->id . '\', \'add\', \'item\', \'cancel\', \'item-form\', \'jform_id\', \'jform_title\'); return false;">'
							. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>'
							. '<button type="button" class="btn btn-primary"'
							. ' onclick="window.processModalEdit(this, \''
							. $this->id . '\', \'add\', \'item\', \'save\', \'item-form\', \'jform_id\', \'jform_title\'); return false;">'
							. Text::_('JSAVE') . '</button>'
							. '<button type="button" class="btn btn-success"'
							. ' onclick="window.processModalEdit(this, \''
							. $this->id . '\', \'add\', \'item\', \'apply\', \'item-form\', \'jform_id\', \'jform_title\'); return false;">'
							. Text::_('JAPPLY') . '</button>',
				)
			);
		}

		// Edit item modal.
		if ($allowEdit)
		{
			$html .= HTMLHelper::_(
				'bootstrap.renderModal',
				'ModalEdit' . $modalId,
				array(
					'title'       => Text::_('COM_GMAPFP_EDIT_ITEM'),
					'backdrop'    => 'static',
					'keyboard'    => false,
					'closeButton' => false,
					'url'         => $urlEdit,
					'height'      => '400px',
					'width'       => '800px',
					'bodyHeight'  => 70,
					'modalWidth'  => 80,
					'footer'      => '<button type="button" class="btn btn-secondary"'
							. ' onclick="window.processModalEdit(this, \'' . $this->id
							. '\', \'edit\', \'item\', \'cancel\', \'item-form\', \'jform_id\', \'jform_title\'); return false;">'
							. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>'
							. '<button type="button" class="btn btn-primary"'
							. ' onclick="window.processModalEdit(this, \''
							. $this->id . '\', \'edit\', \'item\', \'save\', \'item-form\', \'jform_id\', \'jform_title\'); return false;">'
							. Text::_('JSAVE') . '</button>'
							. '<button type="button" class="btn btn-success"'
							. ' onclick="window.processModalEdit(this, \''
							. $this->id . '\', \'edit\', \'item\', \'apply\', \'item-form\', \'jform_id\', \'jform_title\'); return false;">'
							. Text::_('JAPPLY') . '</button>',
				)
			);
		}

		// Note: class='required' for client side validation.
		$class = $this->required ? ' class="required modal-value"' : '';

		$html .= '<input type="hidden" id="' . $this->id . '_id"' . $class . ' data-required="' . (int) $this->required . '" name="' . $this->name
			. '" data-text="' . htmlspecialchars(Text::_('COM_GMAPFP_SELECT_AN_ITEM', true), ENT_COMPAT, 'UTF-8') . '" value="' . $value . '">';

		return $html;
	}

	protected function getLabel()
	{
		return str_replace($this->id, $this->id . '_name', parent::getLabel());
	}
}
