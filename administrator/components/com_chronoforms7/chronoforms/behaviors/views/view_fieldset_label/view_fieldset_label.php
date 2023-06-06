<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "view_fieldset_label",
		'title' => rl3("FieldSet Label"),
		'icon' => 'font',
		'desc' => rl3("Add a Title Label to the Area"),
		'group' => 'configs',
		'category' => rl3("Style"),
		'triggers' => ['before_view'],
		'order' => -9,
		"accept" => [
			"views" => [
				"area_segment",
				"area_message",
			],
		],
	];