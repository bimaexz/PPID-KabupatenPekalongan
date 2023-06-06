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
use Joomla\CMS\Language\LanguageHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\Database\ParameterType;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Object\CMSObject;

class ConfigModel extends AdminModel
{
	protected $text_prefix = 'COM_GMAPFP_CONFIG';
	public $typeAlias = 'com_gmapfp.config';

	protected function canEditState($record)
	{
		// Check against the category.
		if (!empty($record->catid))
		{
			return Factory::getUser()->authorise('core.edit.state', 'com_gmapfp');
		}

		// Default to component settings if category not known.
		return parent::canEditState($record);
	}

	public function getItem($pk = null)
	{
		$input = Factory::getApplication()->input;
		$plug_type = $input->get('plug_type', 'map');
		$plug_name = $input->get('plug_name', 'google');

		$plugin = PluginHelper::getPlugin('gmapfp-'.$plug_type, $plug_name);
		$properties = (array) json_decode($plugin->params);

		$item = ArrayHelper::toObject($properties, CMSObject::class);

		return $item;
	}
	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_gmapfp.config', 'config', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		// Existing record. Can only edit in selected categories.
		$form->setFieldAttribute('catid', 'action', 'core.edit');

		return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$app  = Factory::getApplication();
		$data = $app->getUserState('com_gmapfp.edit.config.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		$this->preprocessData('com_gmapfp.config', $data);

		return $data;
	}

	public function save($data)
	{
		$input = Factory::getApplication()->input;
		$params = json_encode($data);
		$plug_type = $input->get('plug_type', 'map');
		$plug_name = $input->get('plug_name');
		
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		// Fields to update.
		$fields = array(
			$db->quoteName('params') . ' = ' . $db->quote($params)
		);
		// Conditions for which records should be updated.
		$conditions = array(
			$db->quoteName('type') . ' = ' . $db->quote('plugin'),
			$db->quoteName('folder') . ' = ' . $db->quote('gmapfp-'.$plug_type),
			$db->quoteName('element') . ' = ' . $db->quote($plug_name),
		);
		$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
		$db->setQuery($query);
		
		$result = $db->execute();		
		
		return $result;
	}

}
