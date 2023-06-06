<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "local_vars",
		'title' => rl3("Local Vars"),
		'icon' => 'file-word',
		'desc' => rl3("Set Local unit variables"),
		'group' => 'data',
		'category' => rl3("Settings"),
		'triggers' => ['before_function'],
		'order' => -990,
		'config_order' => 9,
		"accept" => [
			"functions" => true,
		],
	];