ALTER TABLE `#__jmgquestionnaire_questions` 
	ADD `qng5imageperhaps` VARCHAR(400) NOT NULL DEFAULT '' AFTER `qng5imageno`,
	ADD `qng5imageperhaps_title` text NOT NULL AFTER `qng5imageno_title`;