<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_validation_numbers",
		'title' => rl3("Number"),
		'icon' => 'calculator',
		'desc' => rl3("Valid number required"),
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