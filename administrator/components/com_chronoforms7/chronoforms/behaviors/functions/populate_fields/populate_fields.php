<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "populate_fields",
		'title' => rl3("Populate Fields"),
		'icon' => 'pen-fancy',
		'desc' => rl3("Load Fields with results"),
		'group' => 'data',
		'category' => rl3("Advanced"),
		'triggers' => ['section_finish'],
		'order' => 0,
		// 'default' => true,
		"accept" => [
			"functions" => [
				'read_data',
				'php',
			],
		],
	];