CREATE TABLE IF NOT EXISTS `#__jmgquestionnaire_invitations` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `state` tinyint(3) NOT NULL DEFAULT 1,
  `questionnaireid` int(10) unsigned NOT NULL DEFAULT 0,
  `invitationid` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL DEFAULT '',
  `checked_out` int(10) unsigned NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_state` (`state`)
) ENGINE=MyISAM CHARACTER SET `utf8` COLLATE `utf8_general_ci`;

ALTER TABLE `#__jmgquestionnaire_surveys` 
	ADD `invitationid` varchar(100) NOT NULL AFTER `uniqueid`;