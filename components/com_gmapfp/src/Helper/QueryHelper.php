<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Database\DatabaseInterface;

/**
 * Content Component Query Helper
 *
 * @since  1.5
 */
class QueryHelper
{
	/**
	 * Translate an order code to a field for primary category ordering.
	 *
	 * @param   string  $orderby  The ordering code.
	 *
	 * @return  string  The SQL field(s) to order by.
	 *
	 * @since   1.5
	 */
	public static function orderbyPrimary($orderby)
	{
		switch ($orderby)
		{
			case 'alpha' :
				$orderby = 'c.path, ';
				break;

			case 'ralpha' :
				$orderby = 'c.path DESC, ';
				break;

			case 'order' :
				$orderby = 'c.lft, ';
				break;

			default :
				$orderby = '';
				break;
		}

		return $orderby;
	}

	/**
	 * Translate an order code to a field for secondary category ordering.
	 *
	 * @param   string             $orderby    The ordering code.
	 * @param   string             $orderDate  The ordering code for the date.
	 * @param   DatabaseInterface  $db         The database
	 *
	 * @return  string  The SQL field(s) to order by.
	 *
	 * @since   1.5
	 */
	public static function orderbySecondary($orderby, $orderDate = 'created', DatabaseInterface $db = null)
	{
		$db = $db ?: Factory::getDbo();

		$queryDate = self::getQueryDate($orderDate, $db);

		switch ($orderby)
		{
			case 'date' :
				$orderby = $queryDate;
				break;

			case 'rdate' :
				$orderby = $queryDate . ' DESC ';
				break;

			case 'alpha' :
				$orderby = 'a.title';
				break;

			case 'ralpha' :
				$orderby = 'a.title DESC';
				break;

			case 'hits' :
				$orderby = 'a.hits DESC';
				break;

			case 'rhits' :
				$orderby = 'a.hits';
				break;

			case 'order' :
				$orderby = 'a.ordering';
				break;

			case 'rorder' :
				$orderby = 'a.ordering DESC';
				break;

			case 'author' :
				$orderby = 'author';
				break;

			case 'rauthor' :
				$orderby = 'author DESC';
				break;

			case 'front' :
				$orderby = 'a.featured DESC, a.ordering, ' . $queryDate . ' DESC ';
				break;

			case 'random' :
				$orderby = $db->getQuery(true)->rand();
				break;

			default :
				$orderby = 'a.ordering';
				break;
		}

		return $orderby;
	}

	/**
	 * Translate an order code to a field for primary category ordering.
	 *
	 * @param   string             $orderDate  The ordering code.
	 * @param   DatabaseInterface  $db         The database
	 *
	 * @return  string  The SQL field(s) to order by.
	 *
	 * @since   1.6
	 */
	public static function getQueryDate($orderDate, DatabaseInterface $db = null)
	{
		$db = $db ?: Factory::getDbo();

		switch ($orderDate)
		{
			case 'modified' :
				$queryDate = ' CASE WHEN a.modified = ' . $db->quote($db->getNullDate()) . ' THEN a.created ELSE a.modified END';
				break;

			// Use created if publish_up is not set
			case 'published' :
				$queryDate = ' CASE WHEN a.publish_up IS NULL THEN a.created ELSE a.publish_up END ';
				break;

			case 'unpublished' :
				$queryDate = ' CASE WHEN a.publish_down IS NULL THEN a.created ELSE a.publish_down END ';
				break;
			case 'created' :
			default :
				$queryDate = ' a.created ';
				break;
		}

		return $queryDate;
	}

}
