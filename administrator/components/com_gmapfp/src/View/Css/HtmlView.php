<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\GMapFP\Administrator\View\CSS;

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
	protected $categories;
	protected $items;
	protected $pagination;

	protected $state;

	public function display($tpl = null)
	{
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
		$canDo = $this->canDo;
		$user  = Factory::getUser();

		ToolbarHelper::title(Text::_('COM_GMAPFP_CSS_MANAGER'), 'equalizer gmapfp');

		if ($canDo->get('core.edit'))
		{
			ToolbarHelper::apply('css.saveCss', 'JTOOLBAR_APPLY');

		}
	}

}
