<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Object\CMSObject;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

class FormModel extends \Joomla\Component\Gmapfp\Administrator\Model\ItemModel
{
	public $typeAlias = 'com_gmapfp.item';

	protected function populateState()
	{
		$app = Factory::getApplication();

		// Load state from the request.
		$pk = $app->input->getInt('a_id');
		$this->setState('item.id', $pk);

		$this->setState('item.catid', $app->input->getInt('catid'));

		$return = $app->input->get('return', null, 'base64');
		$this->setState('return_page', base64_decode($return));

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

		$this->setState('layout', $app->input->getString('layout'));
	}

	public function getItem($itemId = null)
	{
		$itemId = (int) (!empty($itemId)) ? $itemId : $this->getState('item.id');

		// Get a row instance.
		$table = $this->getTable();

		// Attempt to load the row.
		$return = $table->load($itemId);

		// Check for a table object error.
		if ($return === false && $table->getError())
		{
			$this->setError($table->getError());

			return false;
		}

		$properties = $table->getProperties(1);
		$value = ArrayHelper::toObject($properties, CMSObject::class);

		// Convert attrib field to Registry.
		$value->params = new Registry($value->attribs);

		// Compute selected asset permissions.
		$user   = Factory::getUser();
		$userId = $user->get('id');
		$asset  = 'com_gmapfp.item.' . $value->id;

		// Check general edit permission first.
		if ($user->authorise('core.edit', $asset))
		{
			$value->params->set('access-edit', true);
		}

		// Now check if edit.own is available.
		elseif (!empty($userId) && $user->authorise('core.edit.own', $asset))
		{
			// Check for a valid user and that they are the owner.
			if ($userId == $value->created_by)
			{
				$value->params->set('access-edit', true);
			}
		}

		// Check edit state permission.
		if ($itemId)
		{
			// Existing item
			$value->params->set('access-change', $user->authorise('core.edit.state', $asset));
		}
		else
		{
			// New item.
			$catId = (int) $this->getState('item.catid');

			if ($catId)
			{
				$value->params->set('access-change', $user->authorise('core.edit.state', 'com_gmapfp.category.' . $catId));
				$value->catid = $catId;
			}
			else
			{
				$value->params->set('access-change', $user->authorise('core.edit.state', 'com_gmapfp'));
			}
		}

		$value->articletext = $value->introtext;

		if (!empty($value->fulltext))
		{
			$value->articletext .= '<hr id="system-readmore">' . $value->fulltext;
		}

		// Convert the metadata field to an array.
		$registry = new Registry($value->metadata);
		$value->metadata = $registry->toArray();

		if ($itemId)
		{
			$value->tags = new TagsHelper;
			$value->tags->getTagIds($value->id, 'com_gmapfp.item');
			$value->metadata['tags'] = $value->tags;
		}

		return $value;
	}

	public function getReturnPage()
	{
		return base64_encode($this->getState('return_page'));
	}

	public function save($data)
	{
		// Associations are not edited in frontend ATM so we have to inherit them
		if (Associations::isEnabled() && !empty($data['id'])
			&& $associations = Associations::getAssociations('com_gmapfp', '#__gmapfp', 'com_gmapfp.item', $data['id']))
		{
			foreach ($associations as $tag => $associated)
			{
				$associations[$tag] = (int) $associated->id;
			}

			$data['associations'] = $associations;
		}

		if (!Multilanguage::isEnabled())
		{
			$data['language'] = '*';
		}

		return parent::save($data);
	}

	protected function preprocessForm(Form $form, $data, $group = 'gmapfp')
	{
		$params = $this->getState()->get('params');

		if ($params && $params->get('enable_category') == 1)
		{
			$form->setFieldAttribute('catid', 'default', $params->get('catid', 1));
			$form->setFieldAttribute('catid', 'readonly', 'true');
		}

		if (!Multilanguage::isEnabled())
		{
			$form->setFieldAttribute('language', 'type', 'hidden');
			$form->setFieldAttribute('language', 'default', '*');
		}

		return parent::preprocessForm($form, $data, $group);
	}

	public function getTable($name = 'Item', $prefix = 'Administrator', $options = array())
	{
		return parent::getTable($name, $prefix, $options);
	}
}
