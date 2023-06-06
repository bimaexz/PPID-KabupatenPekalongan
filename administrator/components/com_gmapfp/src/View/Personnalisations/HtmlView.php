<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\GMapFP\Administrator\View\Personnalisations;

defined('_JEXEC') or die;

use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Pagination\Pagination;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;

class HtmlView extends BaseHtmlView
{
	protected $items;
	protected $pagination;
	protected $state;

	public function display($tpl = null)
	{
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

		$this->addToolbar();
		$this->sidebar = \JHtmlSidebar::render();

		return parent::display($tpl);
	}

	protected function addToolbar()
	{
		$canDo = ContentHelper::getActions('com_gmapfp');
		$user  = Factory::getUser();

		$toolbar = Toolbar::getInstance('toolbar');
		ToolbarHelper::title(Text::_('COM_GMAPFP_PERSONNALISATIONS_MANAGER'), 'article gmapfp-personnalisations');

		if ($canDo->get('core.create'))
		{
			ToolbarHelper::addNew('personnalisation.add');
		}

		if ($canDo->get('core.edit.state'))
		{
			$dropdown = $toolbar->dropdownButton('status-group')
				->text('JTOOLBAR_CHANGE_STATUS')
				->toggleSplit(false)
				->icon('fa fa-ellipsis-h')
				->buttonClass('btn btn-action')
				->listCheck(true);

			$childBar = $dropdown->getChildToolbar();

			$childBar->publish('personnalisations.publish')->listCheck(true);

			$childBar->unpublish('personnalisations.unpublish')->listCheck(true);

			$childBar->archive('personnalisations.archive')->listCheck(true);

			if ($user->authorise('core.admin'))
			{
				$childBar->checkin('personnalisations.checkin')->listCheck(true);
			}

			if ($this->state->get('filter.state') != -2)
			{
				$childBar->trash('personnalisations.trash')->listCheck(true);
			}

			if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete'))
			{
				$toolbar->delete('personnalisations.delete')
					->text('JTOOLBAR_EMPTY_TRASH')
					->message('JGLOBAL_CONFIRM_DELETE')
					->listCheck(true);
			}
		}

		if ($canDo->get('core.admin') || $canDo->get('core.options'))
		{
			ToolbarHelper::preferences('com_gmapfp');
		}

		// \JToolbarHelper::help('JHELP_COMPONENTS_GMAPFP_PERSONNALISATIONS');
	}

	protected function getSortFields()
	{
		return array(
			'a.state'    => \JText::_('JSTATUS'),
			'a.nom'      => \JText::_('COM_GMAPFP_NOM'),
			'a.id'        => \JText::_('JGRID_HEADING_ID')
		);
	}
}
