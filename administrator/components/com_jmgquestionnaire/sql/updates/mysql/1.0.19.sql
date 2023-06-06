ALTER TABLE `#__jmgquestionnaire_questions` 
	ADD `image_title` text NOT NULL AFTER `image`;
	
ALTER TABLE `#__jmgquestionnaire_answers` 
	ADD `dflt` tinyint(3) NOT NULL DEFAULT 0 AFTER `statement`;