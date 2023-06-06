<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\Dispatcher;

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Dispatcher\ComponentDispatcher;
use Joomla\CMS\Language\Text;
use Joomla\CMS\WebAsset\WebAssetManager;
use Joomla\CMS\Factory;

class Dispatcher extends ComponentDispatcher
{
	public function dispatch()
	{
		$checkCreateEdit = ($this->input->get('view') === 'items' && $this->input->get('layout') === 'modal')
			|| ($this->input->get('view') === 'item' && $this->input->get('layout') === 'pagebreak');

		if ($checkCreateEdit)
		{
			// Can create in any category (component permission) or at least in one category
			$canCreateRecords = $this->app->getIdentity()->authorise('core.create', 'com_gmapfp')
				|| count($this->app->getIdentity()->getAuthorisedCategories('com_gmapfp', 'core.create')) > 0;

			// Instead of checking edit on all records, we can use **same** check as the form editing view
			$values = (array) $this->app->getUserState('com_gmapfp.edit.item.id');
			$isEditingRecords = count($values);
			$hasAccess = $canCreateRecords || $isEditingRecords;

			if (!$hasAccess)
			{
				$this->app->enqueueMessage(Text::_('JERROR_ALERTNOAUTHOR'), 'warning');

				return;
			}
		}
		
		/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
		$doc = Factory::getDocument();
		$wa = $doc->getWebAssetManager();
		$wa	->getRegistry()->addExtensionRegistryFile('com_gmapfp');
		$wa	->useStyle('com_gmapfp.gmapfp')
			->useStyle('com_gmapfp.jquery.fancybox')
			->useScript('com_gmapfp.jquery.fancybox');

		parent::dispatch();
	}
}
