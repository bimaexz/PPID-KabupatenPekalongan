<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_validation_optional",
		'title' => rl3("Optional"),
		'icon' => 'question',
		'desc' => rl3("Apply rules only when the field is not empty"),
		'group' => 'validation',
		'category' => rl3("Validation"),
		'triggers' => ['initialize_event','before_view'],
		'order' => -7,
		"accept" => [
			"views" => [
				"field_password",
				"field_select",
				"field_text",
				"field_textarea",
			],
		],
	];