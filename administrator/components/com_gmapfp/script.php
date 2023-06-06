<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\Component\Categories\Administrator\Helper\CategoriesHelper;

class com_GMapFPInstallerScript
{
	protected $release;
	
	function install($parent) 
	{
		$path = JPATH_SITE;
		@mkdir(JPATH_ROOT."/images/gmapfp/");		
	}

	function update($parent)
	{
		//mise a jour des table de données
		$db = Factory::getDBO();
	
		$query = $db->getQuery(true);
		//ajout du champ asset_id
		$query = "SHOW COLUMNS FROM `#__gmapfp` LIKE 'asset_id'";
		$db->setQuery( $query );
		$list_id = $db->loadObject();
		if (empty($list_id)) {
			$query = "ALTER TABLE  `#__gmapfp` ADD `asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `id`";
			$db->setQuery($query);
			$db->execute();
		}
		
		$query = $db->getQuery(true);
		//détect table J3 installée
		$query = "SHOW COLUMNS FROM `#__gmapfp` LIKE 'nom'";
		$db->setQuery( $query );
		$list_id = $db->loadObject();
		if (!empty($list_id)) {
			$this->updateJ3_J4();
		}
	}
	
	function updateJ3_J4()
	{
		$db = Factory::getDBO();
		
		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` CHANGE `nom` `title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` CHANGE `alias` `alias` VARCHAR(400) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` CHANGE `pay` `pays` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` CHANGE `img` `img` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` CHANGE `intro` `introtext` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` CHANGE `message` `fulltext` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE  `#__gmapfp` ADD `access` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `catid`";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` CHANGE `published` `state` TINYINT(3) NOT NULL DEFAULT '0';";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `checked_out_time` DATETIME AFTER `checked_out`;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `language` VARCHAR(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `checked_out_time`;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `created` DATETIME NOT NULL AFTER `language`;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` CHANGE `userid` `created_by` INT(10) UNSIGNED NULL DEFAULT '0'";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `created_by_alias` VARCHAR(1255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `created_by`;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `modified` DATETIME NOT NULL AFTER `created_by_alias`;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `modified_by` INT(10) UNSIGNED NULL DEFAULT '0' AFTER `modified`";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `metadata` TEXT DEFAULT NULL AFTER `metakey`";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `featured` int(11) NOT NULL DEFAULT '0' AFTER `ordering`";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `publish_up` DATETIME AFTER `featured`;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `publish_down` DATETIME AFTER `publish_up`;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `attribs` VARCHAR(5120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `publish_down`;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `version` INT(10) UNSIGNED NULL DEFAULT '1' AFTER `attribs`";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `hits` INT(10) UNSIGNED NULL DEFAULT '0' AFTER `version`";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD `note` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' AFTER `hits`;";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD UNIQUE `idx_access` (`access`);";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD UNIQUE `idx_checkout` (`checked_out`);";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD UNIQUE `idx_catid` (`catid`);";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD UNIQUE `idx_createdby` (`created_by`);";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD UNIQUE `idx_featured_catid` (`featured`,`catid`);";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD UNIQUE `idx_language` (`language`);";
		$db->setQuery($query);
		$db->execute();

		$query = $db->getQuery(true);
		$query = "ALTER TABLE `#__gmapfp` ADD UNIQUE `idx_state` (`state`);";
		$db->setQuery($query);
		$db->execute();

	}
	
	function uninstall($parent) 
	{
		$db = Factory::getDBO();

		$query = $db->getQuery(true);
		$query->delete('#__menu');
		$query->where("menutype = 'menu'");
		$query->where('path LIKE '.$db->quote('gmapfp%'));
		$db->setQuery($query);
		$db->execute();

	}
	
