<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_multiline_options",
		'title' => rl3("Multiline Options"),
		'icon' => 'align-justify',
		'desc' => rl3("Use Classic Multiline options list"),
		'group' => 'configs',
		'category' => rl3("Data"),
		'triggers' => ['before_view'],
		'order' => 0,
		"accept" => [
			"views" => [
				"field_checkboxes",
				"field_radios",
				"field_select",
			],
		],
	];