ALTER TABLE `#__jmgquestionnaire_questionnaires` 
	ADD `invitation` tinyint(3) NOT NULL DEFAULT 0 AFTER `anonymous`;

ALTER TABLE `#__jmgquestionnaire_questions` 
	ADD `parentid` int(11) NOT NULL DEFAULT 0 AFTER `questioningid`;
	
ALTER TABLE `#__jmgquestionnaire_surveys` 
	ADD `respondentid` int(10) NOT NULL DEFAULT 0 AFTER `catid`;