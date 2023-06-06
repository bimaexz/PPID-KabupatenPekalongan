<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "read_data_limit_offset",
		'title' => rl3("Limit & Offset"),
		'icon' => 'filter',
		'desc' => rl3("Set the returned list limit and offset"),
		'group' => 'data',
		'category' => rl3("Advanced"),
		'triggers' => ['after_function'],
		'order' => -5,
		// 'default' => true,
		"accept" => [
			"functions" => [
				'read_data',
			],
		],
	];