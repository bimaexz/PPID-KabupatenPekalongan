ALTER TABLE `#__jmgquestionnaire_questions` 
	ADD `qng4dflt` tinyint(3) NOT NULL DEFAULT 0 AFTER `questioningid`,
	ADD `qng5dflt` tinyint(3) NOT NULL DEFAULT 0 AFTER `qng4dflt`,
	ADD `page_header` varchar(400) NOT NULL DEFAULT '' AFTER `qng5dflt`,
	ADD `page_description` text NOT NULL AFTER `page_header`,
	ADD `toggle_image` tinyint(3) NOT NULL DEFAULT 0 AFTER `imagepos`,
	ADD `input_type` varchar(10) NOT NULL DEFAULT '' AFTER `alignment`;
	
ALTER TABLE `#__jmgquestionnaire_answers` 
	ADD `image_title` text NOT NULL AFTER `image_alt`;
	
ALTER TABLE `#__jmgquestionnaire_questionnaires` 
	ADD `header_alignment` varchar(10) NOT NULL DEFAULT '' AFTER `style`;