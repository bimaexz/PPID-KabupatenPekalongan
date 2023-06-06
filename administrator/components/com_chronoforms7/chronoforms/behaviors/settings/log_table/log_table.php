<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "log_table",
		'title' => rl3("Log Table"),
		'icon' => 'database',
		'desc' => rl3("Save the form data to a dedicated table"),
		'group' => 'data',
		'category' => rl3("Settings"),
		'triggers' => ["event_finish"],
		'order' => 0,
		// 'default' => true,
		"accept" => [
			'xsettings' => true,
		],
	];