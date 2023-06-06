ALTER TABLE `#__jmgquestionnaire_questionnaires` 
	ADD `numbering` tinyint(3) NOT NULL DEFAULT 1 AFTER `externurl`,
	ADD `style` varchar(10) NOT NULL DEFAULT 'default' AFTER `numbering`,
	ADD `nrbgcolor` varchar(7) NOT NULL DEFAULT '#eeeeee' AFTER `style`,
	ADD `nrtextcolor` varchar(7) NOT NULL DEFAULT '#444444' AFTER `nrbgcolor`; 