<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_5F
	* Creation date: Novembre 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Administrator\Extension;

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Association\AssociationServiceInterface;
use Joomla\CMS\Association\AssociationServiceTrait;
use Joomla\CMS\Categories\CategoryServiceInterface;
use Joomla\CMS\Categories\CategoryServiceTrait;
use Joomla\CMS\Component\Router\RouterServiceInterface;
use Joomla\CMS\Component\Router\RouterServiceTrait;
use Joomla\CMS\Extension\BootableExtensionInterface;
use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\HTML\HTMLRegistryAwareTrait;
use Joomla\CMS\Factory;
use Joomla\CMS\Fields\FieldsServiceInterface;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Tag\TagServiceInterface;
use Joomla\CMS\Tag\TagServiceTrait;
use Joomla\CMS\Helper\ContentHelper as LibraryContentHelper;
use Joomla\Component\Gmapfp\Administrator\Service\HTML\AdministratorService;
use Joomla\Component\Gmapfp\Administrator\Service\HTML\Icon;
use Psr\Container\ContainerInterface;

class GmapfpComponent extends MVCComponent implements
	BootableExtensionInterface, CategoryServiceInterface, FieldsServiceInterface, AssociationServiceInterface, RouterServiceInterface,
	TagServiceInterface
{
	use AssociationServiceTrait;
	use RouterServiceTrait;
	use HTMLRegistryAwareTrait;
	use CategoryServiceTrait, TagServiceTrait {
		CategoryServiceTrait::getTableNameForSection insteadof TagServiceTrait;
		CategoryServiceTrait::getStateColumnForSection insteadof TagServiceTrait;
	}

	protected $supportedFunctionality = [
		'core.featured' => true,
		'core.state' => true,
	];

	public function boot(ContainerInterface $container)
	{
		$this->getRegistry()->register('gmapfpadministrator', new AdministratorService);
		$this->getRegistry()->register('gmapfpicon', new Icon($container->get(SiteApplication::class)));
	}

	public function validateSection($section, $item = null)
	{
		if (Factory::getApplication()->isClient('site'))
		{
			// On the front end we need to map some sections
			switch ($section)
			{
				// Editing an item
				case 'form':

					// Category list view
				case 'featured':
				case 'category':
					$section = 'item';
			}
		}

		if ($section != 'item')
		{
			// We don't know other sections
			return null;
		}

		return $section;
	}

	public function getContexts(): array
	{
		Factory::getLanguage()->load('com_gmapfp', JPATH_ADMINISTRATOR);

		$contexts = array(
			'com_gmapfp.item'    => Text::_('COM_GMAPFP'),
			'com_gmapfp.categories' => Text::_('JCATEGORY')
		);

		return $contexts;
	}

/*	public function getModelName($context): string
	{
		$parts = explode('.', $context);

		if (count($parts) < 2)
		{
			return '';
		}

		array_shift($parts);

		$modelname = array_shift($parts);

		if ($modelname === 'item' && Factory::getApplication()->isClient('site'))
		{
			return 'Form';
		}
		elseif ($modelname === 'featured' && Factory::getApplication()->isClient('administrator'))
		{
			return 'Item';
		}

		return ucfirst($modelname);
	}
*/

	public function countItems(array $items, string $section)
	{
		$config = (object) array(
			'related_tbl'    => 'gmapfp',
			'state_col'      => 'state',
			'group_col'      => 'catid',
			'relation_type'  => 'category_or_group',
			'uses_workflows' => false,
		);

		LibraryContentHelper::countRelations($items, $config);
	}

	public function countTagItems(array $items, string $extension)
	{
		$parts   = explode('.', $extension);
		$section = count($parts) > 1 ? $parts[1] : null;

		$config = (object) array(
			'related_tbl'   => ($section === 'category' ? 'categories' : 'gmapfp'),
			'state_col'     => ($section === 'category' ? 'published' : 'state'),
			'group_col'     => 'tag_id',
			'extension'     => $extension,
			'relation_type' => 'tag_assigments',
		);

		LibraryContentHelper::countRelations($items, $config);
	}
}
