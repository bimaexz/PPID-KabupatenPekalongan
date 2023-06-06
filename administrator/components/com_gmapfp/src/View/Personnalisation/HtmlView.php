<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\GMapFP\Administrator\View\Personnalisation;

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

class HtmlView extends BaseHtmlView
{
	protected $form;
	protected $item;
	protected $state;
	protected $canDo;

	public function display($tpl = null)
	{
		$this->form  = $this->get('Form');
		$this->item  = $this->get('Item');
		$this->state = $this->get('State');
		$this->canDo = ContentHelper::getActions('com_gmapfp');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		$this->addToolbar();

		return parent::display($tpl);
	}

	protected function addToolbar()
	{
		Factory::getApplication()->input->set('hidemainmenu', true);

		$user       = Factory::getUser();
		$isNew      = ($this->item->id == 0);
		$canDo      = $this->canDo;

		ToolbarHelper::title(
			$isNew ? Text::_('COM_GMAPFP_PERSONNALISATIONS_MANAGER').' => '.Text::_( 'JTOOLBAR_NEW' ) : Text::_('COM_GMAPFP_PERSONNALISATIONS_MANAGER').' => '.Text::_( 'JTOOLBAR_EDIT' ),
			'article gmapfp-personnalisations'
		);

		$toolbarButtons = [];

		// If not checked out, can save the item.
		if ($canDo->get('core.edit') || $canDo->get('core.create'))
		{
			$toolbarButtons[] = ['apply', 'personnalisation.apply'];
			$toolbarButtons[] = ['save', 'personnalisation.save'];
		}

		if ($canDo->get('core.create'))
		{
			$toolbarButtons[] = ['save2new', 'personnalisation.save2new'];
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create'))
		{
			$toolbarButtons[] = ['save2copy', 'personnalisation.save2copy'];
		}

		ToolbarHelper::saveGroup(
			$toolbarButtons,
			'btn-success'
		);

		if (empty($this->item->id))
		{
			ToolbarHelper::cancel('personnalisation.cancel');
		}
		else
		{
			ToolbarHelper::cancel('personnalisation.cancel', 'JTOOLBAR_CLOSE');
		}

	}
}
