<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_validation_match",
		'title' => rl3("Match"),
		'icon' => 'regular:clone',
		'desc' => rl3("Compare value to another field"),
		'group' => 'validation',
		'category' => rl3("Validation"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"views" => [
				"field_text",
				"field_password",
			],
		],
	];