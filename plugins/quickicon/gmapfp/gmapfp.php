<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Quickicon.Downloadkey
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Component\Installer\Administrator\Helper\InstallerHelper as ComInstallerHelper;

/**
 * Joomla! update notification plugin
 *
 * @since  4.0.0
 */
class PlgQuickiconGmapfp extends CMSPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  4.0.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * Application object.
	 *
	 * @var    CMSApplication
	 * @since  4.0.0
	 */
	protected $app;

	/**
	 * Returns an icon definition for an icon which looks for extensions updates
	 * via AJAX and displays a notification when such updates are found.
	 *
	 * @param   string  $context  The calling context
	 *
	 * @return  array  A list of icon definition associative arrays, consisting of the
	 *                 keys link, image, text and access.
	 *
	 * @since   4.0.0
	 */
	public function onGetIcons($context)
	{
		if ($context !== $this->params->get('context', 'site_quickicon')
			|| !$this->app->getIdentity()->authorise('core.manage', 'com_gmapfp')
		)
		{
			return [];
		}

		$iconDefinition = [
			'link'  => 'index.php?option=com_gmapfp',
			'linkadd'  => 'index.php?option=com_gmapfp&view=item&layout=edit',
			'image' => 'fas fa-map-marked-alt',
			'icon'  => '',
			'text'  => Text::_('PLG_QUICKICON_GMAPFP_OK'),
			'group' => 'MOD_QUICKICON_SITE'
		];

		return [
			$iconDefinition
		];
	}

}
