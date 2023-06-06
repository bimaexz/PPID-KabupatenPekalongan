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
use Joomla\String\StringHelper;

class MarqueurModel extends AdminModel
{
	protected $text_prefix = 'COM_GMAPFP_MARQUEUR';
	public $typeAlias = 'com_gmapfp.marqueur';

	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			if ($record->state != -2)
			{
				return false;
			}

			return Factory::getUser()->authorise('core.delete', 'com_gmapfp');
		}
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_gmapfp.marqueur', 'marqueur', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		if ($this->getState('marqueur.id'))
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
		$app  = \JFactory::getApplication();
		$data = $app->getUserState('com_gmapfp.edit.marqueur.data', array());

		if (empty($data))
		{
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('marqueur.id') == 0)
			{
				$filters     = (array) $app->getUserState('com_gmapfp.marqueurs.filter');
			}
		}

		$this->preprocessData('com_gmapfp.marqueur', $data);

		return $data;
	}

	protected function getReorderConditions($table)
	{
		return array(
			'state >= 0'
		);
	}

	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk))
		{
			if(substr($item->url,0,2)=='//' or substr($item->url,0,4)=='http') {
				$item->url_externe = $item->url;
				$item->url_interne = '';
				$item->url_type = 0;
			} else {
				$item->url_externe = '';
				$item->url_interne = $item->url;
				$item->url_type = 1;
			}
		}
		
		return $item;
	}
	
	public function save($data)
	{
		$input = Factory::getApplication()->input;

		// Alter the name for save as copy
		if ($input->get('task') == 'save2copy')
		{
			$origTable = clone $this->getTable();
			$origTable->load($input->getInt('id'));
			
			$data['ordering'] = 0;

			if ($data['nom'] == $origTable->nom)
			{
				$data['alias'] = $data['alias'].Factory::getDate()->format('_Y-m-d-H-i-s');
			}

			$data['state'] = 0;
		}

		return parent::save($data);
	}
}
