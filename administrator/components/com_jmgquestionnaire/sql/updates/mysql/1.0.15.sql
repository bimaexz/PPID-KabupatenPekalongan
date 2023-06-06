ALTER TABLE `#__jmgquestionnaire_questions` 
	ADD `showon` int(11) NOT NULL DEFAULT 0 AFTER `score`,
	ADD `imagepos` varchar(20) NOT NULL DEFAULT '' AFTER `image`;