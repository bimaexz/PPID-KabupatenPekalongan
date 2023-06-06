<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "set_models_vars",
		'title' => rl3("Set Models Data"),
		'icon' => 'check',
		'desc' => rl3("Set results data as variables"),
		'group' => 'data',
		'category' => rl3("Advanced"),
		'triggers' => ['after_function'],
		'order' => 0,
		// 'default' => true,
		"accept" => [
			"functions" => [
				'read_data',
				'save_data'
			],
		],
	];