	function postflight($type, $parent)
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		if ($type == 'install') {

			//Installation du fichier des images
			$path = JPATH_SITE;
			$foldersource = $path .'/media/com_gmapfp/imagesfolder/';
			$folderdest = $path .'/images/gmapfp/';
			Folder::copy($foldersource, $folderdest, '', true);
			// Folder::delete($foldersource);
			
			//Installation du fichier CSS
			$filesource = $path .'/media/com_gmapfp/css/gmapfp3.css';
			$filedest = $path .'/media/com_gmapfp/css/gmapfp.css';
			File::copy($filesource, $filedest,null);

			$db = Factory::getDBO();
			
			//Insertion des catégories exemples
			$table = array();
			$table['title'] = 'uncategorised';
			$table['parent_id'] = 1;
			$table['extension'] = 'com_gmapfp';
			$table['language'] = '*';
			$table['published'] = 1;
			// Create new category and get catid back
			$catid = CategoriesHelper::createCategory($table);

			//Insertion des exemples
			if (!empty($catid)) {
				$query = $db->getQuery(true);
				$query = "INSERT INTO `#__gmapfp` (`id`, `title`, `alias`, `adresse`, `adresse2`, `ville`, `departement`, `codepostal`, `pays`, `tel`, `email`, `web`, `img`, `introtext`, `fulltext`, `horaires_prix`, `link`, `article_id`, `icon`, `icon_label`, `affichage`, `marqueur`, `glng`, `glat`, `gzoom`, `catid`, `created_by`, `state`, `checked_out`, `metadesc`, `metakey`, `ordering`, `language`, `created`, `modified`, `attribs`, `access`) VALUES
					(1, 'GMapFP d&eacute;veloppement', 'gmapfp-developpement', '', '', 'Fay-aux-Loges', 'Loiret', '45450', 'France', '', 'support@gmapfp.org', 'http://creation-web.pro/', '{\"image\":\"images\\\/gmapfp\\\/logo_gmapfp_developpement.jpg\",\"image_alt\":\"logo GMapFP\",\"image_caption\":\"\"}', '<p>GmapFP D&eacute;veloppement :</p>\r\n<ul>\r\n<li>Cr&eacute;ation de site web dans la r&eacute;gion d''Orl&eacute;ans Est.</li>\r\n<li>Cr&eacute;ation d''extensions Joomla.</li>\r\n</ul>', NULL, '', '', 0, '', '', 0, '1', '2.1462339161', '47.914774458', '11', ".$catid.", 0, 1, 0, 'GmapFP D&#233;veloppement : Cr&#233;ation de site web dans la r&#233;gion d''Orl&#233;ans Est. Cr&#233;ation d''extensions Joomla.', '', 1, '*', '2020-11-01 11:11:11', '2020-11-01 11:11:11', '', '1');";
				$db->setQuery($query);
				$db->execute();
			}			
		}
		if ($type == 'install' OR $type == 'update') {
			$this->affiche_bienvenue($type);
		}
	}
	
	function preflight( $type, $parent ) 
	{
        // Installing component manifest file version
		/*$this->release = $parent->get( "manifest" )->version;
 		die($this->release);*/
	}

	function affiche_bienvenue($type) {
		$lang		= Factory::getLanguage();
		$langue		= substr((@$lang->getTag()),0,2);
		if ($langue!='fr') $langue = 'en';

		if ($langue=='fr') {
			if ($type == 'install') {
				echo "<h1>GMapFP Installation</h1>";
			}else{
				echo "<h1>GMapFP Mise &agrave; jour</h1>";
			};
			?>
			<a href="http://gmapfp.org/fr/" target="_blank"><img src="../images/gmapfp/logo_gmapfp_developpement.jpg" title="Visit&eacute; le site : GMapFP.org" alt="Visit&eacute; le site : GMapFP.org" style="float:left; margin: 2px 25px 2px 0px;"/></a>
			<p>Bienvenue sur GMapFP v<?php echo $this->release?> !</p>
			<p>Avant de commencer, je vous invite, si ce n'est pas d&eacute;j&agrave; fait, &agrave; d&eacute;couvrir toutes les possibilit&eacute;s de se composant et de son ou ses plugins sur son <a target="_blank" href="http://gmapfp.org/fr">Site officiel</a>.<br />
			Vous pourrez y <a target="_blank" href="http://gmapfp.org/fr/telechargement">t&eacute;l&eacute;charger</a> les mise &agrave; jours et consulter le <a target="_blank" href="http://gmapfp.org/fr/forum"> forum</a>.</p>
			<p>Bonne continuation avec GMapFP</p>
			<?php
		} else {
			if ($type == 'install') {
				echo "<h1>GMapFP Installation</h1>";
			}else{
				echo "<h1>GMapFP Upgrade</h1>";
			};
			?>
			<a href="http://gmapfp.org/en/" target="_blank"><img src="../images/gmapfp/logo_gmapfp_developpement.jpg" title="Visited the site : GMapFP.org" alt="Visited the site : GMapFP.org" style="float:left; margin: 2px 25px 2px 0px;"/></a>
			<p>Welcome on v<?php echo $this->release?> GMapFP !</p>
			<p>Before starting, I invite you, if this isn't already made, to discovery all the possibilities of this component and thisd plugin on its <a target="_blank" href="http://www.gmapfp.org/en">Official Site</a>.<br />
			You will be able there to <a target="_blank" href="http://gmapfp.org/en/download">download</a> the update and consult the <a target="_blank" href="http://gmapfp.org/en/forum"> forum</a>.</p>
			<p>Good continuation with GMapFP</p>
			<?php
		}
	}
}