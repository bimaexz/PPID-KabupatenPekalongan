<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "upload_files",
		'title' => rl3("Upload Files"),
		'icon' => 'upload',
		'desc' => rl3("Auto Upload file fields with Upload Behavior"),
		'group' => 'data',
		'category' => rl3("Settings"),
		'triggers' => ["new_event_start"],
		'order' => -8,
		// 'default' => true,
		"accept" => [
			'settings' => true,
		],
	];