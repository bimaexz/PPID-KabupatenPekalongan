<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\Service;

defined('_JEXEC') or die;

use Joomla\CMS\Categories\Categories;

class Category extends Categories
{
	public function __construct($options = array())
	{
		$options['table']     = '#__gmapfp';
		$options['extension'] = 'com_gmapfp';

		parent::__construct($options);
	}
}
