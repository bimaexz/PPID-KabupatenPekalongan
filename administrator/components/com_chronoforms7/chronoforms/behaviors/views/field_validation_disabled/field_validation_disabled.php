<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_validation_disabled",
		'title' => rl3("Disabled"),
		'icon' => 'question',
		'desc' => rl3("Keep the validation rules in disabled mode"),
		'group' => 'validation',
		'category' => rl3("Validation"),
		'triggers' => ['initialize_event','before_view'],
		'order' => -7,
		"accept" => [
			"ugroups" => ['inputs'],
		],
	];