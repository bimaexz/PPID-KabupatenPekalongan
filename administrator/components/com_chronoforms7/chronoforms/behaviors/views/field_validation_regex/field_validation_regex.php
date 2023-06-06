<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_validation_regex",
		'title' => rl3("RegEx"),
		'icon' => 'question',
		'desc' => rl3("Match value to a Regular Expression"),
		'group' => 'validation',
		'category' => rl3("Validation"),
		'triggers' => [],
		'order' => -5,
		"accept" => [
			"views" => [
				"field_text",
				"field_password",
				"field_textarea",
			],
		],
	];