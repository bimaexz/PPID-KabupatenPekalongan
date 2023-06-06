<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_5_0F
	* Creation date: Novembre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\GMapFP\Administrator\View\Xtd_button;

defined('_JEXEC') or die;

use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

class HtmlView extends BaseHtmlView
{
	protected $categories;
	protected $items;
	protected $pagination;
	protected $state;

	public function display($tpl = null)
	{
		$this->categories    = $this->get('Categories');
		$this->items         = $this->get('Items');
		$this->pagination    = $this->get('Pagination');
		$this->state         = $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		// We do not need to filter by language when multilingual is disabled
		if (!Multilanguage::isEnabled())
		{
			unset($this->activeFilters['language']);
			// $this->filterForm->removeField('language', 'filter');
		}

		return parent::display($tpl);
	}
}
