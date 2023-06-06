<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_textarea_autoresize",
		'title' => rl3("Auto Expand"),
		'icon' => 'expand',
		'desc' => rl3("Enable Auto rows mode"),
		'group' => 'field_textarea',
		'category' => rl3("Advanced"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"views" => [
				"field_textarea",
			],
		],
	];