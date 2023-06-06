ALTER TABLE `#__jmgquestionnaire_respondents` 
	ADD `genderid` tinyint(3) NOT NULL DEFAULT 0 AFTER `userid`,
	ADD `firstname` varchar(400) NOT NULL DEFAULT '' AFTER `genderid`,
	ADD `surname` varchar(400) NOT NULL DEFAULT '' AFTER `firstname`,
	ADD `salutation` varchar(400) NOT NULL DEFAULT '' AFTER `surname`,
	ADD `titlex` varchar(400) NOT NULL DEFAULT '' AFTER `salutation`,
	ADD `street` varchar(400) NOT NULL DEFAULT '' AFTER `titlex`,
	ADD `postal_code` varchar(10) NOT NULL DEFAULT '' AFTER `street`,
	ADD `city` varchar(400) NOT NULL DEFAULT '' AFTER `postal_code`,
	ADD `stateid` varchar(10) NOT NULL DEFAULT '' AFTER `city`,
	ADD `countryid` varchar(3) NOT NULL DEFAULT '' AFTER `stateid`,
	ADD `latitude` float(10,6) default NULL AFTER `countryid`,
	ADD `longitude` float(10,6) default NULL AFTER `latitude`,
	ADD `phone` varchar(50) NOT NULL DEFAULT '' AFTER `longitude`,
	ADD `mobile` varchar(50) NOT NULL DEFAULT '' AFTER `phone`,
	ADD `fax` varchar(50) NOT NULL DEFAULT '' AFTER `mobile`,
	ADD `email` varchar(400) NOT NULL DEFAULT '' AFTER `fax`,
	ADD `website` varchar(400) NOT NULL DEFAULT '' AFTER `email`;
	
ALTER TABLE `#__jmgquestionnaire_respondents`
  	DROP `questionnaireid`,
  	DROP `questionid`,
  	DROP `answerid`;
	
ALTER TABLE `#__jmgquestionnaire_questionnaires`
	ADD `default_fields` text NOT NULL AFTER `params`;