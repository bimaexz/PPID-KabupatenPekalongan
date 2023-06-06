<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "data_external_db",
		'title' => rl3("External Database"),
		'icon' => 'database',
		'desc' => rl3("Connect to an external database"),
		'group' => 'configs',
		'category' => rl3("Advanced"),
		'triggers' => ['before_function'],
		'order' => 0,
		//'global' => true,
		"accept" => [
			"functions" => [
				'read_data',
				'delete_data',
				'save_data',
				'sql_data',
			],
		],
		"paid" => 1,
	];