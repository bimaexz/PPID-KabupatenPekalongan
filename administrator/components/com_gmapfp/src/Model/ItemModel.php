<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_9F
	* Creation date: Octobre 2022
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
use Joomla\Component\Gmapfp\Administrator\Extension\ContentComponent;
use Joomla\Component\Gmapfp\Administrator\Helper\ContentHelper;
use Joomla\CMS\Table\Category;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Table\TableInterface;


class ItemModel extends AdminModel
{
	protected $text_prefix = 'COM_GMAPFP_ITEM';
	public $typeAlias = 'com_gmapfp.item';
	protected $associationsContext = 'com_gmapfp.item';

	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			if ($record->state != -2)
			{
				return false;
			}

			if (!empty($record->catid))
			{
				return Factory::getUser()->authorise('core.delete', 'com_gmapfp.category.' . (int) $record->catid);
			}

			return parent::canDelete($record);
		}
	}

	protected function canEditState($record)
	{
		// Check against the category.
		if (!empty($record->catid))
		{
			return Factory::getUser()->authorise('core.edit.state', 'com_gmapfp.category.' . (int) $record->catid);
		}

		// Default to component settings if category not known.
		return parent::canEditState($record);
	}

	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk))
		{
			// Convert the metadata field to an array.
			$registry = new Registry($item->metadata);
			$item->metadata = $registry->toArray();

			// Convert the images field to an array.
			$registry = new Registry($item->img);
			$item->img = $registry->toArray();

			$item->itemtext = @trim($item->fulltext) != '' ? $item->introtext . "<hr id=\"system-readmore\">" . $item->fulltext : $item->introtext;

			if (!empty($item->id))
			{
				$item->tags = new TagsHelper;
				$item->tags->getTagIds($item->id, 'com_gmapfp.item');
			}
		}

		// Load associated content items
		$assoc = Associations::isEnabled();

		if ($assoc)
		{
			$item->associations = array();

			if ($item->id != null)
			{
				$associations = Associations::getAssociations('com_gmapfp', '#__gmapfp', 'com_gmapfp.item', $item->id);

				foreach ($associations as $tag => $association)
				{
					$item->associations[$tag] = $association->id;
				}
			}
		}

		return $item;
	}

	public function getForm($data = array(), $loadData = true)
	{
		$app  = Factory::getApplication();
		$user = $app->getIdentity();

		// Get the form.
		$form = $this->loadForm('com_gmapfp.item', 'item', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		$jinput = $app->input;

		/*
		 * The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.
		 * The back end uses id so we use that the rest of the time and set it to 0 by default.
		 */
		$id = $jinput->get('a_id', $jinput->get('id', 0));

		// Determine correct permissions to check.
		if ($this->getState('item.id', $id))
		{
			// Existing record. Can only edit in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.edit');

			// Existing record. Can only edit own articles in selected categories.
			if ($app->isClient('administrator'))
			{
				$form->setFieldAttribute('catid', 'action', 'core.edit.own');
			}
			else
			// Existing record. We can't edit the category in frontend if not edit.state.
			{
				if ($id != 0 && (!$user->authorise('core.edit.state', 'com_gmapfp.item.' . (int) $id))
					|| ($id == 0 && !$user->authorise('core.edit.state', 'com_gmapfp')))
				{
					$form->setFieldAttribute('catid', 'readonly', 'true');
					$form->setFieldAttribute('catid', 'filter', 'unset');
				}
			}
		}
		else
		{
			// For new articles we load the potential state + associations
			if ($formField = $form->getField('catid'))
			{
				$assignedCatids = (int) ($data['catid'] ?? $form->getValue('catid'));

				$assignedCatids = is_array($assignedCatids)
					? (int) reset($assignedCatids)
					: (int) $assignedCatids;

				// Try to get the category from the html code of the field
				if (empty($assignedCatids))
				{
					$assignedCatids = $formField->getAttribute('default', null);

					// Choose the first category available
					$xml = new \DOMDocument;
					libxml_use_internal_errors(true);
					$xml->loadHTML($formField->__get('input'));
					libxml_clear_errors();
					libxml_use_internal_errors(false);
					$options = $xml->getElementsByTagName('option');

					if (!$assignedCatids && $firstChoice = $options->item(0))
					{
						$assignedCatids = $firstChoice->getAttribute('value');
					}
				}

				// Activate the reload of the form when category is changed
				$form->setFieldAttribute('catid', 'refresh-enabled', true);
				$form->setFieldAttribute('catid', 'refresh-cat-id', $assignedCatids);
				$form->setFieldAttribute('catid', 'refresh-section', 'item');

				// $workflow = $this->getWorkflowByCategory($assignedCatids);

				// $form->setFieldAttribute('transition', 'workflow_stage', (int) $workflow->stage_id);
			}

			// New record. Can only create in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.create');
		}

		// Prevent messing with article language and category when editing existing article with associations
		$assoc = Associations::isEnabled();

		return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$app  = Factory::getApplication();
		$data = $app->getUserState('com_gmapfp.edit.item.data', array());

		if (empty($data))
		{
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('item.id') == 0)
			{
				$filters     = (array) $app->getUserState('com_gmapfp.items.filter');
				$filterCatId = $filters['category_id'] ?? null;

				$data->set('catid', $app->input->getInt('catid', $filterCatId));
			}
		}

		$this->preprocessData('com_gmapfp.item', $data);

		return $data;
	}

	protected function getReorderConditions($table)
	{
		return array(
			'catid = ' . (int) $table->catid,
			'published >= 0'
		);
	}

	protected function prepareTable($table)
	{
		// Increment the content version number.
		$table->version++;

		// Reorder the articles within the category so the new article is first
		if (empty($table->id))
		{
			$table->reorder('catid = ' . (int) $table->catid . ' AND state >= 0');
		}
	}

	protected function preprocessForm(Form $form, $data, $group = 'content')
	{
		if ($this->canCreateCategory())
		{
			$form->setFieldAttribute('catid', 'allowAdd', 'true');
		}

		parent::preprocessForm($form, $data, $group);
	}

	public function featured($pks, $value = 0)
	{
		// Sanitize the ids.
		$pks = (array) $pks;
		$pks = ArrayHelper::toInteger($pks);

		if (empty($pks))
		{
			$this->setError(Text::_('COM_GMAPFP_NO_ITEM_SELECTED'));

			return false;
		}

		try
		{
			$db = $this->getDbo();
			$query = $db->getQuery(true)
				->update($db->quoteName('#__gmapfp'))
				->set('featured = ' . (int) $value)
				->where('id IN (' . implode(',', $pks) . ')');
			$db->setQuery($query);
			$db->execute();
		}
		catch (\Exception $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		$this->cleanCache();

		return true;
	}

	public function save($data)
	{
		$input = Factory::getApplication()->input;
		$filter = \JFilterInput::getInstance();
		
		if (isset($data['metadata']) && isset($data['metadata']['author']))
		{
			$data['metadata']['author'] = $filter->clean($data['metadata']['author'], 'TRIM');
		}

		if (isset($data['created_by_alias']))
		{
			$data['created_by_alias'] = $filter->clean($data['created_by_alias'], 'TRIM');
		}

		if (isset($data['img']) && is_array($data['img']))
		{
			$registry = new Registry($data['img']);

			$data['img'] = (string) $registry;
		}

		// Create new category, if needed.
		$createCategory = true;
		
		// If category ID is provided, check if it's valid.
		if (is_numeric($data['catid']) && $data['catid'])
		{
			$createCategory = !CategoriesHelper::validateCategoryId($data['catid'], 'com_gmapfp');
		}

		// Check if New Category exists
		// Save New Category
		if ($createCategory && $this->canCreateCategory())
		{
			$table = array();

			// Remove #new# prefix, if exists.
			$table['title'] = strpos($data['catid'], '#new#') === 0 ? substr($data['catid'], 5) : $data['catid'];
			$table['parent_id'] = 1;
			$table['extension'] = 'com_gmapfp';
			$table['language'] = $data['language'];
			$table['published'] = 1;

			// Create new category and get catid back
			$data['catid'] = CategoriesHelper::createCategory($table);
		}

		// Alter the name for save as copy
		if ($input->get('task') == 'save2copy')
		{
			$origTable = clone $this->getTable();
			$origTable->load($input->getInt('id'));

			if ($data['title'] == $origTable->title)
			{
				list($name, $alias) = $this->generateNewTitle($data['catid'], $data['alias'], $data['title']);
				$data['title'] = $name;
				$data['alias'] = $alias;
			}
			else
			{
				if ($data['alias'] == $origTable->alias)
				{
					$data['alias'] = '';
				}
			}

			$data['published'] = 0;
		}

		//traite correctement si lien externe link ou article
		if ($data['select_link_type'] != 1) {
			$data['link'] = "";
		}
		if ($data['select_link_type'] != 2) {
			$data['article_id'] = "";
		}

		return parent::save($data);
	}

	private function canCreateCategory()
	{
		return Factory::getUser()->authorise('core.create', 'com_gmapfp');
	}
}
