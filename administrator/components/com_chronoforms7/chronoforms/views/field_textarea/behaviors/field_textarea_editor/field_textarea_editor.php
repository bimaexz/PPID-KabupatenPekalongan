<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_textarea_editor",
		'title' => rl3("Rich Text Editor"),
		'icon' => 'bold',
		'desc' => rl3("Enable rich text editing"),
		'group' => 'field_textarea',
		'category' => rl3("Advanced"),
		'triggers' => ['before_view'],
		'order' => -7,
		"accept" => [
			"views" => [
				"field_textarea",
			],
		],
		"paid" => 1,
	];