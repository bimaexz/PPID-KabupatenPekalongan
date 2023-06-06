<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "form_tags",
		'title' => rl3("Form Tags"),
		'icon' => 'tag',
		'desc' => rl3("Set form tags"),
		'group' => 'admin',
		'category' => rl3("Settings"),
		'triggers' => [],
		'order' => 0,
		"accept" => [
			'settings' => true,
		],
	];