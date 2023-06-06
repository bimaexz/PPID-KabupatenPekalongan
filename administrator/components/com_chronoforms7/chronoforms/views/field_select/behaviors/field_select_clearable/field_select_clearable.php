<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_select_clearable",
		'title' => rl3("Clearable"),
		'icon' => 'times circle',
		'desc' => rl3("Enable Clear selections icon"),
		'group' => 'field_select',
		'category' => rl3("Dropdown Settings"),
		'triggers' => ['before_view'],
		'order' => -9,
		"accept" => [
			"views" => [
				"field_select",
			],
		],
	];