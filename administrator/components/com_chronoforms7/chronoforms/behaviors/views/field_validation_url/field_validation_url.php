<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_validation_url",
		'title' => rl3("URL"),
		'icon' => 'globe',
		'desc' => rl3("Valid web address is required"),
		'group' => 'validation',
		'category' => rl3("Validation"),
		'triggers' => ['initialize_event','before_view'],
		'order' => -7,
		"accept" => [
			"views" => [
				"field_text",
				"field_password",
			],
		],
	];