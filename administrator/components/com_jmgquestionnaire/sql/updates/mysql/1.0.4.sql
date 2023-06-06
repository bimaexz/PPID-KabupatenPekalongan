ALTER TABLE `#__jmgquestionnaire_answers` 
CHANGE `points` `score` int(10) unsigned NOT NULL DEFAULT 0;

ALTER TABLE `#__jmgquestionnaire_questionnaires` 
	ADD `required_score` int(10) unsigned NOT NULL DEFAULT 0 AFTER `rewardid`;
