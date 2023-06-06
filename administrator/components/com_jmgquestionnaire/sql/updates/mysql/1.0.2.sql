ALTER TABLE `#__jmgquestionnaire_answers` 
	ADD `points` int(10) unsigned NOT NULL DEFAULT 0 AFTER `questionid`,
	ADD `image_alt` varchar(200) NOT NULL AFTER `image`;
