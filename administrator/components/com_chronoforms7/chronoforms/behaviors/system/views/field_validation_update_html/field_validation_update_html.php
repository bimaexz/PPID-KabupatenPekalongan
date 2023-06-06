<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_validation_update_html",
		'title' => rl3("Apply Validation data tags"),
		'icon' => 'globe',
		'desc' => rl3("System - Apply Validation Rules to the Field"),
		'group' => 'validation',
		'category' => rl3("Validation"),
		'triggers' => ['before_view_build'],
		'system' => ['views'],
		'hidden' => true,
		'order' => -7,
		"accept" => [
			"ugroups" => ['inputs'],
		],
	];