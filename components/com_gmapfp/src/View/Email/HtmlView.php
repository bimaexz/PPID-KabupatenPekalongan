<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_5_0F
	* Creation date: Novembre 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\View\Email;

defined('_JEXEC') or die;

use Joomla\CMS\Categories\Categories;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;

class HtmlView extends BaseHtmlView
{
	protected $state;
	protected $form;
	protected $item;
	protected $return_page = '';
	protected $captchaEnabled = false;
	protected $params = null;
	protected $user;
	protected $pageclass_sfx = '';

	public function display($tpl = null)
	{
		$app        = Factory::getApplication();
		$this->user       = Factory::getUser();
		// $this->item  		= $this->get('Item');
		$this->state      = $this->get('State');
		$this->form = $this->get('Form');
		$this->params     = $this->state->get('params');

		// Get submitted values
		$data = $app->getUserState('com_gmapfp.email.data', array());

		$app->setUserState('com_gmapfp.email.data', $data);

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		// Check if access is not public
		$groups = $this->user->getAuthorisedViewLevels();

		/*if ((!in_array($item->access, $groups)) || (!in_array($item->category_access, $groups)))
		{
			$app->enqueueMessage(Text::_('JERROR_ALERTNOAUTHOR'), 'error');
			$app->setHeader('status', 403, true);

			return false;
		}*/

		$captchaSet = $this->params->get('captcha', $app->get('captcha', '0'));

		foreach (PluginHelper::getPlugin('captcha') as $plugin)
		{
			if ($captchaSet === $plugin->name)
			{
				$this->captchaEnabled = true;
				break;
			}
		}

		return parent::display($tpl);
	}
}
