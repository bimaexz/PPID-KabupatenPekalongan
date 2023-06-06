ALTER TABLE `#__jmgquestionnaire_questions` 
	ADD `qng4statement` tinyint(3) NOT NULL DEFAULT 0 AFTER `qng5dflt`,
	ADD `qng5statement` tinyint(3) NOT NULL DEFAULT 0 AFTER `qng4statement`,
	ADD `qng4imageyes` VARCHAR(400) NOT NULL DEFAULT '' AFTER `qng5statement`,
	ADD `qng4imageno` VARCHAR(400) NOT NULL DEFAULT '' AFTER `qng4imageyes`,
	ADD `qng5imageyes` VARCHAR(400) NOT NULL DEFAULT '' AFTER `qng4imageno`,
	ADD `qng5imageno` VARCHAR(400) NOT NULL DEFAULT '' AFTER `qng5imageyes`,
	ADD `qng4imageyes_title` text NOT NULL AFTER `qng5imageno`,
	ADD `qng4imageno_title` text NOT NULL AFTER `qng4imageyes_title`,
	ADD `qng5imageyes_title` text NOT NULL AFTER `qng4imageno_title`,
	ADD `qng5imageno_title` text NOT NULL AFTER `qng5imageyes_title`,
	ADD `skip` tinyint(3) NOT NULL DEFAULT 0 AFTER `qng5imageno_title`;