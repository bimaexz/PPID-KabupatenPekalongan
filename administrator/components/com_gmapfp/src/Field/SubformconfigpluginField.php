<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_7F
	* Creation date: Janvier 2022
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\GMapFP\Administrator\Field;

\defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormField;

class SubformconfigpluginField extends FormField
{
	protected $type = 'Subform';

	protected $formsource;
	protected $min = 0;
	protected $max = 1000;
	protected $layout = 'joomla.form.field.subform.default';
	protected $groupByFieldset = false;
	protected $buttons = array('add' => true, 'remove' => true, 'move' => true);

	public function __get($name)
	{
		switch ($name)
		{
			case 'formsource':
			case 'min':
			case 'max':
			case 'layout':
			case 'groupByFieldset':
			case 'buttons':
				return $this->$name;
		}

		return parent::__get($name);
	}

	public function __set($name, $value)
	{
		switch ($name)
		{
			case 'formsource':
				$plug_type	= Factory::getApplication()->input->get('plug_type', 'map'); 
				$plug_name	= Factory::getApplication()->input->get('plug_name', 'google'); 
				$this->formsource = Path::clean(JPATH_ROOT . "/plugins/gmapfp-$plug_type/$plug_name/$plug_type.xml");
				break;

			case 'min':
				$this->min = (int) $value;
				break;

			case 'max':
				if ($value)
				{
					$this->max = max(1, (int) $value);
				}
				break;

			case 'groupByFieldset':
				if ($value !== null)
				{
					$value = (string) $value;
					$this->groupByFieldset = !($value === 'false' || $value === 'off' || $value === '0');
				}
				break;

			case 'layout':
				$this->layout = (string) $value;

				// Make sure the layout is not empty.
				if (!$this->layout)
				{
					// Set default value depend from "multiple" mode
					$this->layout = !$this->multiple ? 'joomla.form.field.subform.default' : 'joomla.form.field.subform.repeatable';
				}

				break;

			case 'buttons':

				if (!$this->multiple)
				{
					$this->buttons = array();
					break;
				}

				if ($value && !\is_array($value))
				{
					$value = explode(',', (string) $value);
					$value = array_fill_keys(array_filter($value), true);
				}

				if ($value)
				{
					$value = array_merge(array('add' => false, 'remove' => false, 'move' => false), $value);
					$this->buttons = $value;
				}

				break;

			default:
				parent::__set($name, $value);
		}
	}

	public function setup(\SimpleXMLElement $element, $value, $group = null)
	{
		if (!parent::setup($element, $value, $group))
		{
			return false;
		}

		foreach (array('fieldname', 'formsource', 'min', 'max', 'layout', 'groupByFieldset', 'buttons') as $attributeName)
		{
			$this->__set($attributeName, $element[$attributeName]);
		}

		if ($this->value && \is_string($this->value))
		{
			// Guess here is the JSON string from 'default' attribute
			$this->value = json_decode($this->value, true);
		}

		if (!$this->formsource && $element->form)
		{
			// Set the formsource parameter from the content of the node
			$this->formsource = $element->form->saveXML();
		}

		return true;
	}

	protected function getInput()
	{
		// Prepare data for renderer
		$data    = parent::getLayoutData();
		$tmpl    = null;
		$control = $this->name;

		try
		{
			$tmpl  = $this->loadSubForm();
			$forms = $this->loadSubFormData($tmpl);
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
		}

		$data['tmpl']      = $tmpl;
		$data['forms']     = $forms;
		$data['min']       = $this->min;
		$data['max']       = $this->max;
		$data['control']   = $control;
		$data['buttons']   = $this->buttons;
		$data['fieldname'] = $this->fieldname;
		$data['groupByFieldset'] = $this->groupByFieldset;

		/**
		 * For each rendering process of a subform element, we want to have a
		 * separate unique subform id present to could distinguish the eventhandlers
		 * regarding adding/moving/removing rows from nested subforms from their parents.
		 */
		static $unique_subform_id = 0;
		$data['unique_subform_id'] = ('sr-' . ($unique_subform_id++));

		// Prepare renderer
		$renderer = $this->getRenderer($this->layout);

		// Allow to define some Layout options as attribute of the element
		if ($this->element['component'])
		{
			$renderer->setComponent((string) $this->element['component']);
		}

		if ($this->element['client'])
		{
			$renderer->setClient((string) $this->element['client']);
		}

		// Render
		$html = $renderer->render($data);

		// Add hidden input on front of the subform inputs, in multiple mode
		// for allow to submit an empty value
		if ($this->multiple)
		{
			$html = '<input name="' . $this->name . '" type="hidden" value="">' . $html;
		}

		return $html;
	}

	protected function getName($fieldName)
	{
		$name = '';

		// If there is a form control set for the attached form add it first.
		if ($this->formControl)
		{
			$name .= $this->formControl;
		}

		// If the field is in a group add the group control to the field name.
		if ($this->group)
		{
			// If we already have a name segment add the group control as another level.
			$groups = explode('.', $this->group);

			if ($name)
			{
				foreach ($groups as $group)
				{
					$name .= '[' . $group . ']';
				}
			}
			else
			{
				$name .= array_shift($groups);

				foreach ($groups as $group)
				{
					$name .= '[' . $group . ']';
				}
			}
		}

		// If we already have a name segment add the field name as another level.
		if ($name)
		{
			$name .= '[' . $fieldName . ']';
		}
		else
		{
			$name .= $fieldName;
		}

		return $name;
	}

	public function loadSubForm()
	{
		$control = $this->name;

		if ($this->multiple)
		{
			$control .= '[' . $this->fieldname . 'X]';
		}

		// Prepare the form template
		$formname = 'subform.' . str_replace(array('jform[', '[', ']'), array('', '.', ''), $this->name);
		$tmpl     = Form::getInstance($formname, $this->formsource, array('control' => $control));

		return $tmpl;
	}

	private function loadSubFormData(Form &$subForm)
	{
		$value = $this->value ? (array) $this->value : array();

		// Simple form, just bind the data and return one row.
		if (!$this->multiple)
		{
			$subForm->bind($value);

			return array($subForm);
		}

		// Multiple rows possible: Construct array and bind values to their respective forms.
		$forms = array();
		$value = array_values($value);

		// Show as many rows as we have values, but at least min and at most max.
		$c = max($this->min, min(\count($value), $this->max));

		for ($i = 0; $i < $c; $i++)
		{
			$control  = $this->name . '[' . $this->fieldname . $i . ']';
			$itemForm = Form::getInstance($subForm->getName() . $i, $this->formsource, array('control' => $control));

			if (!empty($value[$i]))
			{
				$itemForm->bind($value[$i]);
			}

			$forms[] = $itemForm;
		}

		return $forms;
	}
}
