<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\GMapFP\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\String\PunycodeHelper;
use Joomla\Component\Categories\Administrator\Helper\CategoriesHelper;
use Joomla\Database\ParameterType;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

class PersonnalisationModel extends AdminModel
{
	protected $text_prefix = 'COM_GMAPFP_PERSONNALISATION';
	public $typeAlias = 'com_gmapfp.personnalisation';

	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			if ($record->published != -2)
			{
				return false;
			}

			return Factory::getUser()->authorise('core.delete', 'com_gmapfp');
		}
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_gmapfp.personnalisation', 'personnalisation', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		if ($this->getState('personnalisation.id'))
		{
			// Existing record. Can only edit in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.edit');
		}
		else
		{
			// New record. Can only create in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.create');
		}

		// Modify the form based on access controls.
		if (!$this->canEditState((object) $data))
		{
			// Disable fields for display.
			$form->setFieldAttribute('state', 'disabled', 'true');

			// Disable fields while saving.
			// The controller has already verified this is a record you can edit.
			$form->setFieldAttribute('state', 'filter', 'unset');
		}

		return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$app  = Factory::getApplication();
		$data = $app->getUserState('com_gmapfp.edit.personnalisation.data', array());

		if (empty($data))
		{
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('personnalisation.id') == 0)
			{
				$filters     = (array) $app->getUserState('com_gmapfp.personnalisations.filter');
			}
		}

		$this->preprocessData('com_gmapfp.personnalisation', $data);

		return $data;
	}

	protected function getReorderConditions($table)
	{
		return array(
			'state >= 0'
		);
	}

	public function save($data)
	{
		$input = Factory::getApplication()->input;

		// Alter the name for save as copy
		if ($input->get('task') == 'save2copy')
		{
			/** @var \Joomla\Component\Banners\Administrator\Table\Banner $origTable */
			$origTable = clone $this->getTable();
			$origTable->load($input->getInt('id'));

			if ($data['nom'] == $origTable->name)
			{
				list($name, $alias) = $this->generateNewTitle('', $data['alias'], $data['nom']);
				$data['nom']       = $name;
			}

			$data['state'] = 0;
		}

		return parent::save($data);
	}
}
