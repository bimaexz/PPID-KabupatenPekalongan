<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_validation_custom",
		'title' => rl3("Custom Rule"),
		'icon' => 'code',
		'desc' => rl3("Add a custom validation function"),
		'group' => 'validation',
		'category' => rl3("Validation"),
		'triggers' => [],
		'order' => -1,
		"accept" => [
			"ugroups" => ['inputs'],
		],
	];