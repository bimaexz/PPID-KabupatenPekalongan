<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "read_data_specials",
		'title' => rl3("Special Fields"),
		'icon' => 'wrench',
		'desc' => rl3("Custom data processing fields"),
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
		"paid" => 1,
	];