<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "delete_files",
		'title' => rl3("Delete Files"),
		'icon' => 'trash',
		'desc' => rl3("Auto Delete file fields with Delete Behavior"),
		'group' => 'data',
		'category' => rl3("Settings"),
		'triggers' => ["event_finish"],
		'order' => 99,
		// 'default' => true,
		"accept" => [
			'settings' => true,
		],
		"paid" => 1,
	];