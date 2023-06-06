<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "log_data",
		'title' => rl3("Log Data"),
		'icon' => 'database',
		'desc' => rl3("Save the form data to the Log table"),
		'group' => 'data',
		'category' => rl3("Settings"),
		'triggers' => ["event_finish"],
		'order' => -1,
		// 'default' => true,
		"accept" => [
			'settings' => true,
		],
	];