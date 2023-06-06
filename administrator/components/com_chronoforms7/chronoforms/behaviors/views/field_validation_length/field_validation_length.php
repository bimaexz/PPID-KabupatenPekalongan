<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_validation_length",
		'title' => rl3("Length"),
		'icon' => 'keyboard',
		'desc' => rl3("Control Characters count"),
		'group' => 'validation',
		'category' => rl3("Validation"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"views" => [
				"field_text",
				"field_password",
				"field_textarea",
			],
		],
	];