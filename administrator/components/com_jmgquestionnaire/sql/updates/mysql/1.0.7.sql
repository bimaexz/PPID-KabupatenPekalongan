ALTER TABLE `#__jmgquestionnaire_surveys` 
	CHANGE `answerid` `answerid` INT(10) NOT NULL DEFAULT '0';

ALTER TABLE `#__jmgquestionnaire_surveys` 
	ADD `answer` text NOT NULL AFTER `answerid`;