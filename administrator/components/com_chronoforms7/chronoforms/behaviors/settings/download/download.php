<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "download",
		'title' => rl3("Download Files"),
		'icon' => 'download',
		'desc' => rl3("Form can download and preview files"),
		'group' => 'tasks',
		'category' => rl3("Settings"),
		'triggers' => ["tasks"],
		'order' => -7,
		'default' => true,
		"accept" => [
			'xsettings' => true,
		],
	];