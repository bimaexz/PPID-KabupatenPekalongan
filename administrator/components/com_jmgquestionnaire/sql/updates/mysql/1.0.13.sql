ALTER TABLE `#__jmgquestionnaire_questions` 
	ADD `level` int(10) NOT NULL DEFAULT 1 AFTER `parentid`,
	ADD `path` VARCHAR(400) NOT NULL DEFAULT '' AFTER `level`,
	ADD `lft` int(11) NOT NULL DEFAULT 0 AFTER `path`,
	ADD `rgt` int(11) NOT NULL DEFAULT 0 AFTER `lft`,
	ADD `published` tinyint(4) NOT NULL DEFAULT 1 AFTER `rgt`; 
	
ALTER TABLE `#__jmgquestionnaire_questions` 
	CHANGE `parentid` `parent_id` INT(11) NOT NULL DEFAULT '1'; 
