ALTER TABLE `#__jmgquestionnaire_questionnaires` 
	ADD `annotation` text NOT NULL AFTER `description`,
	ADD `dpid` int(11) NOT NULL DEFAULT 0 AFTER `rewardid`,
	ADD `redirectid` int(11) NOT NULL DEFAULT 0 AFTER `dpid`;