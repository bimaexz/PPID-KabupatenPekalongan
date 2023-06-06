<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "debug",
		'title' => rl3("Debug"),
		'icon' => 'bug',
		'desc' => rl3("Display Form debug data"),
		'group' => 'data',
		'category' => rl3("Settings"),
		'triggers' => ["section_finish"],
		'order' => -1,
		"accept" => [
			'settings' => true,
		],
	];