<?php

defined('JPATH_BASE') or die;

/**
 * Supports a modal for selecting a question record
 *
 */
class JFormFieldModal_Question extends JFormField
{
	/**
	 * Method to get the html for the input field.
	 *
	 * @return  string  The field input html.
	 */
	protected function getInput()
	{
		// Load language
		JFactory::getLanguage()->load('com_jmgquestionnaire', JPATH_ADMINISTRATOR);

		// $this->value is set if there's a default id specified in the xml file
		$value = (int) $this->value > 0 ? (int) $this->value : '';
        
		// $this->id will be jform_request_xxx where xxx is the name of the field in the xml file
		$modalId = 'questionadd';

		// Add the modal field script to the document head.
		JHtml::_('jquery.framework');
		JHtml::_('script', 'system/modal-fields.js', array('version' => 'auto', 'relative' => true));

		// our callback function from the modal to the main window:
		JFactory::getDocument()->addScriptDeclaration("
			function jSelectQuestion_" . $this->id . "(id, title, catid, object, url, language) {
				window.processModalSelect('Question', '" . $this->id . "', id, title, catid, object, url, language);
			}
			");

		// if a default id is set, then get the corresponding greeting to display it
		if ($value)
		{
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select($db->quoteName('name'))
				->from($db->quoteName('#__question'))
				->where($db->quoteName('id') . ' = ' . (int) $value);
			$db->setQuery($query);

			try
			{
				$title = $db->loadResult();
			}
			catch (RuntimeException $e)
			{
				JError::raiseWarning(500, $e->getMessage());
			}
		}
        
		// display the default greeting or "Select" if no default specified
		$title = empty($title) ? JText::_('COM_JMGQUESTIONNAIRE_ADD_NEW_QUESTION') : htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
		$html  = '<span class="input-append">';
		$html .= '<input class="input-medium" id="' . $this->id . '_name" type="text" value="' . $title . '" disabled="disabled" size="35" />';

		// html for the Select button
		$html .= '<a'
			. ' class="btn hasTooltip' . ($value ? ' hidden' : '') . '"'
			. ' id="' . $this->id . '_select"'
			. ' data-toggle="modal"'
			. ' role="button"'
			. ' href="#ModalSelect' . $modalId . '"'
			. ' title="' . JHtml::tooltipText('COM_JMGQUESTIONNAIRE_ADD_NEW_QUESTION') . '">'
			. '<span class="icon-file" aria-hidden="true"></span> ' . JText::_('JSELECT')
			. '</a>';

		// html for the Clear button
		$html .= '<a'
			. ' class="btn' . ($value ? '' : ' hidden') . '"'
			. ' id="' . $this->id . '_clear"'
			. ' href="#"'
			. ' onclick="window.processModalParent(\'' . $this->id . '\'); return false;">'
			. '<span class="icon-remove" aria-hidden="true"></span>' . JText::_('JCLEAR')
			. '</a>';

		$html .= '</span>';

		// url for the iframe
		$linkQuestions = 'index.php?option=com_jmgquestionnaire&amp;view=question&amp;layout=modal&amp;tmpl=component&amp;' . JSession::getFormToken() . '=1';
		$urlSelect = $linkQuestions . '&amp;function=jSelectQuestion_' . $this->id;
        
		// title to go in the modal header
		$modalTitle    = JText::_('COM_JMGQUESTIONNAIRE_ADD_NEW_QUESTION');
        
		// html to set up the modal iframe
		$html .= JHtml::_(
			'bootstrap.renderModal',
			'ModalSelect' . $modalId,
			array(
				'title'       => $modalTitle,
				'url'         => $urlSelect,
				'height'      => '400px',
				'width'       => '800px',
				'bodyHeight'  => '70',
				'modalWidth'  => '80',
				'footer'      => '<a role="button" class="btn" data-dismiss="modal" aria-hidden="true">' . JText::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</a>',
			)
		);

		// class='required' for client side validation.
		$class = $this->required ? ' class="required modal-value"' : '';

		// hidden input field to store the question record id
		$html .= '<input type="hidden" id="' . $this->id . '_id" ' . $class 
			. ' data-required="' . (int) $this->required . '" name="' . $this->name
			. '" data-text="' . htmlspecialchars(JText::_('COM_JMGQUESTIONNAIRE_ADD_NEW_QUESTION', true), ENT_COMPAT, 'UTF-8') 
			. '" value="' . $value . '" />';

		return $html;
	}

	/**
	 * Method to get the html for the label field.
	 *
	 * @return  string  The field label html.
	 */
	protected function getLabel()
	{
		return str_replace($this->id, $this->id . '_id', parent::getLabel());
	}
}