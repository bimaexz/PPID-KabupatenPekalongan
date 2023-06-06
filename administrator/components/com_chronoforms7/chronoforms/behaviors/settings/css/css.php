<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "css",
		'title' => rl3("CSS"),
		'icon' => 'code',
		'desc' => rl3("Add CSS code to all form pages"),
		'group' => 'html',
		'category' => rl3("Settings"),
		'triggers' => ["event_finish"],
		'order' => 0,
		"accept" => [
			'settings' => true,
		],
		"paid" => 1,
	];