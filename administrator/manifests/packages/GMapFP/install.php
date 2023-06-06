<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_5_0F
	* Creation date: Novembre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

class pkg_gmapfpInstallerScript{

	// Method to run after the install routine.
	function postflight($type, $parent) 
	{
		//active les plugins
		$this->enable_plugins();

		$this->affiche_bienvenue($type);
	}
	
	function update($parent) 
	{
		// echo serialize($parent);
		// echo '<p>The module has been updated to version</p>';
		// echo '<p>The module has been updated to version' . $parent->get('manifest')->version . '.</p>';
	}

	private function enable_plugins()
	{
		$db    = Factory::getDbo();
		
		// plg_content_gmapfp_map
		$query = $db->getQuery(true);
		$fields = array($db->quoteName('enabled') . ' = 1');
		$conditions = array($db->quoteName('name') . ' = ' . $db->quote('plg_content_gmapfp_map'));
		$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$db->execute();
		
		// plg_editor-xtd_gmapfp_map
		$query = $db->getQuery(true);
		$fields = array($db->quoteName('enabled') . ' = 1');
		$conditions = array($db->quoteName('name') . ' = ' . $db->quote('plg_editors-xtd_gmapfp_map'));
		$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$db->execute();
		
		// plg_gmapfp-geocoding_ersi
		$query = $db->getQuery(true);
		$fields = array($db->quoteName('enabled') . ' = 1');
		$conditions = array($db->quoteName('name') . ' = ' . $db->quote('plg_gmapfp-geocoding_ersi'));
		$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$db->execute();
		
		// plg_gmapfp-geocoding_google
		$query = $db->getQuery(true);
		$fields = array($db->quoteName('enabled') . ' = 1');
		$conditions = array($db->quoteName('name') . ' = ' . $db->quote('plg_gmapfp-geocoding_google'));
		$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$db->execute();

		// plg_gmapfp_map_google
		$query = $db->getQuery(true);
		$fields = array($db->quoteName('enabled') . ' = 1');
		$conditions = array($db->quoteName('name') . ' = ' . $db->quote('plg_gmapfp_map_google'));
		$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$db->execute();

		// plg_gmapfp_map_openstreet
		$query = $db->getQuery(true);
		$fields = array($db->quoteName('enabled') . ' = 1');
		$conditions = array($db->quoteName('name') . ' = ' . $db->quote('plg_gmapfp_map_openstreet'));
		$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$db->execute();

		// plg_quickicon_gmapfp
		$query = $db->getQuery(true);
		$fields = array($db->quoteName('enabled') . ' = 1');
		$conditions = array($db->quoteName('name') . ' = ' . $db->quote('plg_quickicon_gmapfp'));
		$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$db->execute();

	}

	function affiche_bienvenue($type) {

		if($type=='install' || $type=='update'){

			// Load language file for module
			$lang		= Factory::getLanguage();
			$langue		= substr((@$lang->getTag()),0,2);
			if ($langue!='fr') $langue = 'en';

			if ($langue=='fr') {
				echo '<h2>Installation de GMapFP : Mise en avant de lieux.</h2>';
				echo "<a href='https://gmapfp.org/fr/'>GMapFP</a> est un composant Joomla vous permettant d'utiliser très facilement des cartes Google / OpenStreetMap ou autres dans votre site.";
			} else {
				echo '<h2>GMapFP installation : Highlighting places.</h2>';
				echo "<a href='https://gmapfp.org/en/'>GMapFP</a> is a Joomla component allowing you to very easily use Google / OpenStreetMap or other maps in your site.";
			}
		}
		return true;
	}
}